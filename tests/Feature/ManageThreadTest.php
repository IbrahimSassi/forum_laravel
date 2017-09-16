<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
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
    function GuestCannotDeleteThreads()
    {
//        $this->withExceptionHandling();
        $thread = create(Thread::class);
        $response = $this->delete($thread->path());
        $response->assertRedirect('/login');

    }


    /** @test */
    function ThreadsMayOnlyBeDeletedByThoseWhoHavePermission(){
        //TODO
    }


    /** @test */
    function deleteAThread()
    {
        $this->signIn();
        $thread = create(Thread::class);

        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }


    public function publishAThread($overrides)
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());


    }
}