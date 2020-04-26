<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepColumnType extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'view', ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.column_types');

        parent::__construct($attributes);
    }
}
