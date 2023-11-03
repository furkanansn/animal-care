<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
      'event_date' => 'datetime:d-m-Y'
    ];

    /**
     * @return HasMany
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'event_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(Sehir::class, 'sehir_key', 'location');
    }
}
