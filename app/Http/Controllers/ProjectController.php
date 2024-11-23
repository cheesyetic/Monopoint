<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Project;
use App\Models\Remuneration;
use App\Models\User;
use App\Models\UserRemuneration;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::orderBy('id', 'desc')->get();

        foreach ($project as $key => $value) {
            $project[$key]->token = Crypt::encryptString($project[$key]->id);
        }

        $response = [
            'message' => 'List Project',
            'data' => $project
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
            'status' => ['required', 'max:45']
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $project = Project::create($request->all());
            $response = [
                'message' => 'A new project row created',
                'data' => $project
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
    public function show($token)
    {
        $id = Crypt::decryptString($token);
        $project = Project::findOrFail($id);

        $response = [
            'message' => 'A project row shown',
            'data' => $project
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
        $project = Project::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:45'],
            'status' => ['required', 'max:45']
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $project->update($request->all());
            $response = [
                'message' => 'A project row updated',
                'data' => $project
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
        $project = Project::findOrFail($id);

        try {
            $project->delete();
            $response = [
                'message' => 'A project row deleted',
                'data' => $project
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    public function pembagian($token)
    {
        $id = Crypt::decryptString($token);
        $nilai_asli = 0;
        $hpp = 0;
        $arrayusers = [];
        $arraynames = [];
        $percents = [];

        try {
            $journals_pemasukan = Journal::where('status', 3)->where('project_id', $id)->whereRelation('chartAccount', 'type', 1)->get();
            foreach ($journals_pemasukan as $journal) {
                $nilai_asli += $journal->balance;
            }
            $ppn = $nilai_asli * 0.11;
            $pph = $nilai_asli * 0.02;
            $nilai_bersih = $nilai_asli - $ppn - $pph;
            $journals_keluar = Journal::where('status', 3)->where('project_id', $id)->whereRelation('chartAccount', 'type', 2)->get();
            foreach ($journals_keluar as $journal) {
                $hpp += $journal->balance;
            }

            if (Remuneration::where('project_id', $id)->exists()) {
                $remuneration = Remuneration::where('project_id', $id)->first();
                $kas = $remuneration->kas;
                $pemilik = $remuneration->pemilik;
                $user_remuneration = $remuneration->userRemuneration;
                $i = 0;

                foreach ($user_remuneration as $value) {
                    $arrayusers[$i] = $value->user_id;
                    $arraynames[$i] = User::where('id', $value->user_id)->first()->name;
                    $percents[$i] = $value->percent;
                    $i += 1;
                }
            } else {
                $kas = null;
                $pemilik = null;
                $arrayusers = null;
                $arraynames = null;
                $percents = null;
            }
            $response = [
                'message' => 'Pembagian ditampilkan',
                'nilai_asli' => $nilai_asli,
                'ppn' => $ppn,
                'pph' => $pph,
                'nilai_bersih' => $nilai_bersih,
                'hpp' => $hpp,
                'journals_pemasukan' => $journals_pemasukan,
                'journals_keluar' => $journals_keluar,
                'kas' => $kas,
                'pemilik' => $pemilik,
                'arrayusers' => $arrayusers,
                'arraynames' => $arraynames,
                'percents' => $percents
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    public function store_remuneration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => ['required'],
            'kas' => ['required'],
            'pemilik' => ['required'],
            'user_id' => ['required'],
            'percent' => ['required'],
        ]);
        $project_id = Crypt::decryptString($request->project_id);
        $input = $request->all();
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        };

        if (Remuneration::where('project_id', $project_id)->exists()) {
            // dd($request->user_id);
            $remuneration = Remuneration::where('project_id', $project_id)->first();
            UserRemuneration::where('remuneration_id', $remuneration->id)->delete();
            $input['project_id'] = $project_id;
            $remuneration->update($input);
            $input['remuneration_id'] = $remuneration->id;
            foreach ($request->user_id as $key => $value) {
                $input['user_id'] = $value;
                $input['percent'] = $request->percent[$key];
                UserRemuneration::create($input);
            }
            $response = [
                'message' => 'Remunerasi Diperbarui',
                'data' => $remuneration
            ];

            return response()->json($response, Response::HTTP_OK);
        } else {
            $input['project_id'] = $project_id;
            $remuneration = Remuneration::create($input);
            $input['remuneration_id'] = $remuneration->id;
            foreach ($request->user_id as $key => $value) {
                $input['user_id'] = $value;
                $input['percent'] = $request->percent[$key];
                UserRemuneration::create($input);
            }
            $response = [
                'message' => 'Remunerasi Disimpan',
                'data' => $remuneration
            ];

            return response()->json($response, Response::HTTP_OK);
        }
    }

    public function update_remuneration(Request $request)
    {
        //     $validator = Validator::make($request->all(), [
        //         'project_id' => ['required'],
        //         'kas' => ['required'],
        //         'pemilik' => ['required'],
        //         'user_id' => ['required'],
        //         'percent' => ['required'],
        //     ]);

        //     $input = $request->all();
        //     if($validator->fails()){
        //         return response()->json($validator->errors(),
        //         Response::HTTP_UNPROCESSABLE_ENTITY);
        //     };

        //     try {
        //         $remuneration = Remuneration::where('project_id', $request->project_id)->first();


        //     } catch (QueryException $e) {
        //         return response()->json([
        //             'message' => "Failed " . $e->errorInfo
        //         ]);
        //     }
    }
}
