<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
            'name'          => 'required|string|min:1|max:199', 
            'last_name'     => 'required|string|min:1|max:199',
            'age'           => 'required|integer', 
            'number_phone'  => 'required|integer', 
            'address'       => 'nullable|string',
            'user_id'       => 'nullable|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'El nombre es obligatorio.',
            'name.min'              => 'El nombre debe ser mínimo 1 caracteres',
            'name.max'              => 'El nombre debe ser máximo 199 caracteres',
            'last_name.required'    => 'El nombre es obligatorio.',
            'last_name.min'         => 'El nombre debe ser mínimo 1 caracteres',
            'last_name.max'         => 'El nombre debe ser máximo 199 caracteres',
            'ci.required'           => 'Añade una identificacion',
            'ci.integer'            => 'Debe ser numerico',
            'ci.unique'             => 'No puede estar duplicada',
            'number_phone.required' => 'Añade un numero de contacto',
            'number_phone.integer'  => 'Debe ser numerico'
        ];
    }
}
