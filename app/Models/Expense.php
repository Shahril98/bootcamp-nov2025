<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',

        'description',

        'amount',

        'category',

        'spent_at',

        'notes',
    ];

    protected $casts = [
        'spent_at' => 'datetime',
    ];
}
