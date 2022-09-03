<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerTimeTable extends Model
{
    public function planner()
    {
        return $this->belongsTo(Planner::class,'planner_id');
    }
}
