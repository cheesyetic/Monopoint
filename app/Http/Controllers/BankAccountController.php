<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankacc = BankAccount::get();
        $response = [
            'message' => 'List Bank Account',
            'data' => $bankacc
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
            'name' => ['required', 'max:45'],
            'account_number' => ['required', 'max:45']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $bankacc = BankAccount::create($request->all());
            $response = [
                'message' => 'A new bank account row created',
                'data' => $bankacc
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
    public function show($id)
    {
        $bankacc = BankAccount::findOrFail($id);
        
        $response = [
            'message' => 'A bank account row shown',
            'data' => $bankacc
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
    public function update(Request $request, $id)
    {

        $bankacc = BankAccount::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:45'],
            'account_number' => ['required', 'max:45']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $bankacc->update($request->all());
            $response = [
                'message' => 'A new bank account row updated',
                'data' => $bankacc
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
    public function destroy($id)
    {
        $bankacc = BankAccount::findOrFail($id);

        try {
            $bankacc->delete();
            $response = [
                'message' => 'A bank account row deleted',
                'data' => $bankacc
            ];

            return response()->json($response, Response::HTTP_OK);
            
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
