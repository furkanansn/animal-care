<?php

namespace App\Http\Controllers\Api\Cities;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Ilce;
use App\Models\Mahalle;
use App\Models\Sehir;
use App\Models\Sokak;
use Illuminate\Http\JsonResponse;

class CitiesController extends ApiBaseController
{

    /**
     * Cache için süre. 1 yıl ediyor.
     *
     * @var int|float
     */
    private int $second = 60 * 60 * 24 * 365;

    /**
     * Tüm şehirleri döner.
     *
     * @return JsonResponse
     */
    public function getCity(): JsonResponse
    {

        return $this->sendSuccess([
            'data'  => \Cache::rememberForever('cities', function () {
                return Sehir::all();
            }),
            'route' => trim(route('api.cities.ilce', ['id' => '1']), '/1')
        ]);

    }

    /**
     * Belirtilen ilçeyi döner.
     *
     * @param $id
     * @return JsonResponse
     */
    public function getIlce($id): JsonResponse
    {

        return $this->sendSuccess([

            'data'  => \Cache::rememberForever("county-$id", function () use ($id) {
                return Ilce::where('ilce_sehirkey', $id)->get();
            }),
            'route' => trim(route('api.cities.mahalle', ['id' => '1']), '/1')

        ]);

    }

    /**
     * Belirtilen mahalleyi döner.
     *
     * @param $id
     * @return JsonResponse
     */
    public function getMahalle($id): JsonResponse
    {

        return $this->sendSuccess([

            'data' => \Cache::rememberForever("district-$id", function () use ($id){
                return Mahalle::where('mahalle_ilcekey', $id)->get();
            })

        ]);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getSokak($id): JsonResponse
    {

        return $this->sendSuccess([
           'data' => \Cache::rememberForever("street-$id", function () use ($id) {
               return Sokak::where('sokak_cadde_mahallekey', $id)->get();
           })
        ]);

    }

}
