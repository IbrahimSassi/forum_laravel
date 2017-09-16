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
        $user = create(User::class);
        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }


    /** @test */
    function profilesDisplayAllThreadsCreatedByTheAssociatedUser()
    {
        $user = create(User::class);
        $thread = create(Thread::class, ['user_id' => $user->id]);
        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }


}
