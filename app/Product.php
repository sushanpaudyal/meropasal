<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public function attributes(){
      return $this->hasMany(ProductsAttribute::class, 'product_id');
  }
}
