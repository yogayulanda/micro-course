<?php

namespace App\Http\Controllers;

use App\Mentor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function index(){
        $mentors = Mentor::all();
        return response()->json([
            'status' => 'success',
            'data' => $mentors
        ]);
    }

    public function show($id){
        $mentor = Mentor::find($id);
        if (!$mentor){
            return response()->json([
                'status' => 'Error',
                'message' => "Mentor Not Found"
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ]);
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'profile' => 'required',
            'profession' => 'required|string',
            'email' => 'required|email'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
            $mentor = Mentor::create($data);

            return response()->json(['status' => 'success', 'data' => $mentor]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
            $mentor = Mentor::find($id);

            if (!$mentor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'mentor not found'
                ], 400);
            }

            $mentor->fill($data);

            $mentor->save();

            return response()->json([
                'status' => 'success',
                'data' => $mentor
            ]);
    }

    public function destroy($id){
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 400);
        }

        $mentor->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'mentor deleted'
        ]);
    }
}
