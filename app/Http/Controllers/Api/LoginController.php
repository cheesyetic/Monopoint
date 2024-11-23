<?php

namespace App\Http\Controllers\Api;

// use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if($user = User::where('email','=', $request->email)->first()){
            $user->token = Crypt::encryptString($user->id);
            if (!$user || !Hash::check($request->password, $user->password)) {
                $response = [
                    'success' => false,
                    'message' => 'Password yang anda masukkan salah, coba lagi'
                ];
                return response()->json($response, Response::HTTP_BAD_REQUEST);
            }
            Auth::guard('user')->login($user);
            $token = $user->createToken('ApiToken')->plainTextToken;

            $response = [
            'success'   => true,
            'user'      => $user,
            'token'     => $token,
            'token_type' => 'Bearer',
            ];

            return response()->json($response, Response::HTTP_OK);

        }
        else{
            $response = [
                'success' => false,
                'message' => 'Email anda salah, coba lagi'
            ];
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        
    }

    public function token($request)
    {
        // $user = auth()->user();
        $token = Crypt::encryptString($request);

        $response = [
            'success'   => true,
            'data'      => $token,
            // 'token'     => $user->token
        ];

        return response($response, 201);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard('user')->logout();
        auth()->user()->tokens()->delete();
        $response = [
            'success'   => true,
            ];
        return response()->json($response, Response::HTTP_OK);
    }

}
