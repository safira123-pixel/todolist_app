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

     protected function failedValidation(Validator $validator){
         throw new HttpResponseException($this->ApiError(
             $validator->error(),
             Response::HTTP_UNPROCESSABLE_ENTITY
         ));
     }

     protected function failedAuthorization(){
         throw new HttpResponseException($this->apiError(
             null,
             Response::HTTP_UNAUTHORIZED
         ));
     }

    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // public function rules()
    // {
    //     return [
    //         //
    //     ];
    // }
}
