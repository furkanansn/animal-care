<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateProfileRequest extends FormRequest
{
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
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * @param \Validator|Validator $validator
     */
    public function failedValidation(\Validator|Validator $validator): HttpResponseException
    {

        throw new HttpResponseException($this->sendError('Girdiğiniz değerler, kontrollerimize uymuyor!'));

    }
}
