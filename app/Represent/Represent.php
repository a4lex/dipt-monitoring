<?php


namespace App\Represent;

use DB;

class Represent
{

    public static function from()
    {
        $type  = config('represent.storage_type');
        $storages = config('represent.storages');
        $args = func_get_args();

        return call_user_func_array([$storages[$type], 'create'], $args);
    }

}
