<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\UserAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class UserAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($token)
    {
        $id = Crypt::decryptString($token);
        $user_appointment = UserAppointment::where('appointment_id', '=', $id)->get();

        foreach($user_appointment as $value){
            $value->user_name = $value->user->name;
        }

        $response = [
            'message' => 'List User Appointment',
            'data' => $user_appointment
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_appointment = UserAppointment::create($request);
        $response = [
            'message' => 'A new user appointment row created',
            'data' => $user_appointment
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}