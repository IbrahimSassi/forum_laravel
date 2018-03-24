<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use App\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
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
    function aThreadCanMakeAStringPath()
    {
        $thread = create(Thread::class);

        $this->assertEquals('/threads/'.$thread->channel->slug.'/'.$thread->id, $thread->path());

    }

    /** @test */
    public function aThreadHasACreator()
    {

        $this->assertInstanceOf(User::class, $this->thread->owner);
    }

    /** @test */
    public function aThreadCanAddAReply()
    {
        $this->thread->addReply([
            'body' => 'FooBar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    function aThreadBelongsToAChannel()
    {

        $thread = create(Thread::class);

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test */
    function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'Foobar',
                'user_id' => 999,
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }


    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $user = auth()->user();
        $this->assertTrue($thread->hasUpdatesFor($user));
        $user->read($thread);
        $this->assertFalse($thread->hasUpdatesFor($user));


    }


}
