<?php

namespace App;

use App\Represent\Casts\IpAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MtBoard extends Model
{
    protected $fillable = [
        'name', 'last_ip', 'username', 'password',
        'community', 'location1', 'location2',
        'lat', 'lon', 'sn', 'model', 'version', 'firmware',
    ];

    protected $casts = [
        'last_ip' => IpAddress::class,
    ];

    public function wireslessIfaces()
    {
        return $this->hasMany(MtIface::class);
    }

    public static function getAllPasswords()
    {
        return MtBoard::select('password', DB::raw('COUNT(*) AS size'))
            ->groupBy('password')
            ->orderBy('size', 'desc')
            ->pluck('password');
    }
}
