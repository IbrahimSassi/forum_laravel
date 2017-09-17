<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use phpDocumentor\Reflection\Types\Integer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageThreadTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    public function guestsMayNotCreateAThread()
    {

        $this->withExceptionHandling();

        $this->get('/threads/create')->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    public function anAuthenticatedUserCanCreateNewForumThread()
    {
//        given , we have signed in user
//        $this->actingAs(create(User::class));
        $this->signIn();


        $thread = make(Thread::class);
//        when we hit  the endpoint to create a new thread

        $response = $this->post('/threads', $thread->toArray());

//        dd($response->headers->get('Location'));
//        Then , when we visit the thread page
        $this->get($response->headers->get('Location'))
//        We , Should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }


    /** @test */
    function aThreadRequiresATitle()
    {
        $this->publishAThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function aThreadRequiresABody()
    {
        $this->publishAThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function aThreadRequiresAValidChannelId()
    {
        factory(Channel::class, 2)->create();

        $this->publishAThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishAThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }


    /** @test */
    function unauthorisedUsersMayNotDeleteThreads()
    {
        $thread = create(Thread::class);
        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);

    }


    /** @test */
    function ThreadsMayOnlyBeDeletedByThoseWhoHavePermission()
    {
        //TODO
    }


    /** @test */
    function authorisedUsersCanDeleteThreads()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $reply = create(Reply::class, ['thread_id' => $thread->id]);

//        dd(['user_id' => auth()->id() , 'threadUserId' => $thread->user_id]);
        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);


//        $this->assertDatabaseMissing('activities', [
//            'subject_id' => $thread->id,
//            'subject_type' => get_class($thread)
//        ]);
//        $this->assertDatabaseMissing('activities', [
//            'subject_id' => $reply->id,
//            'subject_type' => get_class($reply)
//        ]);

        //Or
        $this->assertEquals(0,Activity::count());
    }


    public function publishAThread($overrides)
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());


    }
}
