<?php

namespace Tests\Feature;

use App\Channel;
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
        $this->publish(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function aThreadRequiresABody()
    {
        $this->publish(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function aThreadRequiresAValidChannelId()
    {
        factory(Channel::class, 2)->create();

        $this->publish(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publish(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }


    public function publish($overrides)
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());


    }
}
