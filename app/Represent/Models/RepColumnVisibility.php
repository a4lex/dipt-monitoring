<?php


namespace App\Represent\Models;

use Illuminate\Database\Eloquent\Model;

class RepColumnVisibility extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id', 'user_id', 'column_id', 'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('represent.table.column_visibility');

        parent::__construct($attributes);
    }

    public function save(array $options = array())
    {
        $this->user_id = auth()->id();
        parent::save($options);
    }
}
