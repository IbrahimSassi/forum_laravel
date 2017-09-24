<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity, Favoritable;
    protected $guarded = [];

    protected $with = ['owner', 'channel'];

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
//        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
//            ->withCount('favorites');
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
        return $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }


}
