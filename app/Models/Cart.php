<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'sub_total',
        'discount',
        'total'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function updateTotals()
    {
        $subTotal = $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $discount = $this->discount ?? 0;
        $total = $subTotal - $discount;

        $this->update([
            'sub_total' => $subTotal,
            'total' => $total
        ]);
    }

}
