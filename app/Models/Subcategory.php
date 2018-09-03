<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name', 'name_english'
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
