<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journal = Journal::get();

        $response =[
            'message' => 'List Journal',
            'data' => $journal
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
            'title' => ['required', 'max:45'],
            'date' => ['required'],
            'remark' => ['max:1000'],
            'ref' => ['max:45'],
            'is_reimburse' => ['required'],
            'chart_account_id' => ['required'],
            'accounting_period_id' => ['required'],
            'bank_account_id' => ['required'],
            'project_id' => ['required'],
            'user_id' => ['required'] 
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $journal = Journal::create($request->all());
            $response = [
                'message' => 'A new journal row created',
                'data' => $journal
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
        $journal = Journal::findOrFail($id);
        $response = [
            'message' => 'A journal row shown',
            'data' => $journal
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
        $journal = Journal::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:45'],
            'date' => ['required'],
            'remark' => ['max:1000'],
            'ref' => ['max:45'],
            'is_reimburse' => ['required'],
            'chart_account_id' => ['required'],
            'accounting_period_id' => ['required'],
            'bank_account_id' => ['required'],
            'project_id' => ['required'],
            'user_id' => ['required'] 
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $journal->update($request->all());
            $response = [
                'message' => 'A journal row updated',
                'data' => $journal
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
        $journal = Journal::findOrFail($id);

        try {
            $journal->delete();
            $response = [
                'message' => 'A journal row deleted',
                'data' => $journal
            ];

            return response()->json($response, Response::HTTP_OK);
            
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
