<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Get the users that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the task_comments for the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function task_comments()
    {
        return $this->hasMany(TaskComment::class, 'task_id');
    }

    /**
     * The task_users that belong to the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function task_users()
    {
        return $this->belongsToMany(User::class, 'task_user')
    	->withPivot('data')
    	->withTimestamps();
    }

    /**
     * The task_kelas that belong to the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function task_kelas()
    {
        return $this->belongsToMany(Kelas::class, 'task_kelas')->withTimestamps();
    }
}
