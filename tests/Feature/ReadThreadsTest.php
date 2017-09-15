<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ReadThreadsTest extends TestCase
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
    public function a_user_can_browse_threads()
    {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);
//        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_see_a_single_thread()
    {

        $response = $this->get($this->thread->path());

        $response->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {

        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);

    }

    /** @test */
    function aUserCanFilterThreadsByChannel()
    {

        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class, ['channel_id' => 999]);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }


    /** @test */
    function aUserCanFilterThreadsByUsername()
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);
        $otherThread = create(Thread::class);

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($otherThread->title);
    }


    /** @test */
    function aUserFilterThreadByPopularity()
    {

        //Given , 3 threads
        //With 2 rep,3rep and 0 rep respec

        $threadWith3Replies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWith3Replies->id], 3);

        $threadWith2Replies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWith2Replies->id], 2);

        $threadWith0Replies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
