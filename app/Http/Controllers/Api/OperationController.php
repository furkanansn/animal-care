<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;

class OperationController extends ApiBaseController
{
    public mixed $model = Operation::class;

    public string $pluralName = 'Operasyonlar';

    public string $singularName = 'Operasyon';

    public array $with = [];

    public array|string|null $rel = [];
}
