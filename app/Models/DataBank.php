<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DataBank extends Model
{
    use HasFactory;

    /**
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(DataBankCategory::class, 'id', 'category_id');
    }


//    public function setShowCountAttribute(?int $value)
//    {
//        if ( ! $value) $this->attributes['view_count'] = 0;
//
//        $this->attributes['view_count'] = $value;
//    }
}
