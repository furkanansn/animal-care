<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperNotice
 */
class Notice extends Model
{
    use HasFactory;


    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function animal(): HasOne
    {
        return $this->hasOne(Animal::class, 'id', 'animal_id');
    }

    public function district(): HasOne
    {
        return $this->hasOne(Mahalle::class, 'mahalle_id', 'district_id');
    }

    public function city(): HasOne
    {
        return $this->hasOne(Sehir::class, 'sehir_key', 'sehir_key');
    }

    public function county(): HasOne
    {
        return $this->hasOne(Ilce::class, 'ilce_key', 'ilce_key');
    }

    public function forward(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'forward_who');
    }

}
