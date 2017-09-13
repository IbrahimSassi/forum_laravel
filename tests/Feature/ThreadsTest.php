<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function a_user_can_browse_threads()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads');

        $response->assertSee($thread->title);
//        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_see_a_single_thread()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads/' . $thread->id);

        $response->assertSee($thread->title);
    }
}
