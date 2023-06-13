<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * The Login User in program page.
     */
    public function login(Request $request)
    {

        $auth = Auth::attempt($request->all());

        if ($auth) {
            $user = Auth::user();
            $token = $user->createToken('token')->accessToken;

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => [
                    'message' => 'Usuario logueado correctamente',
                    'token' => $token,
                    'user' => $user
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'status' => 400,
            'data' => [
                'message' => 'Usuario con credenciales erroneas'
            ]
        ], 400);


    }

    /**
     * The register User in bdd->pg
     */
    public function register(Request $request)
    {

        $registerData = $request->all();
        $validator = Validator::make($registerData, [
            'name' => 'required|string|max:15',
            'email' => 'required|email|string',
            'password' => 'required|min:4',
            'reply_pass' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'data' => [
                    'message' => $validator->errors()
                ]
            ], 400);
        }

        $registerData['password'] = bcrypt($registerData['password']);
        $user = User::create($registerData);
        $token = $user->createToken('token')->accessToken;

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => [
                'message' => 'Se ha registrado correctamente el usuario.',
                'user' => $user,
                'token' => $token
            ]
        ], 200);
    }

    public function getOneUser(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $user = User::find($request->id);

            if (!empty($user)) {
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'data' => [
                        'message' => 'Usuario encontrado correctamente.',
                        'user' => $user
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 301,
                    'data' => [
                        'message' => 'Usuario no encontrado'
                    ]
                ], 301);
            }
        }
        return \response()->json([
            'status' => 401,
            'user' => 'Not unauthenticated'
        ]);
    }

    public function logout()
    {
        if (Auth::guard('api')->check()) {
            $accessToken = Auth::guard('api')->user()->token();
            $user_id = Auth::guard('api')->id();

            DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);
            $accessToken->revoke();
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => [
                    'message' => 'Se ha deslogueado correctamente',
                    'user' => $user_id
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'status' => 400,
            'data' => [
                'message' => 'No se ha podido desloguear'
            ]
        ], 400);

    }

    public function getAllUsersSystem()
    {
        if (Auth::guard('api')->check()) {
            $users = User::all();
            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => [
                    'message' => 'Listado de usuarios',
                    'users' => $users
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'status' => 400,
            'data' => [
                'message' => 'No se encuentra logueado para ver esta seccion, por favor logueese y pruebe mas tarde.'
            ]
        ], 400);
    }
}
