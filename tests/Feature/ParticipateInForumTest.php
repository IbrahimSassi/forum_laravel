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
}
