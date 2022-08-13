<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foods extends Model
{
    use SoftDeletes;
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
