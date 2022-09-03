<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }

    public function planner()
    {
        return $this->belongsTo(Planner::class, 'planner_id');
    }
}
