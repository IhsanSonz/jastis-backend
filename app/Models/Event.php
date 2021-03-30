<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Moloquent;

class Event extends Moloquent
{
    use HasFactory;

    protected $collection = 'events';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'title',
        'desc',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function event_users()
    {
        return $this->hasMany(EventUser::class);
    }

    public function event_comments()
    {
        return $this->hasMany(EventComment::class);
    }
}
