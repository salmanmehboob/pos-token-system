<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_category_id',
        'product_id',
        'category',
        'quantity',
        'is_stock',
    ];


    public function category()
    {
        return $this->belongsTo(Category:: class, 'product_category_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product:: class, 'product_id', 'id');
    }

}