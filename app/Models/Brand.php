<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function products()
   {
    return $this->HasMany(product::class);
   } 
}

