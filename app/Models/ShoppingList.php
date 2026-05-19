<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'family_id'];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_shopping_list');
    }

    public function items()
    {
        return $this->hasMany(ShoppingItem::class);
    }
}
