<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BloodNeedsResource;
use App\Models\BloodNeeds;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BloodNeedsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blood_needs = BloodNeedsResource::collection(BloodNeeds::all());
        return response()->json($blood_needs, 200);
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
        if ($request->image === null) {
            $default = $request->image = 'blood-needs/avatar.jpg';
        } else {
            $file = $request->file('image')->getClientOriginalName();
            $name = $request->file('image')->storeAs('blood-needs', $file);
        }
        $validator = Validator::make($request->all(),
            [
                'featured' => 'required|integer',
                'name' => 'required|string|max:255',
                'blood_id' => 'required|integer',
                'city_id' => 'required|integer',
                'location_id' => 'required|integer',
                'religion' => 'required|max:255',
                'email' => 'required|email',
                'phone' => 'required',
                'profession' => 'required|string',
                'details' => 'required',
                'image' => 'nullable|image|mimes:png,jpg|max:10240',
                'address' => 'required',
                'total_donate' => 'required',
                'gender' => 'required|in:Male,Female',
                'status' => 'required|in:0,1,2',
                'birth_date' => 'required',
                'last_donate' => 'required',
                'socialMedia' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], 400);
        }

        $blood_needs = BloodNeeds::create(
            [
                'featured' => $request->featured,
                'name' => $request->name,
                'blood_id' => $request->blood_id,
                'city_id' => $request->city_id,
                'location_id' => $request->location_id,
                'user_id' => auth()->user()->id,
                'religion' => $request->religion,
                'email' => $request->email,
                'phone' => $request->phone,
                'profession' => $request->profession,
                'details' => $request->details,
                'image' => $name ?? $default,
                'address' => $request->address,
                'total_donate' => $request->total_donate,
                'gender' => $request->gender,
                'status' => $request->status,
                'birth_date' => $request->birth_date,
                'last_donate' => $request->last_donate,
                'socialMedia' => $request->socialMedia,
            ]
        );

        return response()->json($blood_needs, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blood_need = BloodNeeds::find($id);

        if (!$blood_need) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        return response()->json(new BloodNeedsResource($blood_need), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $blood_needs = BloodNeeds::find($id);

        if (!$blood_needs) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        $validatedData = Validator::make($request->all(),(
            [
                'featured' => 'required|integer',
                'name' => 'required|string|max:255',
                'blood_id' => 'required|integer',
                'city_id' => 'required|integer',
                'location_id' => 'required|integer',
                'religion' => 'required|max:255',
                'email' => 'required|email',
                'phone' => 'required',
                'profession' => 'required|string',
                'details' => 'required',
                'image' => 'nullable|image|mimes:jpg,png|max:2048',
                'address' => 'required',
                'total_donate' => 'required',
                'gender' => 'required|in:Male,Female',
                'status' => 'required|in:0,1,2',
                'birth_date' => 'required',
                'last_donate' => 'required',
                'socialMedia' => 'required',

            ]
        ));

        if ($validatedData->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ], 400);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image')->getClientOriginalName();

            $imageName = $request->input('image') ?? 'blood-needs/avatar.jpg';

            if ($blood_needs->image == 'blood-needs/avatar.jpg') {
                $path = $request->file('image')->storeAs('blood-needs', $file);
            } else {
                if ($blood_needs->image) {
                    Storage::delete($blood_needs->image);
                }
                $path = $request->file('image')->storeAs('blood-needs', $file);
            }
        }
        $blood_needs->update(
            [
                'featured' => $request->featured,
                'name' => $request->name,
                'blood_id' => $request->blood_id,
                'city_id' => $request->city_id,
                'location_id' => $request->location_id,
                'religion' => $request->religion,
                'email' => $request->email,
                'phone' => $request->phone,
                'profession' => $request->profession,
                'details' => $request->details,
                'image' => $path ?? $blood_needs->image,
                'address' => $request->address,
                'total_donate' => $request->total_donate,
                'gender' => $request->gender,
                'status' => $request->status,
                'birth_date' => $request->birth_date,
                'last_donate' => $request->last_donate,
                'socialMedia' => $request->socialMedia,
            ]
        );


        return response()->json($blood_needs, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blood_need = BloodNeeds::find($id);

        if (!$blood_need) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        $blood_need->delete();
        return response()->json(
            ['message' => 'Muvaffaqiyatli o\'chirildi'],
            200
        );
    }
}
