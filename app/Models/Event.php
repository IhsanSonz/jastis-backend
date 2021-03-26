<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Get the users that owns the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the event_comments for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function event_comments()
    {
        return $this->hasMany(EventComment::class, 'event_id');
    }

    /**
     * The event_users that belong to the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function event_users()
    {
        return $this->belongsToMany(User::class, 'event_user')
    	->withPivot('data')
    	->withTimestamps();
    }

    /**
     * The event_kelas that belong to the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function event_kelas()
    {
        return $this->belongsToMany(Kelas::class, 'event_kelas')->withTimestamps();
    }
}
