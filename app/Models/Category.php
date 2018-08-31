<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'category_sizes', 'category_id', 'size_id');
    }
}
