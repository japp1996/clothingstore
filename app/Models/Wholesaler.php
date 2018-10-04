<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wholesaler extends Model
{
    public function images () {
        return $this->hasMany(WholesalerImage::class);
    }
}
