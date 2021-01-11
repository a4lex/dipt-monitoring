<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeviceType extends Model
{
    protected $fillable = ['name', 'snmp_version'];

    public $pivotes = ['snmp_templates', ];

    public function snmp_templates()
    {
        return $this->belongsToMany('App\SnmpTemplate');
    }

    public function getChartsMaps() {
        return $this->snmp_templates()
            ->select(DB::raw('GROUP_CONCAT(name) as names'), 'vlabel')
            ->groupBy('shared')
            ->get(['names', 'vlabel'])
            ->makeHidden('pivot')
            ->map(function ($var) {
                $var->names = explode(',', $var->names);
                return $var;
            })
            ->toJson();
    }
}
