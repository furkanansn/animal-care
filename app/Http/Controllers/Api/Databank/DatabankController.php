<?php

namespace App\Http\Controllers\Api\Databank;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\DataBank;

class DatabankController extends ApiBaseController
{
    /**
     * @var mixed|string
     */
    public mixed $model = DataBank::class;

    /**
     * @var string
     */
    public string $pluralName = 'Bilgiler';

    /**
     * @var string
     */
    public string $singularName = 'Bilgi Bankası';

    public array|string|null $rel = [
        'category'
    ];

    public function setFilter(): void
    {

        $this->filters = setFilter(['category_id', 'exact', null]);

    }

    public function getOperation(...$items): void
    {
        $id = $items[0];

        DataBank::findOrFail($id)?->increment('view_count');
    }
}
