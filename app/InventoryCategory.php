<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryCategory extends Model
{
    use SoftDeletes;
    
    public function inventory_categories()
    {
        return $this->hasMany(Inventory::class, 'inventory_category_id', 'id');
    }
}
