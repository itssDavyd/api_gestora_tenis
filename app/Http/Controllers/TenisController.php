<?php

namespace App\Http\Controllers;

use App\Models\Tenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guard('api')->check()) {
            $tenis = Tenis::all();
            if (!empty($tenis)) {
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'data' => [
                        'message' => 'Listado de todos los tenis',
                        'tenis' => $tenis
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'data' => [
                        'message' => 'No se ha podia realizar la peticion de mostrar el listado de tenis',
                    ]
                ], 401);
            }
        }

        return response()->json([
            'success' => false,
            'status' => 301,
            'data' => [
                'message' => 'Usuario no autentificado para poder ver este listado.',
            ]
        ], 401);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $validator = Validator::make($request->all(), [
                'marca' => 'required|max:50',
                'color' => 'required|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'data' => [
                        'message' => 'Datos con formatos mal realizados',
                        'error' => $validator->errors()
                    ]
                ], 401);
            }

            $dataRQ = $request->all();
            $dataRQ['user_id'] = Auth::guard('api')->user()->id;
            $dataRQ['fecha_alta'] = date('Y-m-d H:i:s');
            $dataRQ['fecha_modificacion'] = date('Y-m-d H:i:s');
            $tenis = Tenis::create($dataRQ);

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => [
                    'message' => 'Tenis creado correctamente',
                    'tenis' => $tenis
                ]
            ], 200);


        }
        return response()->json([
            'success' => false,
            'status' => 301,
            'data' => [
                'message' => 'Usuario no autentificado para poder crear entrada de tenis.'
            ]
        ], 401);

    }

    /**
     * Display the specified resource.
     */
    public function showOneTenis()
    {
        $user = Auth::guard('api')->user();
        if (Auth::guard('api')->check() && $user) {
            $tenis = Tenis::where('user_id', $user->id)->get();

            if (!empty($tenis)) {
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'data' => [
                        'message' => 'Listado de los tenis disponibles del usuario ' . $user->name,
                        'tenis' => $tenis
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 301,
                    'data' => [
                        'message' => 'No se ha podido procesar su solicitud'
                    ]
                ], 301);
            }
        }
        return response()->json([
            'success' => false,
            'status' => 401,
            'data' => [
                'message' => 'Usuario no autentificado para poder ver listado de tenis.'
            ]
        ], 401);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenis $tenis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenis $tenis)
    {
        //
    }
}
