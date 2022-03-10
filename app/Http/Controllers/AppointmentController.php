<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\UserAppointment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointment = Appointment::get();
        foreach ($appointment as $key => $value) {
            $appointment[$key]->token = Crypt::encryptString($appointment[$key]->id);
        }
        $response = [
            'message' => 'List Appointment',
            'data' => $appointment
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
        $user = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'date' => ['required'],
            'remark' => ['max:1000'],
            'user_id' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $input = $request->all();

        try {
            $request['user_id'] = $user;
            $appointment = Appointment::create($request->all());
            $input['appointment_id'] = $appointment->id;
            foreach($input['user_id'] as $value){
                $input['user_id'] = $value;
                UserAppointment::create($input);
            }
            $response = [
                'message' => 'A new appointment row created',
                'data' => $appointment
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $id = Crypt::decryptString($token);
        $appointment = Appointment::findOrFail($id);

        $response = [
            'message' => 'An appointment row shown',
            'data' => $appointment
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $token)
    {
        $id = Crypt::decryptString($token);
        $appointment = Appointment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'date' => ['required'],
            'remark' => ['max:1000'],
            'user_id' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $appointment->update($request->all());
            $response = [
                'message' => 'An appointment row updated',
                'data' => $appointment
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($token)
    {
        $id = Crypt::decryptString($token);
        $appointment = Appointment::findOrFail($id);

        try {
            $appointment->delete();
            $response = [
                'message' => 'An appointment row deleted',
                'data' => $appointment
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
