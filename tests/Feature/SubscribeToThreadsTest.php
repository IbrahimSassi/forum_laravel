<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        // Given we have a thread...
        $thread = create(Thread::class);
        // And the user subscribes to the thread...
//        dd($thread->path() . '/subscriptions');
        $this->post($thread->path() . '/subscriptions');
        $this->assertCount(1, $thread->subscriptions);


        // Then, each time a new reply is left...
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        // A notification should be prepared for the user.
         $this->assertCount(1, auth()->user()->notifications);
    }


}
