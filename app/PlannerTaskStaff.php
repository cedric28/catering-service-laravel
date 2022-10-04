<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerTaskStaff extends Model
{
    //
    public function planner_task()
    {
        return $this->belongsTo(PlannerTask::class, 'planner_task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task_staff_notifications()
    {
        return $this->hasMany(TaskStaffNotification::class, 'planner_task_staff_id', 'id');
    }
}
