<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    public function guestsMayNotCreateAThread()
    {

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = factory(Thread::class)->make();

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function anAuthenticatedUserCanCreateNewForumThread()
    {
//        given , we have signed in user
        $this->actingAs(factory(User::class)->create());

//        when we hit  the endpoint to create a new thread

        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());

//        Then , when we visit the thread page
        $this->get($thread->path())
//        We , Should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
