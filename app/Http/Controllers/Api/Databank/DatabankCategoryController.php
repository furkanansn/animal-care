<?php

namespace App\Http\Controllers\Api\Databank;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\DataBankCategory;

class DatabankCategoryController extends ApiBaseController
{
    /**
     * @var mixed|string
     */
    public mixed $model = DataBankCategory::class;

    /**
     * @var string
     */
    public string $pluralName = 'Bilgiler';

    /**
     * @var string
     */
    public string $singularName = 'Bilgi Bankası';
}
