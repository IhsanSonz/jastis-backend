<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    /**
     * Get the users that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The users that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kelas_users()
    {
        return $this->belongsToMany(User::class)
    	->withPivot('role')
    	->withTimestamps();
    }

    /**
     * The event_kelas that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function event_kelas()
    {
        return $this->belongsToMany(Event::class, 'event_kelas')->withTimestamps();
    }

    /**
     * The task_kelas that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function task_kelas()
    {
        return $this->belongsToMany(Task::class, 'task_kelas')->withTimestamps();
    }
}
