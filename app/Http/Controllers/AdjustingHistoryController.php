<?php

namespace App\Http\Controllers;

use App\Models\AccountingPeriod;
use App\Models\AdjustingHistory;
use App\Models\BankAccount;
use App\Models\ChartAccount;
use App\Models\Journal;
use App\Models\Project;
use App\Models\User;
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
            if( $value->project != null){
                $value->project_name = $value->project->name;
            }
            else $value->project_name = "Data terhapus";
            if( $value->user != null){
                $value->user_name = $value->user->name;
            }
            else $value->user_name = "Data terhapus";
            if( $value->chart_account != null){
                $value->chart_account_name = $value->chartaccount->name;;
            }
            else $value->chart_account_name = "Data terhapus";
            if( $value->accounting_period != null){
                $value->accounting_period_name = $value->accountingperiod->name;;
            }
            else $value->accounting_period_name = "Data terhapus";
            if( $value->bankaccount != null){
                $value->bank_account_name = $value->bankaccount->name;
            }
            else $value->bank_account_name = "Data terhapus";
        
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

        foreach ($adjustinghistory as $value) {
            $value->journal_id = Journal::findOrFail($value->journal_id)->title;
            $value->project_id = Project::findOrFail($value->project_id)->name;
            $value->user_id = User::findOrFail($value->user_id)->name;
            $value->chart_account_id = ChartAccount::findOrFail($value->chart_account_id)->name;
            $value->accounting_period_id = AccountingPeriod::findOrFail($value->accounting_period_id)->name;
            $value->bank_account_id = BankAccount::findOrFail($value->bank_account_id)->name;
            $value->project_id = Project::findOrFail($value->project_id)->name;
        }

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
