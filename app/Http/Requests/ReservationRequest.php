<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'start_date'  => 'required|date', 
            'finish_date' => 'required|date',
            'amount_room' => 'required|integer', 
            'total_price' => 'required|integer', 
            'guest_id'    => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'start_date.required'   => 'El nombre es obligatorio.',
            'finish_date.required'  => 'El nombre es obligatorio.',
            'start_date.date'       => 'Debe ser un formato de fecha valido',
            'finish_date.date'      => 'Debe ser un formato de fecha valido',
            'amount_room.required'  => 'Añade una cantidad',
            'amount_room.integer'   => 'Debe ser numerico',
            'total_price.required'  => 'Añade un precio',
            'total_price.integer'   => 'Debe ser numerico',
            'guest_id.required'     => 'Añade un id valido',
            'guest_id.integer'      => 'Debe ser numerico'
        ];
    }
}
