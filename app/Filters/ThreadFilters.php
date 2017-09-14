<?php

/**
 * Created by PhpStorm.
 * User: Ibrahim
 * Date: 14/09/2017
 * Time: 19:47
 */

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{

    protected $filters = ['by'];


    /**
     * Filter the query by a given username
     * @param $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}