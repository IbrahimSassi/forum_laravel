<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable, RecordsActivity;

    protected $guarded = [];


//    protected $withCount = ['favorites'];
    protected $with = ['owner', 'thread'];
    protected $appends = ['favoritesCount', 'isFavorited'];


    /**
     * Boot the reply instance.
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });
        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }



    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }


    public function path()
    {
        return $this->thread->path() . "#reply-" . $this->id;
    }

}
