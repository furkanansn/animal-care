<?php

namespace App\Http\Controllers\Api\Notice;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Notice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class NoticeController extends ApiBaseController
{

    /**
     * @var string
     */
    public string $pluralName = 'İhbarlar';

    /**
     * @var string
     */
    public string $singularName = 'İhbar';

    /**
     * @var mixed|string
     */
    public mixed $model = Notice::class;

    /**
     * @var array|string|string[]|null
     */
    public array|string|null $rel = [
        'user',
    ];

    public array $with = [
        'district',
        'city',
        'county',
    ];

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->post();
        $data = parseAddress($data);
        $notice = Notice::create($this->parseJsonAndUploadPhoto($data));

        if (!$notice) {
            return $this->sendError("$this->singularName eklenemedi!");
        }

        //TODO:: Amazon işleri yapılacak.

        return $this->sendSuccess(array_merge([
            'data' => $notice
        ], successMsg("$this->singularName başarıyla eklendi!")), 201);

    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function agreeNotice(int $id): JsonResponse
    {
        $user = auth()->user();

        if ( ! $user) {
            throw new UnauthorizedException('Giriş yapılmamış!');
        }

        $notice = Notice::where('id', $id)->where('forward_who', $user->id)->firstOrFail();

        $notice->update([
           'is_noticed' => 1
        ]);

        $userFcmToken = $notice->user?->fcm_token;

        if ( ! is_null($userFcmToken)) {
            sendNotification([$userFcmToken], 'İhbarınız ile ilgileniliyor!', "$user->name adlı belediye ihbarınızı gördü ve ilgilenmeye başladı!");
        }

        return $this->sendSuccess($notice);
    }


    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->except('image');

        $notice = Notice::findOrFail($id);

        $columns = \Schema::getColumnListing('notices');
        $data = array_filter($data, static function ($val) use ($columns) {
            return in_array($val, $columns, true);
        });

        if (!$notice->update($this->parseJsonAndUploadPhoto($data))) {
            return $this->sendError("$this->singularName güncellenemedi!");
        }

        return $this->sendSuccess([
            'data' => $notice,
            'msg' => "$this->singularName başarıyla güncellendi!"
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {

        $query = $request->except('county_id', 'city_id');
        $data = Notice::where($query)->with(['user', 'district' => function ($q) {
            return $q->with(['county' => function ($q) {
                return $q->with('city');
            }]);
        }])->get();

        return $this->sendSuccess([

            'data' => $data,
            'count' => count($data)

        ]);

    }

    /**
     * Tekli sorgular için
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function get(Request $request, $id): JsonResponse
    {

        $data = Notice::findOrFail($id);
        $data->increment('view_count');

        $item = Notice::where('id', $id)->with('user')->with(['district' => function ($q) {
            return $q->with(['county' => function ($q) {
                return $q->with('city');
            }]);
        }])->get();

        return $this->sendSuccess([

            'data' => $item

        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMyNotices(Request $request): JsonResponse
    {
        $user = $request->user('api');
        if ($user->is_personal) {
            return $this->sendError('Buraya erişim izniniz yok!', 403);
        }

        $notices = Notice::where('forward_who', $user->id)->get();
        return $this->sendSuccess([
           'data' => $notices,
           'count' => $notices->count(),
        ]);
    }

    public function setFilter(): void
    {
        $this->filters = setFilter
        (
            ['animal_id', 'exact', null],
            ['user_id', 'exact', null],
            ['is_noticed', 'exact', null],
            ['forward_who', 'exact', null],
            ['notice_type_id', 'exact', null],
            ['sehir_key', 'exact', null],
            ['ilce_key', 'exact', null],
            ['district_id', 'exact', null],
        );
    }


}
