<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function expenses()
    {
        return $this->hasMany(Expenses::class,'category_id','id');
    }
}
