<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Play extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'author',
        'director',
        'cast',
        'image',
        'venue_id',
        'is_active',
        'ticket_price',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ticket_price' => 'decimal:2',
        'duration' => 'integer',
    ];

    // İlişki: N Oyun -> 1 Salon
    public function venue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    // İlişki: 1 Oyun -> N Bilet (ileride)
    /*public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }*/

    // Scope: Aktif oyunlar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: Arama
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('author', 'LIKE', "%{$search}%")
                ->orWhere('director', 'LIKE', "%{$search}%");
        });
    }

    // Yardımcı metot: Bilet satışı açık mı?
    public function isSelling()
    {
        return $this->is_active;
    }
}
