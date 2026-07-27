<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'play_id',
        'seat_id',
        'user_id',
        'order_id',
        'price',
        'status',
        'reserved_at',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
    ];

    public function play(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Play::class);
    }

    public function seat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Aktif satışlar
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
