<?php

namespace App;

use App\Traits\ManyToManyRelation;
use App\Traits\SNMPTemplates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeviceTypeIfaceType extends Model
{
    use ManyToManyRelation, SNMPTemplates;

    public $relations = ['snmp_templates'];

    public $timestamps = false;

    protected $fillable = ['device_type_id', 'iface_type_id'];

    public function snmp_templates()
    {
        return $this->belongsToMany(
            'App\SnmpTemplate',
            'iface_type_snmp_template',
            'dev_iface_type_id'
        );
    }
}
