<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DishCategory extends Model
{
    public function dish_categories()
    {
        return $this->hasMany(Category::class,'dish_category_id','id');
    }
}
