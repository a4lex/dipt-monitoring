<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SnmpTemplate extends Model
{
    protected $fillable = [
        'name', 'query', 'source', 'shared', 'vlabel',
        'rate', 'type', 'min', 'max',
        'threshold', 'color', 'line', 'format',
    ];

}
