<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    protected $fillable = ['name'];

    public $pivotes = ['snmp_templates', ];

    public function snmp_templates()
    {
        return $this->belongsToMany('App\SnmpTemplate');
    }
}
