<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepAction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id', 'model_id', 'role_id', 'name', 'state',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.actions');

        parent::__construct($attributes);
    }
}
