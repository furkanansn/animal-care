<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperDisease
 */
class Disease extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;
}
