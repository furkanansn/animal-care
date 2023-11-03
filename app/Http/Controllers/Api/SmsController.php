<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class SmsController extends Controller
{

    private Client $client;


    /**
     * @throws ConfigurationException
     */
    public function __construct(
        private string $sid = 'AC51f75515aeaff0d884cd276ea05a29ef',
        private string $token = 'cf3611eb4b5c505f82e4ba0bd1c6e922'
    )
    {

        $this->client = new Client($this->sid, $this->token);

    }


    public function sendApproveCode(Request $request)
    {

        $rand = mt_rand(100000, 999999);
        //$this->checkSmsDB($request->id, $rand);


        $message = $this->client->messages->create('+905067522939', [
           'from' => '+16502821183',
           'body' => "BiPati için doğrulama kodu: $rand"
        ]);
        dd($message);

    }

    private function checkSmsDB($uid, $rand)
    {

        //Bu kullanıcının daha önceki sms onaylamalarını silme işlemleri.

        //----

        //Silme işleminden sonra yeni doğrulama kodunu dbye kaydet.

    }


}
