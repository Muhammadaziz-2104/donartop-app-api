<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blood;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitiesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citys = City::all();
        return response()->json($citys, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'status' => 'required|in:1,0'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Validation failed",
                    'errors' => $validator->errors()
                ],
                400
            );
        }

        $citys = City::create($request->all());
        return response()->json($citys, 201);
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
        $citys = City::find($id);

        if (!$citys) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        return response()->json($citys, 200);
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
        $citys = City::find($id);

        if (!$citys) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        $validatedData = Validator::make($request->all(),([
                'name' => 'required|string|max:255',
                'status' => 'required|in:1,0'

            ]
        ));
        if ($validatedData->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validatedData->errors()], 400);
        }

        $citys->update($request->all());

        return response()->json($citys, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $citys = City::find($id);

        if (!$citys) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        $citys->delete();
        return response()->json(['message' => 'Muvaffaqiyatli o\'chirildi'], 200);
    }
}
