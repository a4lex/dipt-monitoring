<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SnmpTemplate extends Model
{
    protected $fillable = [
        'name', 'pname', 'query', 'source', 'shared',
        'vlabel', 'rate', 'type', 'min', 'max',
        'threshold', 'color', 'fill_bg',
    ];

}
