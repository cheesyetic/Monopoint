<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asset = Asset::orderBy('id', 'desc')->get();
        foreach ($asset as $key => $value) {
            $asset[$key]->token = Crypt::encryptString($asset[$key]->id);
        }
        $response = [
            'message' => 'List Asset',
            'data' => $asset
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
            'quantity' => ['required'],
            'price' => ['required'],
            'buy_time' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $value1 = $request['quantity'];
            $value2 = $request['price'];
            $request['total'] =  $value1 * $value2 ;
            $asset = Asset::create($request->all());
            $response = [
                'message' => 'A new asset row created',
                'data' => $asset
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
        $asset = Asset::findOrFail($id);

        $response = [
            'message' => 'An asset row shown',
            'data' => $asset
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
        $asset = Asset::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:45'],
            'quantity' => ['required'],
            'price' => ['required'],
            'buy_time' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $value1 = $request['quantity'];
            $value2 = $request['price'];
            $request['total'] =  $value1 * $value2 ;
            $asset->update($request->all());
            $response = [
                'message' => 'An asset row updated',
                'data' => $asset
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
        $asset = Asset::findOrFail($id);

        try {
            $asset->delete();
            $response = [
                'message' => 'An asset row deleted',
                'data' => $asset
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
