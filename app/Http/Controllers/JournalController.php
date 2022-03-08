<?php

namespace App\Http\Controllers;

use App\Exports\JournalsExport;
use App\Imports\JournalsImport;
use App\Mail\JournalChange;
use App\Mail\JournalChangeFinance;
use App\Mail\JournalDeclined;
use App\Mail\JournalUpdate;
use App\Mail\JournalVerified;
use App\Models\AccountingPeriod;
use App\Models\AdjustingHistory;
use App\Models\BankAccount;
use App\Models\ChartAccount;
use App\Models\Journal;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->token){
            $id = Crypt::decryptString($request->token);
        }

        $query = Journal::with(['user', 'chartAccount', 'accountingPeriod', 'project', 'asset', 'bankAccount']);

        if($request->token){
            $user = User::where('id', '=', $id)->get();
            if($user->type = 3){
                $query->where('user_id', '=', $id);
            }
        }

        if($request->keyword){
            $query->where('title','ILIKE','%'.$request->keyword.'%');
        }

        if($request->category > 2){
            $query->where('status','>=', $request->category);
        }

        if($request->category <= 2 && $request->category > 0){
            $query->where('status','=', $request->category);
        }

        if($request->chart){
            $query->whereHas('chartAccount', function($query) use($request){
                $query->where('chart_account_id', $request->chart);
            });
        }

        if($request->reimburse != null){
            $query->where('is_reimburse','=', $request->reimburse);
        }

        if($request->date){
            $query->whereMonth('date','=', date($request->date));
        }

        $journal = $query->get();

        foreach($journal as $value){
            $value->project_id = Project::findOrFail($value->project_id)->name;
            $value->user_id = User::findOrFail($value->user_id)->name;
            $value->chart_account_id = ChartAccount::findOrFail($value->chart_account_id)->name;
        }

        foreach ($journal as $key => $value) {
            $journal[$key]->token = Crypt::encryptString($journal[$key]->id);
        }

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
        // return response()->json($request, Response::HTTP_CREATED);

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:45'],
            'date' => ['required'],
            'remark' => ['max:1000'],
            'ref' => ['max:45'],
            'filebukti' => ['required', 'mimes:png,jpg,jpeg,doc,docx,pdf,txt,csv', 'max:2048'],
            'balance' => ['required'],
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
            if($file = $request->file('filebukti')){
                $path = $file->store('public/files');
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                $input['filebukti'] = "$name";
            }

            $journal = Journal::create($input);
            $user = $journal->user->name;
            $input['journal_id'] = $journal->id;
            $input['title'] = 'Pembuatan Jurnal';
            $input['remark'] = $user . ' melakukan pembuatan jurnal pada ' . $journal->created_at;
            adjustingHistory::create($input);

            // balance in ca
            // $idchartacc = $input['chart_account_id'];
            // $ca = ChartAccount::findOrFail($idchartacc);
            // $ca->balance = $ca->balance + $input['balance'];
            // $ca->save();

            $response = [
                'message' => 'A new journal row created',
                'data' => $journal
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
        $id = Crypt::decryptString($token);
        $journal = Journal::findOrFail($id);
        // dd($journal);

        $journal->project_name = $journal->project->name;
        $journal->user_name = $journal->user->name;
        $journal->chart_account_name = $journal->chartaccount->name;
        $journal->accounting_period_name = $journal->accountingperiod->name;
        $journal->bank_account_name = $journal->bankaccount->name;

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

    public function update(Request $request, $token)
    {
        $id = Crypt::decryptString($token);
        $journal = Journal::findOrFail($id);
        $user = $journal->user->name;

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:45'],
            'date' => ['required'],
            'remark' => ['max:1000'],
            'ref' => ['max:45'],
            'is_reimburse' => ['required'],
            'filebukti' => ['mimes:png,jpg,jpeg,doc,docx,pdf,txt,csv', 'max:2048'],
            'balance' => ['required'],
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

        $input = $request->all();

        try {
            if($file = $request->file('filebukti')){
                $path = $file->store('public/files');
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                $input['filebukti'] = "$name";
            }
        else{
            $input['filebukti'] = "$journal->filebukti";
        }

        // if($input['balance'] > $journal->balance){
        //     $res = $input['balance'] - $journal->balance;
        //     $idchartacc = $input['chart_account_id'];
        //     $ca = ChartAccount::findOrFail($idchartacc);
        //     $ca->balance = $ca->balance + $res;
        //     $ca->save();
        // }

        // elseif ($input['balance'] < $journal->balance) {
        //     $res = $journal->balance - $input['balance'] ;
        //     $idchartacc = $input['chart_account_id'];
        //     $ca = ChartAccount::findOrFail($idchartacc);
        //     $ca->balance = $ca->balance - $res;
        //     $ca->save();
        // }

        $journal->update($input);
        $this->sendEmailUpdate($id);
        $input['journal_id'] = $journal->id;
        $input['title'] = 'Perubahan Jurnal';
        $input['remark'] = $user . ' melakukan perubahan jurnal pada ' . $journal->updated_at;
        AdjustingHistory::create($input);

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
    public function destroy($token)
    {
        $id = Crypt::decryptString($token);
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

    public function draftToProcess($token)
    {
        $id = Crypt::decryptString($token);
        $journal = Journal::findOrFail($id);
        $user = $journal->user->name;

        $journal->status = 2;
        $journal->save();
        $this->sendEmailKeuanganPengajuan($id);
        $this->sendEmailPengajuan($id);

        $journal->title = 'Verifikasi Jurnal';
        $journal->remark = $user . ' melakukan pengajuan jurnal pada tanggal ' . $journal->updated_at;
        $journal = $journal->toArray();
        $journal['journal_id'] = $journal['id'];
        AdjustingHistory::create($journal);

        $response = [
            'message' => 'A journal has been moved into process phase',
            'data' => $journal
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function validationStatus(Request $request, $token){
        $id = Crypt::decryptString($token);
        $journal = Journal::findOrFail($id);
        $user = auth()->user()->name;

        $journal->status = 3;
        if($journal->is_reimburse = 1){
            $input = $request->all();
            if($file = $request->file('buktireimburse')){
                $path = $file->store('public/files');
                $name = $file->getClientOriginalName();
                $file->move($path, $name);
                $input['buktireimburse'] = "$name";
            }
            $journal->buktireimburse = $input;
        }
        $journal->save();
        $journal->title = 'Verifikasi Jurnal';
        $journal->remark = $user . ' menyetujui jurnal ini pada tanggal ' . $journal->updated_at;
        $journal = $journal->toArray();
        $journal['journal_id'] = $journal['id'];
        AdjustingHistory::create($journal);

        // balance in ca
        $idchartacc = $journal->chart_account_id;
        $ca = ChartAccount::findOrFail($idchartacc);
        $ca->balance = $ca->balance + $journal->balance;
        $ca->save();

        $this->sendEmailVerifikasi($id);

        $response = [
            'message' => 'A journal has been verified',
            'data' => $journal
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function declineStatus(Request $request, $id){
        // $id = Crypt::decryptString($token);
        $journal = Journal::findOrFail($id);
        $user = auth()->user()->name;

        $journal->note_decline = $request->note_decline;
        $journal->status = 4;
        $journal->save();
        $this->sendEmailPenolakan($id);

        $journal->title = 'Verifikasi Jurnal';
        $journal->remark = $user . ' menolak jurnal ini pada tanggal ' . $journal->updated_at;
        $journal = $journal->toArray();
        $journal['journal_id'] = $journal['id'];
        AdjustingHistory::create($journal);

        $response = [
            'message' => 'A journal has been declined',
            'data' => $journal
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function export(){
        return Excel::download(new JournalsExport, 'journals.xlsx');
    }

    public function import(){
        Excel::import(new JournalsImport, request()->file('file'));
        return back();
    }

    public function sendEmailUpdate($id){
        $jurnal = Journal::findOrFail($id);
        $iduser = $jurnal->user_id;
        $user = User::findOrFail($iduser);
        $email = $user->email;

        $details=[
            'name' => $user->name,
            'project_name' => $jurnal->project->name,
            'journal_name' => $jurnal->title,
            'journal_date' => $jurnal->date,
            'url' => env('APP_URL')
        ];

        Mail::to($email)->send(new JournalUpdate($details));
    }
    public function sendEmailPengajuan($id){
        $jurnal = Journal::findOrFail($id);
        $iduser = $jurnal->user_id;
        $user = User::findOrFail($iduser);
        $email = $user->email;

        $details=[
            'name' => $user->name,
            'project_name' => $jurnal->project->name,
            'journal_name' => $jurnal->title,
            'journal_date' => $jurnal->date,
            'url' => env('APP_URL')
        ];

        Mail::to($email)->send(new JournalChange($details));
    }

    public function sendEmailKeuanganPengajuan($id){
        $jurnal = Journal::findOrFail($id);
        $user_name = $jurnal->user->name;
        $user = User::where('type', '=', 1)->get();

        foreach($user as $value){
            $email = $value->email;
            $details=[
                'name' => $value->name,
                'user_name' => $user_name,
                'project_name' => $jurnal->project->name,
                'journal_name' => $jurnal->title,
                'journal_date' => $jurnal->date,
                'url' => env('APP_URL')
            ];
            Mail::to($email)->send(new JournalChangeFinance($details));
        }
    }

    public function sendEmailVerifikasi($id){
        $jurnal = Journal::findOrFail($id);
        $iduser = $jurnal->user_id;
        $user = User::findOrFail($iduser);
        $email = $user->email;

        $details=[
            'name' => $user->name,
            'project_name' => $jurnal->project->name,
            'journal_name' => $jurnal->title,
            'journal_date' => $jurnal->date,
            'url' => env('APP_URL')
        ];

        Mail::to($email)->send(new JournalVerified($details));
    }

    public function sendEmailPenolakan($id){
        $jurnal = Journal::findOrFail($id);
        $iduser = $jurnal->user_id;
        $user = User::findOrFail($iduser);
        $email = $user->email;

        $details=[
            'name' => $user->name,
            'project_name' => $jurnal->project->name,
            'journal_name' => $jurnal->title,
            'journal_date' => $jurnal->date,
            'url' => env('APP_URL')
        ];

        Mail::to($email)->send(new JournalDeclined($details));
    }

}
