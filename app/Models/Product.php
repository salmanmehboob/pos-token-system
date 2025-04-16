<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
    'product_category_id',
    'name',
    'category',
    'image',
    'quantity',
    'cost_price',
    'retail_price',
    'is_stock'
   ];
  
//    Relationship with Category model

   public function category()
   {
    return $this->belongsTo(Category:: class, 'product_category_id', 'id');
   }

}