<?php


namespace App\Represent\Casts;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Hash;

class HashedPassword implements CastsAttributes
{


    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return preg_match('/^\$2y\S{57}$/', $value)
            ? $value
            : Hash::make($value);
    }
}
