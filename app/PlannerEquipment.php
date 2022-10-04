<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerEquipment extends Model
{
    public function package_equipment()
    {
        return $this->belongsTo(PackageEquipments::class, 'package_equipment_id');
    }
}
