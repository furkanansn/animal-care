<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTempUserAnimal
 */
class TempUserAnimal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'animal_id'];
}
