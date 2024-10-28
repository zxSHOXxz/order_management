<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function completedByUser()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
