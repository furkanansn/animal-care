<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{

    /**
     * Kalıtım ile model adını alıp, kodu çok daha basit tutuyorum.
     *
     * @var mixed|null
     */
    public mixed $model = null;

    /**
     * İlgili controller'de hata mesajı için türkçe çoğul kullanımı. Örn: animals için Hayvanlar
     *
     * @var string
     */
    public string $pluralName = '';

    /**
     * İlgili controller'de hata mesajı için türkçe çoğul kullanımı. Örn: animals için Hayvan
     *
     * @var string
     */
    public string $singularName = '';

    /**
     * Amazon s3 için ön ek.
     *
     * @var string
     */
    public string $prefix = '';


    /**
     * Varsa veriyle beraber dönecek ilişki.
     *
     * @var array|string|null
     */
    public array|string|null $rel = null;

    /**
     * @var array
     */
    public array $with = [];

    /**
     * @var bool
     */
    public bool $isApi = true;

    /**
     * @var array
     */
    public array $filters = [];

    /*
     * ////////////////////////////// END PROPERTIES //////////////////////////////
     */


    public function __construct()
    {
        $this->setFilter();
    }

    /**
     * Tüm veriler için, dinamik sorgu.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->filteredData($request->query());
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
        $item = $this->model::when($this->rel, function ($q) {
            return $q->with($this->rel);
        })->where('id', $id)->first();

        $this->getOperation($id);

        return $this->sendSuccess([
            'data' => $item
        ]);
    }


    /**
     * Yeni veri girişi.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->all();
        $item = $this->model::create($data);

        if (!$item) {
            return $this->sendError("$this->singularName eklenemedi!");
        }

        return $this->sendSuccess(array_merge([
            'data' => $item
        ], successMsg("$this->singularName başarıyla eklendi!")), 201);
    }


    /**
     * İlgili veriyi güncellemede kullanılır.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->all();
        $item = $this->model::findOrFail($id);

        if (!$item->update($data)) {
            return $this->sendError('Bağlantı hatası! Daha sonra tekrar deneyin!');
        }

        return $this->sendSuccess(successMsg("$item->name başarıyla güncellendi!"));
    }

    /**
     * Veri silme fonksiyonu.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $item = $this->model::findOrFail($id);

        if (!$item->delete()) {
            return $this->sendError("$this->singularName silinemedi, daha sonra tekrar deneyin!");
        }

        return $this->sendSuccess(successMsg("$this->singularName başarıyla silindi!"));
    }

    /**
     * @param ...$items
     */
    public function getOperation(...$items): void
    {
        //TODO:: do something
    }

//    /**
//     * @param string $img
//     * @param string $ext
//     * @param Model $model
//     * @param string $path
//     * @return bool
//     */
//    public function uploadPhoto(string $img, string $ext, Model $model, string $path = 'images'): bool
//    {
//        $id = $model->id;
//
//        [$baseType, $image] = explode(';', $img);
//        [, $image] = explode(',', $image);
//        $image = base64_decode($image);
//        $imgName = $model->name . '-' . (string) time() . '.' . $ext;
//        $pathName = "$path/$this->prefix/$id/$imgName";
//
//        $q =  \Storage::disk('s3')->put($pathName, $image, 'public-read');
//
//        if ($q) {
//            return $pathName;
//        }
//
//        return $pathName;
//    }

    /**
     * @param object|array $data
     * @param bool $isUpdate
     * @return array
     */
    public function parseJsonAndUploadPhoto(object|array $data, bool $isUpdate = false): array
    {
//        if (array_key_exists('image', $data)) {
//            $data['image'] = $this->uploadPhotoToS3($data['image'], $data['ext']);
//            unset($data['ext']);
//        }

        $exts = ['png', 'jpg', 'jpeg', 'webp'];

        if (array_key_exists('ext', $data) && in_array($data['ext'], $exts, true)) {
            $data = $this->checkImageAndUpload((array)$data);
        }

        if (isset($data['ext'])) {
            unset($data['ext']);
        }
        $keys = array_keys($data);

        $arrJson = $this->getJsonAttributes($data, $keys, $isUpdate);
        return $this->uploadJsonPhotos($data, $arrJson);
    }

    /**
     * @param array $data
     * @param array $keys
     * @param bool $isUpdate
     * @return array
     */
    public function getJsonAttributes(array $data, array $keys, bool $isUpdate): array
    {
        $arrJson = [];
        foreach ($keys as $key) {
            if (str_ends_with($key, '_json')) {
                if ($isUpdate && ($data[$key] === [] || $data[$key] === "[]")) {
                    unset($data[$key]);
                } else {
                    $arrJson[] = $key;
                }
            }
        }
        return $arrJson;

    }

    /**
     * @param array $data
     * @param array $arrJson
     * @return array
     */
    public function uploadJsonPhotos(array &$data, array $arrJson): array
    {
        foreach ($arrJson as $json) {
            foreach ($data[$json] as $key => $j) {
                if (!$j) {
                    continue;
                }
                if (array_key_exists('image', $j) && $j['ext']) {
                    $base64 = $j['image'];
                    $ext = $j['ext'];

                    unset($data[$json][$key]['image'], $data[$json][$key]['ext']);

                    $data[$json][$key]['imageUrl'] = $this->uploadPhotoToS3($base64, $ext, $json, 'json');
                }
            }
            $data[$json] = serialize($data[$json]);
        }

        $newArr = [];

        foreach ($data as $key => $value) {
            if ($key !== 'ext') {
                if (str_ends_with($key, '_json') && ! in_array($key, $arrJson, true)) {
                    $newArr[$key] = serialize($value);
                } else {
                    $newArr[$key] = $value;
                }
            }
        }

        return $newArr;
    }

    /**
     * @param string $image
     * @param string $ext
     * @param string $imagePrefix
     * @param string $pathPrefix
     * @return string|null
     */
    public function uploadPhotoToS3(string $image, string $ext, string $imagePrefix = 'photo', string $pathPrefix = 'images'): ?string
    {
        $image = base64_decode($image);
        $imgName = $imagePrefix . '-' . (string)time() . '.' . $ext;
        $pathName = "$pathPrefix/$this->prefix/$imgName";

        $q = \Storage::disk('s3')->put($pathName, $image, 'public-read');

        return $q ? \Storage::disk('s3')->path($pathName) : null;
    }

    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function checkData(mixed $data): JsonResponse
    {
        if (!$data) {
            return $this->sendError("$this->singularName eklenemedi!");
        }
        return $this->sendSuccess(array_merge([
            'data' => $data
        ], successMsg("$this->singularName başarıyla eklendi!")));
    }

    /**
     * @param array $data
     * @return array
     */
    public function checkImageAndUpload(array $data): array
    {
        if (array_key_exists('image', $data) && $data['image'] !== null) {
            $data['image'] = $this->uploadPhotoToS3($data['image'], $data['ext']);
            unset($data['ext']);
        }
        return $data;
    }

}
