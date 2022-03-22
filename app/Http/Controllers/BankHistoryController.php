<?php

namespace App\Http\Controllers;

use App\Models\BankHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BankHistoryController extends Controller
{
    public function index(){
        $bankhistory = BankHistory::orderBy('date', 'desc')->get();
        $response = [
            'message' => 'List Bank History',
            'data' => $bankhistory
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request){
        $bankhistory = BankHistory::create($request);
        $response = [
            'message' => 'A new bank history row created',
            'data' => $bankhistory
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
