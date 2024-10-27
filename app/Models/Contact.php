<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'user_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // User ile ilişki
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
