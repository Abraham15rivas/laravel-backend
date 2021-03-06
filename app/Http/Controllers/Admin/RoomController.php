<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;
use App\Http\Requests\RoomRequest;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::latest()->get()->load('roomType', 'hotel', 'roomsReservations');
        return response([
            'success' => true,
            'total_rooms' => $rooms->count(),
            'message' => 'Lista de las habitación',
            'data' => $rooms
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $room = Room::create($request->all());
        if ($room) {
            return response()->json([
                'success' => true,
                'message' => '¡tipo de habitación guardado correctamente! ',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡El tipo de habitación no se pudo guardar!',
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
        $room = Room::whereId($id)->first();
        if ($room) {
            return response()->json([
                'success' => true,
                'message' => "¡Detalles del tipo de habitacón: $room->titulo!",
                'data'    => $room
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'tipo de habitacón no encontrado!',
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
    public function update(RoomRequest $request, $id)
    {
        $room = Room::whereId($request->id)->update($request->all());
        if ($room) {
            return response()->json([
                'success' => true,
                'message' => '¡habitación actualizado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡La habitación no se pudo actualizar!',
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
        $room = Room::whereId($id)->first();
        if ($room) {
            $room->delete();
            return response()->json([
                'success' => true,
                'message' => '¡habitacón borrado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡habitacón no encontrado!',
            ], 500);
        }
    }
}
