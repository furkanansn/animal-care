<?php

namespace App\Http\Requests\Auth;

use App\Http\Traits\ReturnResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;

class AuthRequest extends FormRequest
{
    use ReturnResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['email' => "string", 'phone_number' => "string"])]
    public function rules(): array
    {
        return [
            'email'         => 'bail|unique:users|email|required',
            'phone_number'  => 'bail|unique:users|required'
        ];
    }


    /**
     * @param \Validator|Validator $validator
     */
    public function failedValidation(\Validator|Validator $validator): HttpResponseException
    {

        throw new HttpResponseException($this->sendError('Girdiğiniz e-posta ya da telefon numarası daha önce kullanılmış.'));

    }
}
