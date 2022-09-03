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
}
