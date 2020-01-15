<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    protected $table = 'socials';

    protected $fillable = ['user_id', 'social_id', 'service'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
