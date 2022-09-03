<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageOther extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name','service_price','package_id','creator_id','updater_id'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function planner_others()
    {
        return $this->hasMany(PlannerOther::class,'package_other_id','id');
    }
}
