<?php

namespace App\Http\Controllers;

use App\Models\AccountingPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AccountingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountingperiod = AccountingPeriod::get();
        foreach ($accountingperiod as $key => $value) {
            $accountingperiod[$key]->token = Crypt::encryptString($accountingperiod[$key]->id);
        }
        $response = [
            'message' => 'List Accounting Period',
            'data' => $accountingperiod
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'start' => ['required'],
            'end' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $accountingperiod = AccountingPeriod::create($request->all());
            $response = [
                'message' => 'A new accounting period row created',
                'data' => $accountingperiod
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
        $accountingperiod = AccountingPeriod::findOrFail($id);

        $response = [
            'message' => 'An accounting period row shown',
            'data' => $accountingperiod
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
        $accountingperiod = AccountingPeriod::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'start' => ['required'],
            'end' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $accountingperiod->update($request->all());
            $response = [
                'message' => 'An accounting period row updated',
                'data' => $accountingperiod
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
        $accountingperiod = AccountingPeriod::findOrFail($id);

        try {
            $accountingperiod->delete();
            $response = [
                'message' => 'An accounting period row deleted'
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
    public function activateDeactivate($id){
        $accountingperiod = AccountingPeriod::findOrFail($id);
        $status = $accountingperiod->status;

        if($status == 0){
            try{
                $activests = 1;
                $query = AccountingPeriod::select("*")->where('status', '=', $activests)->get();
                foreach ($query as $value) {
                    $value->status=0;
                    $value->save();
                }
                $accountingperiod->status = 1;
                $accountingperiod->save();
                $response = [
                    'message' => 'This period has been activated.',
                    'data' => $accountingperiod
                ];
    
                return response()->json($response, Response::HTTP_OK);
            } catch(QueryException $e){
                return response()->json([
                    'message' => "Failed " . $e->errorInfo
                ]);
            }
        }
        else{
            try{
                $accountingperiod->status = 0;
                $accountingperiod->save();
                $response = [
                    'message' => 'This period has been deactivated.'
                ];
    
                return response()->json($response, Response::HTTP_OK);
                } catch(QueryException $e){
                return response()->json([
                    'message' => "Failed " . $e->errorInfo
                ]);
            }
        }
        
    }
}
