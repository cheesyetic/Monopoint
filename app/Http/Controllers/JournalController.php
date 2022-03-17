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
use Illuminate\Support\Str;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Journal::with(['user', 'chartAccount', 'accountingPeriod', 'project', 'asset', 'bankAccount']);

        if($user->type == 2){
            $query->where('user_id', '=', $user->id);
        }

        if($request->sortname){
            $query->orderBy('title', $request->sortname);
        }

        if($request->sortdate){
            $query->orderBy('date', $request->sortdate);
        }

        if($request->keyword){
            $query->where('title','ILIKE','%'.$request->keyword.'%');
        }

        if($request->project){
            $query->where('project_id','=',$request->project);
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

        $perPage = 20;
        $page = $request->input('page', 1);
        $total = $query->count();

        $journal = $query->offset(($page - 1) * $perPage)->limit($perPage)->orderBy('id', 'desc')->get();

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
            'data' => $journal,
            'total' => $total,
            'page' => $page,
            'last_page' => ceil($total / $perPage),
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
                $imageName = Str::random(2) . time().'.'.$request->filebukti->extension();
                $path = $file->storeAs('uploads', $imageName, 'public');
                $input['filebukti'] = '/storage/'.$path;
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

        if( $journal->project != null){
            $journal->project_name = $journal->project->name;
        }
        else $journal->project_name = "Data terhapus";
        if( $journal->user != null){
            $journal->user_name = $journal->user->name;
        }
        else $journal->user_name = "Data terhapus";
        if( $journal->chartaccount != null){
            $journal->chart_account_name = $journal->chartaccount->name;
        }
        else $journal->chart_account_name = "Data terhapus";
        if( $journal->accountingperiod != null){
            $journal->accounting_period_name = $journal->accountingperiod->name;
        }
        else $journal->accounting_period_name = "Data terhapus";
        if( $journal->bank_account != null){
            $journal->bank_account_name = $journal->bankaccount->name;
        }
        else $journal->bank_account_name = "Data terhapus";

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
                $imageName = time().'.'.$request->filebukti->extension();
                $path = $file->storeAs('uploads', $imageName, 'public');
                $input['filebukti'] = '/storage/'.$path;
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

        $journal->title = 'Pengajuan Jurnal';
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
        if($journal->is_reimburse == 1){
            $validator = Validator::make($request->all(), [
                'buktireimburse' => ['required', 'mimes:png,jpg,jpeg,doc,docx,pdf,txt,csv', 'max:2048'],
            ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

            $input = $request->all();
            if($file = $request->file('buktireimburse')){
                $imageName = time().'.'.$request->filebukti->extension();
                $path = $file->storeAs('uploads', $imageName, 'public');
                $input['filebukti'] = '/storage/'.$path;
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
        $idchartacc = $journal['chart_account_id'];
        $ca = ChartAccount::findOrFail($idchartacc);
        $ca->balance = $ca->balance + $journal['balance'];
        $ca->save();

        $this->sendEmailVerifikasi($id);

        $response = [
            'message' => 'A journal has been verified',
            'data' => $journal
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function declineStatus(Request $request, $token){
        $id = Crypt::decryptString($token);
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
        $response = [
            'message' => 'Import Successful',
        ];
        return response()->json($response, Response::HTTP_OK);
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
