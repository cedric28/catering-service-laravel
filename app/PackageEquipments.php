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

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function planner_equipments()
    {
        return $this->hasMany(PlannerEquipment::class,'package_equipment_id','id');
    }
}
