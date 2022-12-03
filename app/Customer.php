<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    public function planners()
    {
        return $this->hasMany(Planner::class, 'customer_id', 'id');
    }
}
