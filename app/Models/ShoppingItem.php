<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quantity', 'checked', 'shopping_list_id'];

    protected $casts = [
        'checked' => 'boolean',
    ];

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}
