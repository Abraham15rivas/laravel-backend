<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Hotel;
use App\Http\Requests\HotelRequest;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::latest()->get()->load('rooms');
        foreach ($hotels as $hotel) {
            $hotel->total_rooms = $hotel->rooms->count();
        }
        return response([
            'success'       => true,
            'total_hotels'  => $hotels->count(),
            'message'       => 'Lista de todos los hoteles',
            'data'          => $hotels
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HotelRequest $request)
    {
        $hotel = Hotel::create($request->all());
        if ($hotel) {
            return response()->json([
                'success' => true,
                'message' => '¡Hotel guardado correctamente! ',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡El hotel no se pudo guardar!',
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
        $hotel = Hotel::whereId($id)->first();
        if ($hotel) {
            return response()->json([
                'success' => true,
                'message' => "¡Detalles del hotel: $hotel->name!",
                'data'    => $hotel
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡hotel no encontrado!',
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
    public function update(HotelRequest $request, $id)
    {
        $hotel = Hotel::whereId($request->id)->update($request->all());
        if ($hotel) {
            return response()->json([
                'success' => true,
                'message' => '¡Hotel actualizado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡El hotel no se pudo actualizar!',
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
        $hotel = Hotel::whereId($id)->first();
        if ($hotel) {
            $hotel->delete();
            return response()->json([
                'success' => true,
                'message' => '¡Hotel borrado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡Hotel no encontrado!',
            ], 500);
        }
    }
}
