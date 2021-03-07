<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * The users that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_kelas_table');
    }

    /**
     * The event_kelas that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function event_kelas(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_kelas');
    }

    /**
     * The task_kelas that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function task_kelas(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }
}
