<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerStaffing extends Model
{
    //

    public function planner()
    {
        return $this->belongsTo(Planner::class, 'planner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task_notifications()
    {
        return $this->hasMany(TaskNotification::class,'planner_staffing_id','id');
    }
}
