<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'weight',
        'waist',
        'abs',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
