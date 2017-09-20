<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    function UnauthenticatedUsersMayNotAddReplies()
    {

        $this->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');

    }

    /** @test */
    public function AnAuthenticatedUserMayParticipateInForumThreads()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->make();
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }


    /** @test */
    function aReplyRequiresABody()
    {
        $this->withExceptionHandling()->signIn();
        $thread = factory(Thread::class)->create();

        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');

    }

    /** @test */
    function unauthorisedUserCannotDeleteReply()
    {

//        $this->withExceptionHandling();


        $reply = create(Reply::class);
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');


        //we create a reply and then you want to delete a reply that u didnt create
        $reply2 = create(Reply::class);
        $this->signIn()
            ->delete("/replies/{$reply2->id}")
            ->assertStatus(403);
    }


    /** @test */
    function AuthorisedUserCanDeleteAReply()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this
            ->delete("/replies/{$reply->id}");
        $this->assertDatabaseMissing('replies', ["id" => $reply->id]);

    }
}
