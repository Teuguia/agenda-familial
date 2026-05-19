<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status',
        'due_date', 'assigned_to', 'family_id'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function assignee()
    {
        return $this->belongsTo(Member::class, 'assigned_to');
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
