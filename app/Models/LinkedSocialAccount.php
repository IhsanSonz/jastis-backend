<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Moloquent;

class LinkedSocialAccount extends Moloquent
{
    use HasFactory;

    protected $collection = 'linkedSocialAccount';

    protected $fillable = [
        'provider_name',
        'provider_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
