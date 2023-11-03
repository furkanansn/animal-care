<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahalle extends Model
{
    use HasFactory;

    protected $table = 'mahalle';

    public function county()
    {
        return $this->hasOne(Ilce::class, 'ilce_key', 'mahalle_ilcekey');
    }
}
