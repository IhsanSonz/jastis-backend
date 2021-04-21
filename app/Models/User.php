<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'google_id',
        'registration_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function user_kelas()
    {
        return $this->hasMany(UserKelas::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function task_users()
    {
        return $this->hasMany(TaskUser::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function task_comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function event_comments()
    {
        return $this->hasMany(EventComment::class);
    }
}
