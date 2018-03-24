<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }


    /**
     * @param User $user
     * @param int $take
     *
     * @return mixed
     */
    public static function feed($user, $take = 50)
    {
        return $user->activities()
            ->latest()
            ->with(['subject'])
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });

    }
}
