<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait SNMPTemplates
{
    public function getChartsMaps()
    {
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
