<?php

namespace App\Http\Controllers\Api\Announcement;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\AnnouncementType;

class AnnouncementTypeController extends ApiBaseController
{
    public mixed $model = AnnouncementType::class;
}
