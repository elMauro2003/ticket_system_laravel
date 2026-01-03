<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'content'
    ];

    // Relación con el ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Relación con el usuario que respondió
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}