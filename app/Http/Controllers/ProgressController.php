<?php

namespace App\Http\Controllers;

use App\Models\Progress;

use App\Http\Controllers\Controller;



use App\Http\Resources\ProgressResource;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $progress = Progress::all();


        $data = [
            'status' => 200,
            'progress' => $progress
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'weight' => 'required',
                'waist' => 'required',
                'Abs' => 'required',
                'measurements' => 'required',
                'performance'=>'required',
                'status'=>'required',
       

            ]
        );
        if ($validator->fails()) {
            $data = [
                'status' => 422,
                "message" => $validator->messages()
            ];
            return response()->json($data, 422);
        } else {
            $progress = new Progress;
            $progress->user_id = $request->user_id;
            $progress->weight = $request->weight;
            $progress->Abs = $request->Abs;
            $progress->measurements = $request->measurements;
            $progress->performance = $request->performance;
            $progress->status = $request->status;
            $progress->save();

            $data = [
                'status' => 200,
                "message" => 'Data uploaded'
            ];
            return response()->json($data, 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Progress $progress)
    {
        return ProgressResource::make($progress);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
              
                'weight' => 'required',
                'waist' => 'required',
                'Abs' => 'required',
        
                'status'=>'required',

            ]
        );
        if ($validator->fails()) {
            $data = [
                'status' => 422,
                "message" => $validator->messages()
            ];
            return response()->json($data, 422);
        } else {

            $progress = Progress::find($id);

            $progress = new Progress;
          
            $progress->weight = $request->weight;
            $progress->Abs = $request->Abs;
            $progress->measurements = $request->measurements;
            $progress->performance = $request->performance;
            $progress->status = $request->status;
            $progress->save();

            $data = [
                'status' => 200,
                "message" => 'Data updated successfully'
            ];
            return response()->json($data, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $progres=Progress::find($id);
        $progres->delete();
        $data=
        [
            'status'=>200,
            'message'=>"data deleted successfully"
        ];
        return response()->json($data,200);
    }
}
