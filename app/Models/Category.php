<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'accommodation_id'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
