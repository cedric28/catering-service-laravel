<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerTask extends Model
{
    public function planner()
    {
        return $this->belongsTo(Planner::class, 'planner_id');
    }

    public function package_task()
    {
        return $this->belongsTo(PackageTask::class, 'package_task_id');
    }

    public function planner_task_staffs()
    {
        return $this->hasMany(PlannerTaskStaff::class, 'planner_task_id', 'id');
    }
}
