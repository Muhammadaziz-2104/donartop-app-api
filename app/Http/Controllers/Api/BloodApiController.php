<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use App\Http\Resources\BloodsResource;
use App\Models\Blood;
use Illuminate\Http\JsonResponse;
//use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BloodApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloods = Blood::all();
        return response()->json($bloods, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|in:1,0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], 400);
        }

        $bloods = Blood::create($request->all());
        return response()->json([
            "status" => "success",
            "message" => "Resource created successfully",
            "data" => $bloods
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        $blood = Blood::find($id);

        if (!$blood) {
            return response()->json([
                "status" => "error",
                "message" => "Resource not found"
            ], 404);
        }

        return response()->json(["status" => "success", "data" => $blood], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $blood = Blood::find($id);

        if (!$blood) {
            return response()->json([
                "status" => "error",
                "message" => "Resource not found"
            ], 404);
        }

        $validatedData = Validator::make($request->all(),([
            'name' => 'required|string|max:255',
            'status' => 'required|in:1,0'

        ]));
        if ($validatedData->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ], 400);
        }

        $blood->update($request->all());

        return response()->json(["status" => "success", "data" => $blood],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bloods = Blood::find($id);
        if (!$bloods) {
            return response()->json([
                "status" => "error",
                "message" => "Resource not found"
            ], 404);
        }

        $bloods->delete();
        return response()->json( ['message' => 'Muvaffaqiyatli o\'chirildi'],200);
    }
}
