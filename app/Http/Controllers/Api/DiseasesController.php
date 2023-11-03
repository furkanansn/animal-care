<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;

class DiseasesController extends ApiBaseController
{
    public mixed $model = Disease::class;

    public string $pluralName = 'Hastalıklar';

    public string $singularName = 'Hastalık';

    public array $with = [];

    public array|string|null $rel = [];
}
