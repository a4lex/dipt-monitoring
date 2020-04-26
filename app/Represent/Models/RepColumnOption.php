<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepColumnOption extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'id', 'column_id', 'role_id', 'editable', 'visible',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.column_options');

        parent::__construct($attributes);
    }
}
