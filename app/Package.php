<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    
    public function main_package()
    {
        return $this->belongsTo(MainPackage::class, 'main_package_id');
    }

    public function package_tasks()
    {
        return $this->hasMany(PackageTask::class,'package_id','id');
    }

    public function package_foods()
    {
        return $this->hasMany(PackageMenu::class,'package_id','id');
    }

    public function package_others()
    {
        return $this->hasMany(PackageOther::class,'package_id','id');
    }
}
