<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['accommodation_id', 'paid_by', 'category_id', 'title', 'amount'];

    protected $casts = ['amount' => 'decimal:2'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
