<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BankRequest extends FormRequest
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
            'name' => 'required',
            'bank_id' => 'required',
            'identification' => 'required',
            'number' => 'required|min:20',
            'type' => 'required'
        ];
    }

    public function attributes() 
    {
        return [
            'name' => 'propietario',
            'bank_id' => 'banco',
            'identification' => 'indetificación',
            'number' => 'número',
            'type' => 'tipo'
        ];
    }

    public function formatErrors(Validator $validator)
    {
        return [ 'error' => $validator->errors()->first() ];
    }
}
