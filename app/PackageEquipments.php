<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageEquipments extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inventory_id','quantity','package_id','creator_id','updater_id'
    ];

    public function package_equipment()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
