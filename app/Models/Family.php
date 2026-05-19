<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Family extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'created_by'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($family) {
            $family->code = Str::upper(Str::random(8));
        });
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function shoppingLists()
    {
        return $this->hasMany(ShoppingList::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
