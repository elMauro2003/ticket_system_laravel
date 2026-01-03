<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'priority',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relación con el usuario que creó el ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con las respuestas
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}