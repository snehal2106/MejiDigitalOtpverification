<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'code', 'type', 'verified_at', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return now()->greaterThan($this->expires_at);
    }

    public function isUsed()
    {
        return !is_null($this->verified_at);
    }
}
