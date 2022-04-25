<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

     use ApiResponse;
     
     abstract public function rules();

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->ApiError(
        $validator->errors(),
        Response::HTTP_UNPROCESSABLE_ENTITY,
        ));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->ApiError(
            null,
            Response::HTTP_UNAUTHORIZED
        ));
    }
}