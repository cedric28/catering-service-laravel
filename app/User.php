<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function scopeBusboy($query)
    {
        return $query->where('job_type_id', '=', 3);
    }

    public function scopeDishwasher($query)
    {
        return $query->where('job_type_id', '=', 4);
    }

    public function scopeServer($query)
    {
        return $query->where('job_type_id', '=', 5);
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function job_type()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    public function planner_staffings()
    {
        return $this->hasMany(PlannerStaffing::class,'user_id','id');
    }

    public function planner_task_staffs()
    {
        return $this->hasMany(PlannerTaskStaff::class,'user_id','id');
    }
}
