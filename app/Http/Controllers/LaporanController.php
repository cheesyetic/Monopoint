<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BankHistory;
use App\Models\Journal;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LaporanController extends Controller
{
    public function index(Request $request){
        $query = Journal::with(['user', 'chartAccount', 'accountingPeriod', 'project', 'asset', 'bankAccount']);
        $query->where('status', '3' );
        $bankacc = BankAccount::get();
        $total_in_bank = 0;
        foreach($bankacc as $ba){
            $total_in_bank = $total_in_bank + $ba->balance;
        }
        $total_start_date = 0;
        $total_end_date = 0;

        if($request->keyword){
            $query->where('title','ILIKE','%'.$request->keyword.'%');
        }
        if($request->sortbank){
                $query->orderBy('bank_account_id', $request->sortbank);
        }
        if($request->sortdate){
            $query->orderBy('date', $request->sortdate);
        }
        if($request->date){
            $query->whereHas('accountingPeriod', function($query) use($request){
                $query->where('accounting_period_id', $request->date);
            });
        }
        if($request->start_date){
            $query->where('date', '>=', $request->start_date);
            if($request->bank){
                $bankhistory = BankHistory::where('bank_account_id', $request->bank)->
                whereDate('date', '<=', $request->start_date)->orderBy('date', 'desc')->first();
                if($bankhistory != null){
                    $total_start_date = $bankhistory->balance;
                }
            } else{
                $id = -1;
                foreach($bankacc as $b){
                    $bankhistory = BankHistory::where('bank_account_id', '!=', $id)
                    ->whereDate('date', '<=', $request->start_date)
                    ->orderBy('date', 'desc')->first();
                    if($bankhistory != null){
                        $total_start_date = $total_start_date + $bankhistory->balance;
                        $id = $bankhistory->bankAccount->id;
                    }
                }
            }
        }

        if($request->end_date){
            $query->where('date', '<=', $request->end_date);
            if($request->bank){
                $bankhistory = BankHistory::where('bank_account_id', $request->bank)->
                whereDate('date', '<=', $request->end_date)->orderBy('date', 'desc')->first();
                if($bankhistory!=null){
                    $total_end_date = $bankhistory->balance;
                }
            } else{
                $id = -1;
                foreach($bankacc as $b){
                    $bankhistory = BankHistory::where('bank_account_id', '!=', $id)->
                    whereDate('date', '<=', $request->end_date)->orderBy('date', 'desc')->first();
                    if($bankhistory!=null){
                        $total_end_date = $total_end_date + $bankhistory->balance;
                        $id = $bankhistory->bankAccount->id;
                    }
                }
            }
        }

        if($request->bank){
            $query->whereHas('bankAccount', function($query) use($request){
                $query->where('bank_account_id', $request->bank);
            });
            $bank = BankAccount::where('id', $request->bank)->get();
            foreach($bank as $b){
                $total_in_bank = $b->balance;
            }
        }

        $perPage = 20;
        $page = $request->input('page', 1);
        $total = $query->count();

        $journal = $query->offset(($page - 1) * $perPage)->limit($perPage)->orderBy('id', 'desc')->get();

        $pemasukan = 0;
        $pengeluaran = 0;

        foreach($journal as $j){
            $j->type = $j->chartAccount->type;
            $j->bank = $j->bankAccount->name;
            if($j->type == 1){
                $pemasukan = $pemasukan + $j->balance;
            }
            else if($j->type==2){
                $pengeluaran = $pengeluaran + $j->balance;
            }
        }
        $total_balance = $pemasukan - $pengeluaran;

        $response = [
            'message' => 'Laporan berhasil ditampilkan',
            'total_balance' => $total_balance,
            'total_in_bank' => $total_in_bank,
            'data' => $journal,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'total_start_date' => $total_start_date,
            'total_end_date' => $total_end_date,
            'page' => $page,
            'last_page' => ceil($total / $perPage),
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
