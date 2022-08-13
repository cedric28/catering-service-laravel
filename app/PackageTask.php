<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageTask extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'package_id','creator_id','updater_id'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
