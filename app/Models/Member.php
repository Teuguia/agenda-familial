<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'family_id', 'role'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function shoppingLists()
    {
        return $this->belongsToMany(ShoppingList::class, 'member_shopping_list');
    }

    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    public function isChild(): bool
    {
        return $this->role === 'child';
    }
}
