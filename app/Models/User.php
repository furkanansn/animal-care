<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['is_personal_string'];

    /**
     * Mutators.
     * @param $val
     */
    public function setPasswordAttribute($val) : void
    {
        $this->attributes['password'] = bcrypt($val);
    }

    /**
     * @return string
     */
    public function getIsPersonalStringAttribute(): string
    {
        return $this->is_personal ? 'Bireysel' : 'Kurumsal';
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
    public function county(): HasOne
    {
        return $this->hasOne(Ilce::class, 'ilce_key', 'ilce_key');
    }

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(Sehir::class, 'sehir_key', 'sehir_key');
    }

}
