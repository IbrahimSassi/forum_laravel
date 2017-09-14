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

//        when we hit  the endpoint to create a new thread

        $thread = create(Thread::class);
        $this->post('/threads', $thread->toArray());

//        dd($thread);
//        Then , when we visit the thread page
        $this->get($thread->path())
//        We , Should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }


}
