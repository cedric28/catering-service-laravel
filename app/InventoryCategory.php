<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    public function inventory_categories()
    {
        return $this->hasMany(Inventory::class, 'inventory_category_id', 'id');
    }
}
