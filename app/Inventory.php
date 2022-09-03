<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function inventory_category()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function package_equipments()
    {
        return $this->hasMany(PackageEquipments::class,'inventory_id','id');
    }
}
