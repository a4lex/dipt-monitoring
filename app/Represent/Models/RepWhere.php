<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepWhere extends Model
{
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.wheres');

        parent::__construct($attributes);
    }

}
