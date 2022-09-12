<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStaffNotification extends Model
{
    public function planner_task_staff()
    {
        return $this->belongsTo(PlannerTaskStaff::class, 'planner_task_staff_id');
    }
}
