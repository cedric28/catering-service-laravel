<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    public function planners()
    {
        return $this->hasMany(Planner::class,'payment_status_id','id');
    }
}
