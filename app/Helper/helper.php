<?php

use Fcm\FcmClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

if (!function_exists('successMsg')) {

    /**
     * Gereksiz kod kalabalığını engellemek için
     *
     * @param string|null $msg
     * @return string[]
     */
    #[ArrayShape(['msg' => ""])]
    function successMsg(?string $msg = null): array
    {

        if ($msg === null) {

            $msg = 'Veri başarıyla eklendi!';

        }

        return [
            'msg' => $msg
        ];

    }

}

if (!function_exists('errorMsg')) {

    /**
     * Gereksiz kod kalabalığını engellemek için
     *
     * @param string|null $msg
     * @return string
     */
    function errorMsg(string|null $msg = null): string
    {

        if ($msg === null) {
            $msg = 'Veri eklenirken bir hata oluştu, lütfen daha sonra tekrar deneyin!';
        } else {
            $msg .= ' bir hata oluştu, lütfen daha sonra tekrar deneyin!';
        }

        return $msg;


    }

}

if (!function_exists('setAlertData')) {

    /**
     * @param Exception|Throwable $exception
     * @return array
     */

    #[ArrayShape(['msg' => "string", 'code' => "string", 'file' => "string", 'line' => "string", 'ip_address' => "mixed"])]
    function setAlertData(Exception|Throwable $exception): array
    {
        return [

            'msg' => (string)$exception?->getMessage(),
            'code' => (string)$exception?->getCode(),
            'file' => (string)$exception?->getFile(),
            'line' => (string)$exception?->getLine(),
            'ip_address' => $_SERVER['REMOTE_ADDR']

        ];
    }
}

if (!function_exists('setFlashData')) {
    /**
     * @param string $msg
     * @param bool $success
     * @return array
     */

    #[ArrayShape(['msg' => "string", 'success' => "bool", 'type' => "string"])]
    function setFlashData(string $msg, bool $success = true): array
    {

        return [

            'msg' => $msg,
            'success' => $success,
            'type' => $success ? 'success' : 'error'

        ];

    }
}


if (!function_exists('tpD')) {
    /**
     * @param string|int|null $tp
     * @param string $format
     * @return string
     */
    function tpD(string|int|null $tp = 0, string $format = 'LLLL'): string
    {
        if (!$tp) {
            return 'Tarih Hesaplanamadı!';
        }
        return \Carbon\Carbon::createFromTimestamp($tp)->isoFormat($format);
    }
}

if (!function_exists('isJson')) {

    /**
     * @param mixed $data
     * @return bool
     * @throws JsonException
     */
    function isJson(mixed $data): bool
    {
        $json = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        return json_last_error() === JSON_ERROR_NONE;
    }

}

if (!function_exists('isBool')) {
    /**
     * @param mixed $data
     * @return int|string
     */
    function isBool(mixed $data): int|string|null
    {
        if (isTimeStamp($data) && strlen($data) === 10) {
            return tpD($data);
        }

        try {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data)->isoFormat('LLLL');
        } catch (Exception) {
            return $data === null ? '-' : Str::limit($data);
        }

    }
}

