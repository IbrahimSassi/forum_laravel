<?php
/**
 * Created by PhpStorm.
 * User: Ibrahim
 * Date: 16/09/2017
 * Time: 13:37
 */

namespace App;


trait Favoritable
{

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite($userId)
    {

        $attributes = [
            'user_id' => $userId,
        ];
        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function isFavorited()
    {
        return $this->favorites->where('user_id', auth()->id())->count();
    }
}