<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Guest, User};
use App\Http\Requests\GuestRequest;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guests = Guest::latest()->get()->load('user', 'reservations');
        foreach ($guests as $guest) {
            $guest->total_reservations = $guest->reservations->count();
        }
        return response([
            'success' => true,
            'total_guests' => $guests->count(),
            'message' => 'Lista de los huéspedes',
            'data' => $guests
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuestRequest $request)
    {
        $guest = [];
        $validate_ci = Guest::where('ci', $request->ci)->first();
        $validate_user = User::whereId($request->user_id)->with('guest')->first();

        if (!$validate_ci) {
            if ($validate_user != null) {
                if (!$validate_user->guest) {
                    if ($validate_user->role_id === 2) {
                        $guest = Guest::create($request->all());
                    } else {
                        $error = "Usuario seleccionado es Administrador, seleccionar uno de tipo cliente";
                    }
                } else {
                    $error = "Usuario en uso";
                }
            } else {
                $error = "Usuario no existe";
            }
        } else {
            $error = "CI duplicado";
        }

        if ($guest) {
            return response()->json([
                'success' => true,
                'message' => '¡Huésped guardado correctamente! ',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => $error,
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
        $guest = Guest::whereId($id)->first()->load('user');
        if ($guest) {
            return response()->json([
                'success' => true,
                'message' => "¡Detalles del huésped: $guest->name!",
                'data'    => $guest
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡Huésped no encontrado!',
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
    public function update(GuestRequest $request, $id)
    {
        $guest = [];
        $validate_user = User::whereId($request->user_id)->with('guest')->first();

        if ($validate_user != null) {
            if ($validate_user->role_id === 2) {
                $guest = Guest::whereId($request->id)->update($request->all());
            } else {
                $error = "Usuario seleccionado es Administrador, seleccionar uno de tipo cliente";
            }
        } else {
            $error = "Usuario no existe";
        }

        if ($guest) {
            return response()->json([
                'success' => true,
                'message' => '¡Huésped actualizado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "¡El huésped no se pudo actualizar! $error",
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
        $guest = Guest::findOrFail($id);
        $guest->delete();
        if ($guest) {
            return response()->json([
                'success' => true,
                'message' => '¡Huésped borrado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '¡Huésped no encontrado!',
            ], 500);
        }
    }
}
