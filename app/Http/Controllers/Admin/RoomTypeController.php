<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RoomType;
use App\Http\Requests\RoomTypeRequest;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_rooms = RoomType::latest()->get()->load('rooms');
        foreach ($type_rooms as $type_room) {
            $type_room->total_rooms = $type_room->rooms->count();
        }
        return response([
            'success' => true,
            'total_type_rooms' => $type_rooms->count(),
            'message' => 'Lista de los tipos de habitación',
            'data' => $type_rooms
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomTypeRequest $request)
    {
        $type_room = RoomType::create($request->all());
        if ($type_room) {
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
        $type_room = RoomType::whereId($id)->first();
        if ($type_room) {
            return response()->json([
                'success' => true,
                'message' => "¡Detalles del tipo de habitacón: $type_room->titulo!",
                'data'    => $type_room
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
    public function update(RoomTypeRequest $request, $id)
    {
        $type_room = RoomType::whereId($request->id)->update($request->all());
        if ($type_room) {
            return response()->json([
                'success' => true,
                'message' => '¡tipo de habitación actualizado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡El tipo de habitación no se pudo actualizar!',
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
        $type_room = RoomType::findOrFail($id);
        $type_room->delete();
        if ($type_room) {
            return response()->json([
                'success' => true,
                'message' => '¡tipo de habitacón borrado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡tipo de habitacón no encontrado!',
            ], 500);
        }
    }
}
