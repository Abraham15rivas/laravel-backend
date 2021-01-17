<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Reservation, Room};
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::latest()->get()->load('guest', 'reservationsRooms');
        foreach ($reservations as $reservation) {
            $reservation->total_reservations_rooms = $reservation->reservationsRooms->count();
        }
        return response([
            'success' => true,
            'total_reservations' => $reservations->count(),
            'message' => 'Lista de las reservaciones',
            'data' => $reservations
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        DB::beginTransaction();
        try{
            $not_available = collect();
            $available = collect();
            $no_register = collect();

            $reservation = new Reservation();
            $reservation->start_date = $request->start_date;
            $reservation->finish_date = $request->finish_date;
            $reservation->guest_id = $request->guest_id;
            $reservation->status = 'activo';
            $reservation->total_price = 0;

            foreach ($request->rooms_selected as $room) {
                $room_selected = Room::whereId($room)->with('roomType')->first();
                if ($room_selected) {
                    if ($room_selected->status === 'disponible') {
                        $room_selected->update(['status' => 'ocupado']);
                        $reservation->total_price += $room_selected->roomType->price_day;
                        $available->push($room);
                    } else {
                        $not_available->push($room);
                    }
                } else {
                    $no_register->push($room);
                }             
            }

            if ($not_available->count() == count($request->rooms_selected)) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Ningunas de las habitaciones solicitadas están disponibles!',
                    'data'    => [
                        'No disponibles'  => $not_available,
                        'No resgistradas' => $no_register
                    ]
                ], 400);
            } else {
                $reservation->amount_room = $available->count();
                $reservation->save();
            }

            $reservation->reservationsRooms()->sync($available->toArray());

            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            throw $e;
        }

        if ($reservation) {
            return response()->json([
                'success' => true,
                'message' => '¡Reservación realizada correctamente! ',
                'data'    => [
                    'No disponibles'  => $not_available,
                    'No resgistradas' => $no_register
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡Reservación fallida!',
                'data'    => [
                    'No disponibles'  => $not_available,
                    'No resgistradas' => $no_register
                ]
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::whereId($id)->first();
        if ($reservation) {
            $reservation->load('guest', 'reservationsRooms');
            return response()->json([
                'success' => true,
                'message' => "¡Detalles de reservación de habitaciones!",
                'data'    => $reservation
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡Reservación no encontrada!',
                'data'    => ''
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationRequest $request, $id)
    {
        $not_available = collect();
        $available = collect();
        $no_register = collect();

        $reservation = Reservation::whereId($request->id)->first();        
        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => '¡La reservación no existe!',
            ], 500);
        }
        
        foreach ($reservation->reservationsRooms as $room) {
            $room_selected = Room::whereId($room->id)->first();
            if ($room_selected->status != 'disponible') {
                $room_selected->update(['status' => 'disponible']);
            }
        }

        $reservation->start_date = $request->start_date;
        $reservation->finish_date = $request->finish_date;
        $reservation->guest_id = $request->guest_id;
        $reservation->status = 'activo';
        $reservation->total_price = 0;
        $reservation->amount_room = 0;

        foreach ($request->rooms_selected as $room) {
            $room_selected = Room::whereId($room)->with('roomType')->first();
            if ($room_selected) {
                if ($room_selected->status === 'disponible') {
                    $room_selected->update(['status' => 'ocupado']);
                    $reservation->total_price += $room_selected->roomType->price_day;
                    $reservation->amount_room ++;
                    $available->push($room);
                } else {
                    $not_available->push($room);
                }                
            } else {
                $no_register->push($room);
            }
        }

        $reservation->reservationsRooms()->sync($available->toArray());
        $reservation->save();
        
        if ($reservation) {
            return response()->json([
                'success' => true,
                'message' => '¡Reservación actualizada correctamente!',
                'data'    => [
                    'No disponibles'  => $not_available,
                    'No resgistradas' => $no_register
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡La reservación no se pudo actualizar!',
                'data'    => [
                    'No disponibles'  => $not_available,
                    'No resgistradas' => $no_register
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::whereId($id)->first();
        if ($reservation) {
            $reservation->delete();
            return response()->json([
                'success' => true,
                'message' => '¡Reservación borrada correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡Reservación no encontrada!',
            ], 500);
        }
    }
}
