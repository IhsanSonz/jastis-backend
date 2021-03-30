<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Moloquent;

class Task extends Moloquent
{
    use HasFactory;

    protected $collection = 'tasks';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'title',
        'desc',
    ];

    protected $dates = [
        'date_start',
        'date_end',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function task_users()
    {
        return $this->hasMany(TaskUser::class);
    }

    public function task_comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
