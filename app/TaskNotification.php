<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskNotification extends Model
{
    public function planner_staffing()
    {
        return $this->belongsTo(PlannerStaffing::class, 'planner_staffing_id');
    }
}
