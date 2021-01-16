<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
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
            'titulo'    => 'required|string|min:1|max:199', 
            'price_day' => 'required', 
        ];
    }

    public function messages()
    {
        return [
            'titulo.required'    => 'El nombre es obligatorio.',
            'titulo.min'         => 'El nombre debe ser mínimo 1 caracteres',
            'titulo.max'         => 'El nombre debe ser máximo 199 caracteres',
            'price_day.required' => 'Añade una tarifa por tipo de habitación',
        ];
    }
}
