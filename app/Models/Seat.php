<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_id',
        'row',
        'number',
        'code',
        'section',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function venue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function ticketSales()
    {
        return $this->hasMany(TicketSale::class);
    }

    // Aktif koltuklar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
