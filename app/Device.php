<?php

namespace App;

use App\Represent\Casts\IpAddress;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_type_id', 'name', 'ip', 'username', 'password',
        'community', 'model', 'firmware', 'location1', 'location1', 'mac',
    ];

    protected $casts = [
        'ip' => IpAddress::class,
    ];
}
