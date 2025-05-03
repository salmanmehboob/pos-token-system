<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
       'user_id', 
       'session_id', 
       'subtotal', 
       'discount', 
       'total'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function updateTotals(): void
    {
        $this->subtotal = $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->total = $this->subtotal - $this->discount;
        $this->save();
    }
}