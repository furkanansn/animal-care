<?php

namespace App\Http\Controllers\Api;

use App\Models\Medicine;

class MedicineController extends ApiBaseController
{
    public mixed $model = Medicine::class;

    public string $singularName = 'İlaç';

    public string $pluralName = 'İlaçlar';

    public array $with = [];

    public array|string|null $rel = [];
}
