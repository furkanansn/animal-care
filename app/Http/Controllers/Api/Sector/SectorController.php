<?php

namespace App\Http\Controllers\Api\Sector;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Sector;

class SectorController extends ApiBaseController
{

    /**
     * @var mixed|string
     */
    public mixed $model = Sector::class;

    /**
     * @var string
     */
    public string $pluralName = 'Sektörler';

    /**
     * @var string
     */
    public string $singularName = 'Sektör';

}
