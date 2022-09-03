<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerOther extends Model
{   
    public function planner()
    {
        return $this->belongsTo(Planner::class, 'planner_id');
    }
    
    public function package_other()
    {
        return $this->belongsTo(PackageOther::class, 'package_other_id');
    }
}
