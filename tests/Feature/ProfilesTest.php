<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    public function aUserHasAProfil()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $this->get("/profiles/" . auth()->user()->name)
            ->assertSee(auth()->user()->name);
    }


    /** @test */
    function profilesDisplayAllThreadsCreatedByTheAssociatedUser()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $this->get("/profiles/" . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }


}
