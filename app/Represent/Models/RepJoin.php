<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepJoin extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'model_id', 'type', 'ref_table', 'alias', 'col_a', 'col_b', 'mode',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.joins');

        parent::__construct($attributes);
    }
}
