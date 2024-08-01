<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationsResource;
use App\Models\City;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Runner\validate;

class LocationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $location = LocationsResource::collection(Location::all());
        return response()->json($location, 200);
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
            'city_id' => 'required|integer',
            'status' => 'required|in:1,0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed",
                'errors' => $validator->errors()
            ], 400);
        }

        $locations = Location::create($request->all());
        return response()->json($locations, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        return response()->json(new LocationsResource($location), 200);
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
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $validatedData = Validator::make($request->all(),([
            'name' => 'required|string|max:255',
            'city_id' => 'required|integer',
            'status' => 'required|in:1,0'
        ]));

        if ($validatedData->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ], 400);
        }

        $location->update($request->all());

        return response()->json($location, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $location->delete();
        return response()->json(['message' => 'Muvaffaqiyatli o\'chirildi'], 200);
    }
}
