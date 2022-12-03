<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planner extends Model
{
    use SoftDeletes;

    public function scopeOnGoing($query)
    {
        return $query->where('status', '=', 'on-going');
    }

    public function scopeDone($query)
    {
        return $query->where('status', '=', 'done');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function package_menus()
    {
        return $this->belongsToMany('App\PackageMenu', 'package_menu_planner');
    }

    public function planner_tasks()
    {
        return $this->hasMany(PlannerTask::class, 'planner_id', 'id');
    }

    public function planner_others()
    {
        return $this->hasMany(PlannerOther::class, 'planner_id', 'id');
    }

    public function planner_time_tables()
    {
        return $this->hasMany(PlannerTimeTable::class, 'planner_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'planner_id', 'id');
    }

    public function payment_status()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function planner_staffing()
    {
        return $this->hasMany(PlannerStaffing::class, 'planner_id', 'id');
    }
}
