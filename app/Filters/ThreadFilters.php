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

class ThreadFilters
{
    protected $builder;
    /**
     * @var Request
     */
    protected $request;


    /**
     * ThreadFilters constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function apply($builder)
    {
        //we apply our filters to the builder

        $this->builder = $builder;

        if ($this->request->has('by'))
            $this->filterBy($this->request->by);

        return $this->builder;

    }

    /**
     * @param $username
     * @return mixed
     */
    public function filterBy($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}