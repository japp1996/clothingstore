<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $table = "designs";

    public function products()
    {
        return $this->hasMany(Product::class, 'design_id');
    }
}
