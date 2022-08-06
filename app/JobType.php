<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    public function job_types()
    {
        return $this->hasMany(User::class, 'job_type_id', 'id');
    }
}
