<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Traits\ReturnResponse;
use App\Models\UserAnimal;
use App\Models\TempUserAnimal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiBaseController
{

    use ReturnResponse;

    public mixed $model = User::class;

    public string $singularName = 'Üye';

    public string $pluralName = 'Üyeler';

    /**
     * Kullanıcı profili güncelleme
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {

        $input = $request->all();
        $user = User::find($request->user()->id);

        if ($user?->update($input)) {

            return $this->sendSuccess(successMsg('Profil başarıyla güncellendi!'));

        }

        return $this->sendError('Profil güncellenirken bir hata oluştu, daha sonra tekrar deneyin!');

    }


    /**
     * QR kod ile hayvan ekleme
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addAnimal(Request $request): JsonResponse
    {

        $post = [

            'user_id'   => $request->user()->id,
            'animal_id' => $request->post('animal_id')

        ];

        if (TempUserAnimal::create($post)) {

            return $this->sendSuccess(successMsg(), 201);

        }

        return $this->sendError(errorMsg());

    }


    /**
     * Beklemedeki hayvanı onaylamak için
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function approveAnimal(Request $request): JsonResponse
    {

        $post = [

            'user_id'   => $request->user()->id,
            'animal_id' => $request->post('animal_id')

        ];

        $animal = TempUserAnimal::where($post)->first();
        $animal->delete();

        $approvedAnimal = new UserAnimal;

        if ($approvedAnimal->save($post)) {

            return $this->sendSuccess(successMsg(), 201);

        }

        return $this->sendError(errorMsg());

    }

    public function setFilter(): void
    {
        $this->filters = setFilter(
            ['name', 'like', null],
            ['sector_id', 'exact', null],
            ['sehir_key', 'exact', null],
            ['ilce_key', 'exact', null],
            ['district_id', 'exact', null]
        );
    }


}
