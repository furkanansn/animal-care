<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperAnimal
 */
class Animal extends Model
{
    use HasFactory;

    /**
     * @param $value
     * @return mixed
     */
    public function getSicknessJsonAttribute($value): mixed
    {
        return jsonUnserialize($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getDrugsUsedJsonAttribute($value): mixed
    {
        return jsonUnserialize($value);
    }

    /**
     * @param $val
     * @return mixed
     */
    public function getSurgeriesJsonAttribute($val): mixed
    {
        return jsonUnserialize($val);
    }

    /**
     * @param $val
     * @return mixed
     */
    public function getReportSheetJsonAttribute($val): mixed
    {
        return jsonUnserialize($val);
    }

    /**
     * @param $val
     * @return mixed
     */
    public function getPassportSheetJsonAttribute($val): mixed
    {
        return jsonUnserialize($val);
    }

    /**
     * @param $val
     * @return mixed
     */
    public function getOtherDocsJsonAttribute($val): mixed
    {
        return jsonUnserialize($val);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_animals', 'animal_id', 'user_id');
    }

}
