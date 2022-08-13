<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainPackage extends Model
{
    public function main_packages()
    {
        return $this->hasMany(Package::class,'main_package_id','id');
    }
}
