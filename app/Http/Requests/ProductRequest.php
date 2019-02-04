<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name_english' => 'required',
            'description' => 'required',
            'description_english' => 'required',
            'price_1' => 'required|numeric|min:1',
            'price_2' => 'required|numeric|min:1',
            'category_id' => 'required',
            'collection_id' => 'required',
            // 'design_id' => 'required',
            'retail' => '',
            'wholesale' => '',
            // 'colors' => 'array_object_not_null:name,name_english',
            'main' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'name_english' => 'nombre en inglés',
            'description' => 'descripción',
            'description_english' => 'descripción en inglés',
            'price_1' => 'precio detal',
            'price_2' => 'precio al mayor',
            'category_id' => 'categoría',
            'collection_id' => 'colección',
            // 'design_id' => 'Diseño',
            'retail' => 'venta al detal',
            'wholesale' => 'Venta al mayor',
            'colors' => 'colores',
            'main' => 'imagen principal'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'numeric' => 'El campo :attribute debe ser un número',
            'array_object_not_null' => 'Debes completar los campos en :attribute',
            'mines' => 'La imagen no tiene un formato válido',
            'min' => 'El valor mínimo :attribute es de :min'
        ];
    }

    public function formatErrors(Validator $validator)
    {
        return [ 'error' => $validator->errors()->first() ];
    }
}
