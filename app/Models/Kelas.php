<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Moloquent;

class Kelas extends Moloquent
{
    use HasFactory;

    protected $collection = 'kelas';

    protected $fillable = [
        'name',
        'subject',
        'desc',
        'code',
        'color',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user_kelas()
    {
        return $this->hasMany(UserKelas::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
