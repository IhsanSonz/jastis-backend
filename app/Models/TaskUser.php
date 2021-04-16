<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Moloquent;

class TaskUser extends Moloquent
{
    use HasFactory;

    protected $collection = 'task_users';

    protected $fillable = ['data', 'score'];

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
