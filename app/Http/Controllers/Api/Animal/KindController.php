<?php

namespace App\Http\Controllers\Api\Animal;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\AnimalKind;

class KindController extends ApiBaseController
{
    public mixed $model = AnimalKind::class;
}
