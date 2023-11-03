<?php

//if (!function_exists('clientInstance')) {
//    /**
//     * @return \Twilio\Rest\Client
//     * @throws \Twilio\Exceptions\ConfigurationException
//     */
//    function clientInstance(): \Twilio\Rest\Client
//    {
//
//        $sid = 'AC51f75515aeaff0d884cd276ea05a29ef';
//        $token = 'cf3611eb4b5c505f82e4ba0bd1c6e922';
//
//        return new Twilio\Rest\Client($sid, $token);
//
//    }
//}


use JetBrains\PhpStorm\ArrayShape;

if (!function_exists('successMsg')) {

    /**
     * Gereksiz kod kalabalığını engellemek için
     *
     * @param string $msg
     * @return string[]
     */
    #[ArrayShape(['msg' => ""])]
    function successMsg(string|null $msg = null): array {

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
    function errorMsg(string|null $msg = null): string {

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

            'msg'           => (string) $exception?->getMessage(),
            'code'          => (string) $exception?->getCode(),
            'file'          => (string) $exception?->getFile(),
            'line'          => (string) $exception?->getLine(),
            'ip_address'    => $_SERVER['REMOTE_ADDR']

        ];
    }
}

if (!function_exists('setFlashData')) {
    /**
     * @param string $msg
     * @param bool $success
     * @return array
     */
    #[ArrayShape(['msg' => "string", 'success' => "bool"])]
    function setFlashData(string $msg, bool $success = true): array
    {

        return [

            'msg'       => $msg,
            'success'   => $success

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
            return 'Giriş yapılmamış!';
        }


        return \Carbon\Carbon::createFromTimestamp($tp)->isoFormat($format);
    }
}
