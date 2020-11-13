<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;



class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "username"=>"required|min:5|max:255",
            "email"=>"required|email|unique:users,email",
            "password"=>"required",
            "role"=>"required|max:2|min:1"
        ];
    }

    public function messages()
    {
        return [
            "email.email"=>"Неверный формат адреса электронной почты",
            "required"=>"Поле должно быть заплнено",
            "min"=>"Неверная длина поля",
            "max"=>"Неверная длина поля",
        ];
    }

    protected function failedValidation(Validator $validator){

        throw new HttpResponseException(response()->json($validator->errors(),400));
    }
}
