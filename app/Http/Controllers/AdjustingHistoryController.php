<?php

namespace App\Http\Controllers;

use App\Models\AdjustingHistory;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class AdjustingHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($token)
    {
        $id = Crypt::decryptString($token);
        $adjustinghistory = AdjustingHistory::where('journal_id', '=', $id)->get();

        
        foreach ($adjustinghistory as $value) {
            $value->journal_id = Journal::findOrFail($value->journal_id)->title;
        }

        $response = [
            'message' => 'List Adjusting History',
            'data' => $adjustinghistory
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
        $adjustinghistory = AdjustingHistory::create($request);
        $response = [
            'message' => 'A new adjusting history row created',
            'data' => $adjustinghistory
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $id = Crypt::decrypt($token);
        $adjustinghistory = AdjustingHistory::findOrFail($id);
        $response = [
            'message' => 'A journal row shown',
            'data' => $adjustinghistory
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
