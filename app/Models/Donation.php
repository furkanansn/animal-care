<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(Sehir::class, 'sehir_key', 'sehir_key');
    }

    /**
     * @return HasOne
     */
    public function ilce(): HasOne
    {
        return $this->hasOne(Ilce::class, 'ilce_key', 'ilce_key');
    }

    /**
     * @return HasOne
     */
    public function district(): HasOne
    {
        return $this->hasOne(Mahalle::class, 'mahalle_key', 'district_id');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
