<?php

namespace App\Http\Controllers;

use App\Console\Commands\AppointmentCron;
use App\Jobs\AppointmentReminder;
use App\Mail\AppointmentReminder as MailAppointmentReminder;
use App\Models\Appointment;
use App\Models\UserAppointment;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
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
        $user = auth()->user();
        $appointment = Appointment::orderBy('id', 'desc')->get();
        // if($user->type == 2){
        //     $user_appointment = UserAppointment::where('user_id', $user->id)->get();
        //     $appointment = Appointment::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        // }
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
        $user_appointment = $appointment->user_appointment;
        $i = 0;

        foreach($user_appointment as $value){
            $arrayuser[$i] = $value->user_id;
            $i+=1;
        }
        $appointment->user_id = $arrayuser;

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

        $input = $request->all();

        try {
            $user_app_del = new UserAppointmentController;
            $user_app_del->destroy($id);

            $request['user_id'] = $appointment->user_id;
            $appointment->update($request->all());

            $input['appointment_id'] = $appointment->id;
            
            foreach($input['user_id'] as $value){
                $input['user_id'] = $value;
                UserAppointment::create($input);
            }

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

    public function mailJob(){
        $appointment = Appointment::get();
        $user_appointment = $appointment->user_appointment;
        foreach($appointment as $app){
        $user_appointment = $app->user_appointment;
            foreach($user_appointment as $value){
                $email = $value->user->email;
                $details=[
                    'email' => $email,
                    'name' => $value->name,
                    'user_name' => $value->user->name,
                    'date' => $app->date,
                ];
                $now = Carbon::now();
                $appointment_date = (Carbon::create($app->date));
                $diffInDays = $appointment_date->diffInDays($now);
                if($diffInDays <= 1){
                    Mail::to($email)->send(new MailAppointmentReminder($details));
                } elseif($diffInDays == 3){
                    Mail::to($email)->send(new MailAppointmentReminder($details));
                }
            }
        }

        $response = [
            'message' => 'Email sent successfully'
        ];
        print_r($response);
    }
}
