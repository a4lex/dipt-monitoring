<?php

namespace App;

use App\Traits\ManyToManyRelation;
use App\Traits\SNMPTemplates;
use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    use ManyToManyRelation, SNMPTemplates;

    public $relations = ['snmp_templates'];

    protected $fillable = ['name', 'snmp_version'];

    public function snmp_templates()
    {
        return $this->belongsToMany('App\SnmpTemplate');
    }
}
