<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperBlogCategory
 */
class BlogCategory extends Model
{
    use HasFactory;

    public $timestamps = false;
}
