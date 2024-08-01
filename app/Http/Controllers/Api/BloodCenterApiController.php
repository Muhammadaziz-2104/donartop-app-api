<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Blood_CentersResource;
use App\Models\BloodCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BloodCenterApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blood_centers = BloodCenter::all();
        return response()->json($blood_centers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return string
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'director' => 'required|string',
            'work_time' => 'required|string',
            'phone' => 'required|string',
            'phone2' => 'required|string',
            'email' => 'required|string',
            'location' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $blood_center = BloodCenter::create($request->all());
        return response()->json($blood_center, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blood_centers = BloodCenter::find($id);

        if (!$blood_centers) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        return response()->json($blood_centers, 200);
//        return new Blood_CentersResource($bloodCenter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $blood_centers = BloodCenter::find($id);

        if (!$blood_centers) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $validatedData = Validator::make($request->all(),([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'director' => 'required|string',
            'work_time' => 'required|string',
            'phone' => 'required|string',
            'phone2' => 'required|string',
            'email' => 'required|string',
            'location' => 'required|string',
        ]));

        if ($validatedData->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ], 400);
        }

        $blood_centers->update($request->all());

        return response()->json($blood_centers, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blood_center = BloodCenter::find($id);

        if (!$blood_center) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $blood_center->delete();
        return response()->json(['message' => 'Muvaffaqiyatli o\'chirildi'], 200);
    }
}
