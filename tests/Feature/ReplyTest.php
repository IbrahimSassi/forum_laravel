<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }



    /** @test */
    public function itHasAnOwner()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);
        $this->assertInstanceOf(User::class, $reply->owner);

    }
}
