<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Moloquent;

class EventComment extends Moloquent
{
    use HasFactory;

    protected $fillable = ['data'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
