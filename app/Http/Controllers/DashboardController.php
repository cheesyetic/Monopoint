<?php

namespace App\Http\Controllers;

use App\Models\AccountingPeriod;
use App\Models\BankAccount;
use App\Models\Journal;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function balanceChart(){
        $accperiod = AccountingPeriod::orderBy('id', 'desc')->take(12)->get();
        $i = 11;
        foreach($accperiod as $acc){
            $idacc = $acc->id;
            $pemasukan[$i] = Journal::where('accounting_period_id', $idacc)->
            whereRelation('chartAccount', 'type', '1')->sum('balance');
            $pengeluaran[$i] = Journal::where('accounting_period_id', $idacc)->
            whereRelation('chartAccount', 'type', '2')->sum('balance');
            $title[$i] = $acc->name;
            $i = $i-1;
        }
        $response = [
            'title' => $title,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'message' => 'API Chart Berhasil Ditampilkan'
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function journalChart(){
        $accperiod = AccountingPeriod::orderBy('id', 'desc')->take(12)->get();
        $i = 11;
        foreach($accperiod as $acc){
            $idacc = $acc->id;
            $title[$i] = $acc->name;
            $jumlah[$i] = Journal::where('accounting_period_id', $idacc)->count();
            $i = $i-1;
        }
        $response = [
            'title' => $title,
            'total' => $jumlah,
            'message' => 'API Journal Chart Berhasil Ditampilkan'
        ];
        return response()->json($response, Response::HTTP_OK);

    }

    public function dashboard(){
        $journalcount = Journal::get()->count();
        $bank = BankAccount::get();
        $total = 0;

        foreach($bank as $bk){
            $total = $total + $bk->balance;
        }

        $response = [
            'jumlahjurnal' => $journalcount,
            'bank' => $bank,
            'totaluang' => $total,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
