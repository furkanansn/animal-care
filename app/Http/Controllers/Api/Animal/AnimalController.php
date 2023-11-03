<?php

namespace App\Http\Controllers\Api\Animal;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Alert;
use App\Models\UserAnimal;
use App\Models\Animal;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\Storage;

class AnimalController extends ApiBaseController
{

    use ResponseTrait;

    /**
     * @var mixed|string
     */
    public mixed $model = Animal::class;

    /**
     * @var string
     */
    public string $pluralName = 'Hayvanlar';

    /**
     * @var string
     */
    public string $singularName = 'Hayvan';

    /**
     * @var string
     */
    public string $prefix = 'animals';

    /*
     * ////////////////////////////// END PROPERTIES //////////////////////////////
     */

//    public array $with = ['users'];

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->post('animals');
        $isSingular = count($data) === 1;

        foreach ($data as $val) {
            $val = array_merge($val, ['uuid' => \Str::uuid()]);
            $animal = Animal::create($this->parseJsonAndUploadPhoto($val));

            //TODO:: E-posta gönderimi.

            UserAnimal::create([
                'user_id' => $request->user('api')->id,
                'animal_id' => $animal->id
            ]);
        }

        if ($isSingular) {
            return $this->sendSuccess(successMsg("$this->singularName başarıyla eklendi!"), 201);
        }

        return $this->sendSuccess(successMsg("$this->pluralName başarıyla eklendi!"), 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $animal = Animal::whereId($id)->firstOrFail();

        $val = $request->all();

        $animal = $animal->update($this->parseJsonAndUploadPhoto($val, true));

        if (!$animal) {
            return $this->sendError("$this->singularName güncellemedi!");
        }
        return $this->sendSuccess(array_merge([
            'data' => $animal
        ], successMsg("$this->singularName başarıyla güncellendi!")));
    }

    /**
     * @throws FileNotFoundException
     * @throws BindingResolutionException
     */
    public function showPhoto()
    {
        //TODO:: Önemli değiştirilecek.

        $photo = \Storage::disk('s3')->get(\request()->query('path'));

        return response()->make(
            $photo,
            200, ['Content-type' => 'image/png']
        );
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function qr(int $id): mixed
    {
        $animal = Animal::whereId($id)->firstOrFail();
        return \QrCode::format('png')->size(100)->generate(route('api.animals.uuid', ['uuid' => $animal->uuid]));
    }

    /**
     * @param Request $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function uuid(Request $request, string $uuid): JsonResponse
    {
        $animal = Animal::whereUuid($uuid)->firstOrFail();

        $userAnimal = UserAnimal::whereAnimalId($animal->id)->whereUserId($request->user('api')->id)->first();

        if ($userAnimal) {
            return $this->sendError("$animal->name, daha önce hayvanlarınıza eklenmiş!");
        }

        UserAnimal::create([
            'user_id' => $request->user('api')->id,
            'animal_id' => $animal->id
        ]);

        return $this->sendSuccess([
            'msg' => "$animal->name başarıyla hayvanlarınıza eklendi!"
        ], 201);
    }

    public function setFilter(): void
    {
        $this->filters = setFilter
        (
            ['name', 'like', null],
            ['is_pet', 'exact', null],
            ['kind', 'exact', null],
            ['sehir_key', 'exact', null],
            ['ilce_key', 'exact', null],
            ['district_id', 'exact', null],
            ['user_id', 'custom', function ($q, $val) {
                return $q->whereHas('users', function ($query) use ($val) {
                    return $query->where('users.id', $val);
                });
            }]
        );
    }

}
