<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepWhere extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'model_id', 'role_id', 'col_a', 'col_b', 'mode', 'boolean',
    ];
    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.wheres');

        parent::__construct($attributes);
    }

}
