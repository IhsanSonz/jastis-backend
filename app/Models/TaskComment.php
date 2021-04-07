<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Moloquent;

class TaskComment extends Moloquent
{
    use HasFactory;

    protected $collection = 'task_comments';

    protected $fillable = ['data'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
