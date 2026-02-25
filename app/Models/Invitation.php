<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['accommodation_id', 'email', 'token', 'status', 'expires_at'];

    protected $casts = ['expires_at' => 'datetime'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
