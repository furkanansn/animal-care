<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends ApiBaseController
{
    /**
     * @var mixed|string
     */
    public mixed $model = Event::class;

    /**
     * @var string
     */
    public string $pluralName = 'Etkinlikler';

    /**
     * @var string
     */
    public string $singularName = 'Etkinlik';

    public array|string|null $rel = [
      'galleries'
    ];

    public array $with = [
      'galleries'
    ];
}
