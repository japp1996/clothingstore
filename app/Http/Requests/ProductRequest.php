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
            'price_1' => 'required|numeric',
            'price_2' => 'required|numeric',
            'category_id' => 'required',
            'collection_id' => 'required',
            'design_id' => 'required',
            'retail' => '',
            'wholesale' => '',
            // 'colors' => 'array_object_not_null:name,name_english',
            'main' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'name_english' => 'Nombre en inglés',
            'description' => 'Descripción',
            'description_english' => 'Descripción en inglés',
            'price_1' => 'Precio Detal',
            'price_2' => 'Precio al mayor',
            'category_id' => 'Categoría',
            'collection_id' => 'Colección',
            'design_id' => 'Diseño',
            'retail' => 'Venta al detal',
            'wholesale' => 'Venta al mayor',
            'colors' => 'colores',
            'main' => 'Imagen principal'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'numeric' => 'El campo :attribute debe ser un número',
            'array_object_not_null' => 'Debes completar los campos en :attribute',
            'mines' => 'La imagen no tiene un formato válido'
        ];
    }

    public function formatErrors(Validator $validator)
    {
        return [ 'error' => $validator->errors()->first() ];
    }
}
