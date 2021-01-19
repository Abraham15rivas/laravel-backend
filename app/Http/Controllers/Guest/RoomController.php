<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::where('status', 'disponible')->get()->load('roomType', 'hotel');
        return response([
            'success' => true,
            'total_rooms' => $rooms->count(),
            'message' => 'Lista de las habitacines disponibles',
            'data' => $rooms
        ], 200);
    }
}
