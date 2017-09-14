<?php
/**
 * Created by PhpStorm.
 * User: Ibrahim
 * Date: 14/09/2017
 * Time: 20:08
 */

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $builder;
    protected $filters = [];

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

//        dd($this->getFilters());

        //Functional approach
        $this->getFilters()
            ->filter(function ($value,$filter){
                return method_exists($this,$filter);
            })
            ->each(function ($value,$filter){
                $this->$filter($value);
            });

        //Imperative Approach
//        foreach ($this->getFilters() as $filter => $value) {
//            if (method_exists($this, $filter))
//                $this->$filter($value);
//        }

        return $this->builder;

    }


    public function getFilters()
    {
        return collect($this->request->intersect($this->filters));
    }


}