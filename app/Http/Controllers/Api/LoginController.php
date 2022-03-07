<?php

namespace App\Http\Controllers\Api;

// use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user= User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'success'   => false,
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

            $token = $user->createToken('ApiToken')->plainTextToken;        

            $response = [
            'success'   => true,
            'user'      => $user,
            'token'     => $token,
            'token_type' => 'Bearer',
            ];
    
            return response()->json($response, Response::HTTP_OK);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        $response = [
            'success'   => true,
            ];
        return response()->json($response, Response::HTTP_OK);
    }

}
