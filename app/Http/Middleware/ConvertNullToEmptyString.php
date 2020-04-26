<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertNullToEmptyString extends TransformsRequest
{
    protected $except = [];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {

        return  !in_array($key, $this->except) && $value == null
            ? ''
            : $value;
    }
}
