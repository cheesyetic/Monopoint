<?php

namespace App\Http\Controllers;

use App\Models\AdjustingHistory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdjustingHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adjustinghistory = AdjustingHistory::get();

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
            'message' => 'A new journal row created',
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
    public function show($id)
    {
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
