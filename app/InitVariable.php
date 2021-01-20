<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InitVariable extends Model
{
    protected $fillable = [
        'device_type_id', 'name', 'query', 'default_value',
    ];
}
