<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'description',
        'capacity',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // 1 Salon -> N Oyun
    public function plays()
    {
        return $this->hasMany(Play::class);
    }

    // Aktif oyunu getir (sadece 1 tane)
    public function activePlay()
    {
        return $this->hasOne(Play::class)->where('is_active', true);
    }

    // Salonda oyun var mı?
    public function hasActivePlay()
    {
        return $this->activePlay()->exists();
    }

    // Aktif salonlar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Arama (listeleme için)
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('address', 'LIKE', "%{$search}%")
                         ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }
}
