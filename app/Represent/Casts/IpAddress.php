<?php


namespace App\Represent\Casts;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class IpAddress implements CastsAttributes
{


    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return preg_match('/^\d+$/', $value) ?
            long2ip($value) :
            $value;
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return preg_match('/^\d+$/', $value) ?
            $value :
            ip2long($value);
    }
}
