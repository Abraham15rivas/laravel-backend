<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Guest, User};
use App\Http\Requests\GuestRequest;

class GuestController extends Controller
{
    public function store(GuestRequest $request)
    {
        $guest = [];
        $id = auth()->user()->id;
        $validate_ci = Guest::where('ci', $request->ci)->first();

        if (!$validate_ci) {
            if (auth()->user()->guest == null) {
                $request->merge(['user_id' => $id]);
                $guest = Guest::create($request->all());
            } else {
                return $this->show($id);
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
        $guest = auth()->user()->guest;

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
        $id = auth()->user()->id;
        $guest = auth()->user()->guest->update($request->all());

        if ($guest) {
            return response()->json([
                'success' => true,
                'message' => '¡Huésped actualizado correctamente!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "¡El huésped no se pudo actualizar!",
            ], 500);
        }
    }
}
