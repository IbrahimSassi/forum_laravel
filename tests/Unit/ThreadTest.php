<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function aThreadHasReplies()
    {


        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function aThreadHasACreator()
    {

        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function aThreadCanAddAReply()
    {
        $this->thread->addReply([
            'body' => 'FooBar',
            'user_id' => 1
        ]);

        $this->assertCount(1,$this->thread->replies);
    }

}
