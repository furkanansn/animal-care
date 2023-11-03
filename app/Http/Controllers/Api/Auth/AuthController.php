<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\Sms;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class AuthController extends Controller
{
    /**
     * Kullanıcı kayıt işlemleri.
     *
     * @param AuthRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(Request $request): JsonResponse
    {

        $input = $request->all();
        $user = User::create($input);
        $user->register_ip = $request->ip();
        $user->last_login_ip = $request->ip();
        $user->last_activity = (string)time();

        if ($user) {
            $user->save();
            $rand = random_int(100000, 999999);
            Sms::init($user->phone_number)->setTitle()->setMsgForRegister($rand)->send();
            \Auth::attempt($request->only('email', 'password'));
            $user = \Auth::user();
            return $this->sendSuccess([

                'msg' => 'Kayıt başarıyla tamamlandı, size gönderilen doğrulama koduyla aktivasyonu gerçekleştiriniz.',
                'code' => $rand,
                'id' => $user->id,
                'token' => $user?->createToken('user')->accessToken,
                'token_type' => 'Bearer',
                'expires_time' => Carbon::parse(Carbon::now()->addWeeks(1))->toDateTimeString(),
                'user' => $user,

            ], 201);

        }

        return $this->sendError('Beklenmedik bir sorunla karşılaştık, daha sonra tekrar deneyin.');

    }

    /**
     * Kullanıcı kayıt işlemleri
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {

        $cred = $request->only(['email', 'password']);
        if (\Auth::attempt($cred)) {
            $user = \Auth::user();

            if ($user instanceof User) {

                $user->last_activity = time();
                $user->last_login_ip = $request->ip();
                $user->last_login_time = time();
                $user->save();

            }

            $msg = $this->checkApproved($user);

            if (is_array($msg)) {
                return $this->sendSuccess($msg);
            }

            return $msg;

        }

        $msg = 'E-posta ya da parola yanlış!';

        return $this->sendError($msg);


    }


    /**
     * Login operation.
     *
     * @param object|null $user
     * @return array
     */
    #[ArrayShape(['token' => "mixed", 'token_type' => "string", 'expires_time' => "string", 'user' => "null|object", 'msg' => "string"])]
    public function operation(object|null $user): array
    {

        return [
            'token' => $user?->createToken('user')->accessToken,
            'token_type' => 'Bearer',
            'expires_time' => Carbon::parse(Carbon::now()->addWeeks(1))->toDateTimeString(),
            'user' => $user,
            'msg' => "$user?->name hoş geldiniz, başarıyla giriş yapıldı."
        ];

    }

    /**
     * @param $phoneNumber
     * @param $code
     * @return Sms
     */
    public function sendSms($phoneNumber, $code): Sms
    {

        return new Sms();

    }

    /**
     * Kullanıcı hesabının onaylanıp, onaylanmadığını sorgular.
     *
     * @param object|null $user
     * @return array|JsonResponse
     */
    public function checkApproved(object|null $user): array|JsonResponse
    {

        return $user?->is_approved
            ? $this->operation($user)
            : $this->sendError('Hesabınız doğrulanmamış! Lütfen SMS doğrulamasıyla hesabınızı doğrulayın.');

    }


    /**
     * Logout operation.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {

        $token = $request->user()->token();
        $token->revoke();
        return $this->sendSuccess([

            'msg' => 'Başarıyla çıkış yapıldı!'

        ]);

    }


    /**
     * Hesap silme işlemleri
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAccount(Request $request): JsonResponse
    {

        $user = $request->user('api');
        $user->delete();
        return $this->sendSuccess([

            'msg' => 'Hesabınız başarıyla silinmiştir!'

        ]);

    }

    /**
     * Kullanıcı onaylama şeyi.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function userApprove(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->id);

        if ($user->is_approved === 1) {
            return $this->sendError('Hesabınız zaten onaylanmış!', 403);
        }

        $user->is_approved = 1;
        $user->save();

        Sms::init($user->phone_number)->setTitle()->setMsgForApprove($user->name)->send();

        return $this->sendSuccess([
            'msg' => 'Hesabınız başarıyla onaylanmıştır!'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forget(Request $request): JsonResponse
    {
        $phoneNumber = $request->post('phone_number');

        if ($phoneNumber) {
            $user = User::wherePhoneNumber($phoneNumber)->first();
            if ($user) {
                $code = mt_rand(0, 999999);
                PasswordReset::create([
                    'phone_number'  => $phoneNumber,
                    'code'          => $code
                ]);
                //TODO::SMS gönderimi.
            }
        }

        return $this->sendSuccess([
            'msg' => 'Telefon numaranız sistemde kayıtlıysa sms aracılığıya size bir kod gönderdik!'
        ]);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->all();
        $control = PasswordReset::wherePhoneNumber($data['phone_number'])->whereToken($data['token'])->first();

        if ( ! $control) {
            return $this->sendError('Böyle bir kayıt bulunamadı!');
        }

        $user = User::wherePhoneNumber($data['phone_number'])->first();

        if ( ! $user->update(['password' => $data['password']])) {
            return $this->sendError('Parolayı değiştirirken bir hata oluştu!');
        }

        $control->delete();

        return $this->sendSuccess([
           'msg' => 'Parola başarıyla güncellendi! Lütfen giriş yapın.',
           'data' => $user
        ]);
    }

}
