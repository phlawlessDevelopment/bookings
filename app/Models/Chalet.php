<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chalet extends Model
{
    use HasFactory;

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class);
    }

    public function scopeAvailableBetween($query, $startDate, $endDate)
    {
        return $query->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
            $query->where('from_date', '<=', $endDate)
                ->where('to_date', '>=', $startDate);
        });
    }
}
