<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepModel extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'alias', 'col_id', 'col_val', 'controller',
        'id', 'label', 'model', 'name', 'ref_table'
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.models');

        parent::__construct($attributes);
    }

    public function columns()
    {
        return $this->hasMany(RepColumn::class, 'model_id');
    }

    public function joins()
    {
        return $this->hasMany(RepJoin::class, 'model_id');
    }

    public function wheres()
    {
        return $this->hasMany(RepWhere::class, 'model_id');
    }

    public function actions()
    {
        return $this->hasMany(RepAction::class, 'model_id');
    }
}
