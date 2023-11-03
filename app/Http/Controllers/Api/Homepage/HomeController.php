<?php

namespace App\Http\Controllers\Api\Homepage;

use App\Http\Controllers\Controller;
use App\Http\Traits\ReturnResponse;
use App\Models\Announcement;
use App\Models\DataBank;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ReturnResponse;

    /**
     * @return JsonResponse
     */
    public function home(): JsonResponse
    {
        $dailyDonations = Donation::whereDate('created_at', Carbon::today())->with('city')->get();
        $dailyAnnouncements = Notice::whereDate('updated_at', Carbon::today())
            ->whereNotNull('forward_who')
            ->get();

        $dailyEvents = Event::whereDate('event_date', Carbon::today())->with('galleries')->get();

        return $this->sendSuccess([$dailyAnnouncements, $dailyDonations, $dailyEvents]);
    }
}
