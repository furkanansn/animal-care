<?php

namespace App\Http\Controllers\Api\Announcement;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends ApiBaseController
{
    public mixed $model = Announcement::class;

    /**
     * @var string
     */
    public string $pluralName = 'İlanlar';

    /**
     * @var string
     */
    public string $singularName = 'İlan';

    /**
     * @var string
     */
    public string $prefix = 'announcements';

    public array $with = [
        'district',
        'county',
        'city'
    ];


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $val = $this->checkImageAndUpload($request->all());

        $data = $this->model::create($val);

        return $this->checkData($data);

    }

    public function setFilter(): void
    {
        $this->filters = setFilter
        (
            ['type_id', 'exact', null],
            ['kind_id', 'exact', null],
            ['district_id', 'exact', null],
            ['ilce_key', 'exact', null],
            ['sehir_key', 'exact', null],
            ['city_name', 'like', null],
            ['county_name', 'like', null],
            ['street_name', 'like', null]
        );
    }
}
