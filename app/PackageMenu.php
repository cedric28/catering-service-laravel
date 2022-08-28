<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageMenu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id','package_id','creator_id','updater_id'
    ];

    public function package_food_category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function planners()
    {
      return $this->belongsToMany('App\Planner');
    }
}