if (!function_exists('isTimeStamp')) {
    /**
     * @param mixed $string
     * @return bool
     */
    function isTimeStamp(mixed $string): bool
    {
        try {
            new DateTime('@' . $string);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}

if (!function_exists('setFilter')) {
    /**
     * @param ...$filters
     * @return array
     */
    #[Pure]
    function setFilter(...$filters): array
    {
        $arr = [];
        foreach ($filters as $filter) {

            $arr[$filter[0]] = setFilterKeys($filter);

        }
        return $arr;
    }
}

if (!function_exists('setFilterKeys')) {
    /**
     * @param array $filter
     * @return array
     */
    function setFilterKeys(array $filter): array
    {
        $keys = ['field', 'type', 'closure'];
        return array_combine($keys, $filter);
    }
}

if (!function_exists('returnFilterFields')) {
    /**
     * @param string $fieldName
     * @param string $placeHolder
     * @param string $input
     * @param mixed $data
     * @return array
     */
    #[ArrayShape(['name' => "string", 'placeholder' => "string", 'input' => "string", 'data' => "mixed"])]
    function returnFilterFields(string $fieldName, string $placeHolder, string $input, mixed $data = null): array
    {
        return [
            'name' => $fieldName,
            'placeholder' => $placeHolder,
            'input' => $input,
            'data' => $data
        ];
    }
}

if (!function_exists('filterGenerator')) {
    /**
     * @param array $fields
     * @return Collection
     */
    function filterGenerator(array $fields): Collection
    {
        $arr = [];
        foreach ($fields as $field) {
            $html = html();
            $input = match ($field['input']) {
                "text" => $html->text($field['name'], request()?->query($field['name']) ?? $field['data']),
                "select" => $html->select($field['name'], $field['data'], request()?->query($field['name'] ?? null)),
                default => $html->{$field['input']}($field['name'])
            };
            $arr[] = $input->class('form-control')->placeholder($field['placeholder']);
        }
        if (count($fields) > 1) {
            $arr[] = html()->select('qt', ['0' => 'Ve', 1 => 'Veya'], request()?->query('qt'))->placeholder('Filtre Türünü Seçin')->class('form-control');
        }
        return collect($arr);
    }
}

if (!function_exists('multipleToOneArray')) {
    /**
     * @param $values
     * @return array
     */
    function multipleToOneArray($values): array
    {

        $arr = [];

        foreach ($values as $key => $val) {

            if (is_array($val)) {

                $arr[array_values($val)[0]] = array_values($val)[1];

            } else {

                $arr[$key] = $val;

            }

        }

        return $arr;

    }
}

/**
 * Route Oluşturma
 */
if (!function_exists('routeGenerator')) {
    function routeGenerator(string $name, string $prefix, string $model)
    {

        Route::name("$name.")->prefix("/$prefix")->group(static function () use ($model) {

            Route::get('/', [$model, 'index'])->name('index');

            Route::get('/ekle', [$model, 'create'])->name('create');
            Route::post('/ekle', [$model, 'store'])->name('store');

            Route::get('/duzenle/{id}', [$model, 'edit'])->name('edit');
            Route::match(['post', 'put'], '/duzenle/{id}', [$model, 'update'])->name('update');

            Route::get('/sil/{id}', [$model, 'destroy'])->name('destroy');

        });

    }
}

if (!function_exists('setInput')) {
    /**
     * @param Model $model
     * @return Closure
     */
    function setInput(Model $model): Closure
    {
        return
            static function (string $name, string $placeholder, string $type, bool $isDisabled = false, bool $isRequired = true, mixed $selectData = null, ?string $value = null)
            use ($model) {

                //TODO::Kod tekrarını refactor et. Bk: filterGenerator()

                $html = html();
                $input = match ($type) {
                    'select' => $html->select($name, $selectData),
                    'textarea' => $html->textarea($name),
                    'file' => $html->file($name)->multiple()->acceptImage(),
                    default => $html->input($type, $name)
                };
                if ($type === 'file') {
                    return $input->class('form-control');
                }
                return $input->value($value ?? $model->{$name})->readonly($isDisabled)->placeholder($placeholder)->required($isRequired)->class('form-control');

            };
    }
}

if (!function_exists('biPatiSetMenu')) {
    /**
     * @param string $name
     * @param string $icon
     * @param mixed|null $link
     * @return array
     */
    #[ArrayShape(['name' => "string", 'icon' => "string", 'link' => "string"])]
    function biPatiSetMenu(string $name, string $icon, mixed $link = null): array
    {
        return [
            'name' => $name,
            'icon' => $icon,
            'link' => $link ?? '#' . \Illuminate\Support\Str::slug($name)
        ];
    }
}

if (!function_exists('getRouteList')) {
    /**
     * @return array
     */
    function getRouteList(): array
    {
        return array_filter(array_keys(Route::getRoutes()->getRoutesByName()), static function ($v) {
            return str_starts_with($v, 'web') || str_starts_with($v, 'api');
        });
    }
}

if (!function_exists('biPatiSetSubMenu')) {
    /**
     * @param string $title
     * @param string $icon
     * @param string $prefix
     * @param array|null $options
     * @return string[]
     */
    #[Pure] #[ArrayShape(['title' => "string", 'icon' => "string", 'sub' => "array"])]
    function biPatiSetSubMenu(string $title, string $icon, string $prefix, array|null $options = null): array
    {
        if ($options === null) $options = ['index' => 'Listele', 'create' => 'Ekle'];

        return [
            'title' => $title,
            'icon' => $icon,
            'sub' => subMenuRouteGenerator($prefix, $options)
        ];

    }
}

if (!function_exists('subMenuRouteGenerator')) {
    /**
     * @param string $prefix
     * @param array $options
     * @return array
     */
    function subMenuRouteGenerator(string $prefix, array $options): array
    {
        $arr = [];
        foreach ($options as $key => $val) {
            $arr[$key] = [
                'title' => $val,
                'route' => "$prefix.$key"
            ];
        }
        return $arr;
    }
}

if (!function_exists('isShouldShow')) {
    /**
     * @param array $sub
     * @return bool
     */
    function isShouldShow(array $sub): bool
    {
        foreach ($sub as $v) {
            if (request()?->url() === route('web.'.$v['route'])) {
                return true;
            }
        }
        return false;
    }
}
if ( ! function_exists('parseAddress')) {
    /**
     * @param array $data
     * @return array
     */
    function parseAddress(array $data): array
    {
        if ( ! isset($data['district_id'])) {

            $city = \App\Models\Sehir::where('sehir_title', 'LIKE', '%'.$data['city_name'].'%')->first();
            $county = \App\Models\Ilce::where('ilce_title', 'LIKE', '%'.$data['county_name'].'%')->first();
            $district = \App\Models\Mahalle::where('mahalle_title', 'LIKE', '%'.$data['district_name'].'%')->first();

            $data['sehir_key'] = $city->sehir_key ?? 34;
            $data['ilce_key'] = $county->ilce_key ?? 1103;
            $data['district_id'] = $district->mahalle_key ?? 40139;

            unset($data['city_name'], $data['county_name'], $data['district_name']);

        }

        return $data;
    }
}

if ( ! function_exists('jsonUnserialize')) {
    /**
     * @param string|null $data
     * @return mixed
     */
    function jsonUnserialize(?string $data): mixed
    {
        return $data ? unserialize($data) : $data;
    }
}

if ( ! function_exists('removeLastLetter')) {
    /**
     * remove last letter, its usually "s".
     *
     * @param string|null $value
     * @return string|null
     */
    function removeLastLetter(?string $value): ?string
    {
        return $value ? substr($value, 0, -1) : $value;
    }
}

if ( ! function_exists('sendNotification')) {
    /**
     * @param array $devices
     * @param string $title
     * @param string $body
     */
    function sendNotification(array $devices, string $title, string $body)
    {

        ['fcm_sender_key' => $serverKey, 'fcm_sender_id' => $senderId] = config('notification');

        $client = new FcmClient($serverKey, $senderId);
        $notification = new \Fcm\Push\Notification();

        $instance = \App\Classes\Notification::init($client, $notification);

        return $instance->setDeviceIds($devices)->setTitle($title)->setBody($body)->send();

    }
}


