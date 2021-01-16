<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
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
            'number_floor'  => 'required|integer', 
            'number_room'   => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'El nombre es obligatorio.',
            'name.min'              => 'El nombre debe ser mínimo 1 caracteres',
            'name.max'              => 'El nombre debe ser máximo 199 caracteres',
            'number_floor.required' => 'Añade una cantidad de pisos',
            'number_room.required'  => 'Añade una cantidad de habitaciones',
            'number_floor.integer' => 'Debe ser numerico',
            'number_room.integer'  => 'Debe ser numerico'
        ];
    }
}
