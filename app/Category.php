<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function dish_category()
    {
        return $this->belongsTo(DishCategory::class, 'dish_category_id');
    }

    public function foods()
    {
        return $this->hasMany(Foods::class,'category_id','id');
    }

    public function package_food_categories()
    {
        return $this->hasMany(PackageMenu::class,'category_id','id');
    }
}
