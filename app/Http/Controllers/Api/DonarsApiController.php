<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

//use App\Http\Resources\DonarResource;
use App\Http\Resources\DonarsResource;
use App\Models\Donar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DonarsApiController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donars = DonarsResource::collection(Donar::all());
        return response()->json($donars, 200);
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
            $default = $request->image = 'donars/avatar.jpg';
        } else {
            $file = $request->file('image')->getClientOriginalName();
            $name = $request->file('image')->storeAs('donars', $file);
        }
        $validatedData = Validator::make($request->all(), [
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
        if ($validatedData->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ], 400);
        }

        $donars = Donar::create(
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

        return response()->json($donars, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $donar = Donar::find($id);

        if (!$donar) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        return response()->json(new DonarsResource($donar), 200);
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
        $donars = Donar::find($id);

        if (!$donars) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }
//        dd($request);

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

            if ($donars->image == 'donars/avatar.jpg') {
                $path = $request->file('image')->storeAs('donars', $file);
            } else {
                if ($donars->image) {
                    Storage::delete($donars->image);
                }
                $path = $request->file('image')->storeAs('donars', $file);
            }
        }
        $donars->update(
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
                'image' => $path ?? $donars->image,
                'address' => $request->address,
                'total_donate' => $request->total_donate,
                'gender' => $request->gender,
                'status' => $request->status,
                'birth_date' => $request->birth_date,
                'last_donate' => $request->last_donate,
                'socialMedia' => $request->socialMedia,
            ]
        );

        return response()->json($donars, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $donars = Donar::find($id);


        if (!$donars) {
            return response()->json(
                ['message' => 'Bunday maʼlumot yo\'q'],
                404
            );
        }

        $donars->delete();
        return response()->json(
            ['message' => 'Muvaffaqiyatli o\'chirildi'],
            200
        );
    }
}
