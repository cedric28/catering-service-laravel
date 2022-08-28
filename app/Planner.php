<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planner extends Model
{
    use SoftDeletes;

    public function scopeOnGoing($query)
    {
        return $query->where('status', '=', 'on-going');
    }

    public function scopeDone($query)
    {
        return $query->where('status', '=', 'done');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function package_menus()
    {
        return $this->belongsToMany('App\PackageMenu');
    }
}
