<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'code'          => 'required|string|min:1|max:199',
            'number_floor'  => 'required|integer',
            'number_room'   => 'required|integer', 
            'status'        => 'required|in:disponible,inactivo,mantenimiento,ocupado,reservado', 
            'room_type_id'  => 'required|integer',
            'hotel_id'      =>  'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'code.required'         => 'El codigo es obligatorio.',
            'code.min'              => 'El codigo debe ser mínimo 1 caracteres',
            'code.max'              => 'El codigo debe ser máximo 199 caracteres',
            'number_floor.required' => 'Añade un número de piso',
            'number_room.required'  => 'Añade un número de habitación',
            'number_floor.integer'  => 'Debe ser numerico',
            'number_room.integer'   => 'Debe ser numerico',
            'room_type_id.required' =>  'Añade un tipo de habitación',
            'room_type_id.integer'  =>  'Debe ser numerico',
            'hotel_id.required'     =>  'Añade un hotel',
            'hotel_id.integer'      =>  'Debe ser numerico'
        ];
    }
}
