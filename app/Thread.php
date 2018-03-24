<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity, Favoritable;
    protected $guarded = [];

    protected $with = ['owner', 'channel'];
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();
//        Commenting This because we added a specific column for replies count
//        static::addGlobalScope('replyCount', function ($builder) {
//            $builder->withCount('replies');
//        });

//        Another option to delete replies related to a thread
        static::deleting(function ($thread) {
//           $thread->replies()->delete();

            //This
            /*
            $thread->replies->each(function ($reply) {
                $reply->delete();
            });
            */

            //Can be Replaced By This
            $thread->replies->each->delete();
        });


    }


    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

//        event(new ThreadHasNewReply($this, $reply));
        $this->notifySubscribers($reply);

        return $reply;

    }


    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where(
            'user_id', $userId ?: auth()->id()
        )->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }


    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return boolean
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * @param $reply
     */
    protected function notifySubscribers($reply)
    {
        $this->subscriptions
            ->where('user_id', '!=', $reply->user_id)
            ->each
            ->notify($reply);
    }

    public function hasUpdatesFor($user = null)
    {
        $user = $user ?: auth()->user();

        return $this->updated_at > cache($user->visitedThreadCacheKey($this));
    }


}
