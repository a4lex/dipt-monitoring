<?php

namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepColumn extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'id', 'model_id', 'type_id', 'name', 'alias',
        'label', 'def_value', 'popup_values', 'sort',
        'singular', 'required', 'orderable', 'styles',
        'rules', 'searchable',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.columns');

        parent::__construct($attributes);
    }

    public function type()
    {
        return $this->belongsTo(RepColumnType::class);
    }

    public function options()
    {
        return $this->hasMany(RepColumnOption::class, 'column_id');
    }

    public function visibility()
    {
        return $this->hasMany(RepColumnVisibility::class, 'column_id');
    }
}
