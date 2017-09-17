<?php

namespace Tests\Feature;

use App\Activity;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    public function it_recordsActivityWhenAthreadIsCreated()
    {

        $this->signIn();
        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }


    /** @test */
    function itRecordsActivitiesWhenAReplyIsCreated()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->assertEquals(2, Activity::count());

    }

    /** @test */
    function itFetchesAFeedForAnyUser()
    {
        $this->signIn();

        create(Thread::class, ['user_id' => auth()->id()], 2);


        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        $feed = Activity::feed(auth()->user(), 50);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));


        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
