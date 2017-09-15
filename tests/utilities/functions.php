<?php
/**
 * Created by PhpStorm.
 * User: Ibrahim
 * Date: 14/09/2017
 * Time: 14:33
 */


function create($class, $attributes = [], $times = null)
{

    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}