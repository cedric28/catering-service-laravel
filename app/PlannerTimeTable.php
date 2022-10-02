<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlannerTimeTable extends Model
{
    protected $fillable = [
        'planner_id', 'task_name', 'task_time',
    ];
    public function planner()
    {
        return $this->belongsTo(Planner::class,'planner_id');
    }
}
