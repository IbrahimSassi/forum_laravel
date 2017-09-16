<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable;

    protected $guarded = [];

//    protected $withCount = ['favorites'];
    protected $with = ['owner', 'favorites'];


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
