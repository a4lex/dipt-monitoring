<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtIface extends Model
{

    protected $fillable = [
        'mt_board_id', 'name', 'radio_name',
        'mode', 'frequency', 'ch_width',
        'mac', 'height', 'azimuth',
    ];

    public function board()
    {
        return $this->belongsTo(MtBoard::class);
    }
}
