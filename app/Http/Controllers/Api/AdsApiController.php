<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdsResource;
use App\Models\Ads;
use App\Models\BloodNeeds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ads::all();
        return response()->json($ads, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('image')->getClientOriginalName();
        $name = $request->file('image')->storeAs('ads', $file);

        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'image' => 'nullable|image|mimes:png,jpg|max:10240',
            'url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $ads = Ads::create([
            'name'=> $request->name,
            'image' => $name,
            'url' => $request->url,
        ]);
        return response()->json($ads, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ads = Ads::find($id);

        if (!$ads) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        return response()->json( new AdsResource($ads), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
//        dd($request);
        $ads = Ads::find($id);

        if (!$ads) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $validatedData = Validator::make($request->all(),([
            'name' => 'required|string|max:255',
            'image' =>'nullable|image|mimes:png,jpg|max:10240',
            'status' => 'required|in:1,0'

        ]));

        if ($validatedData->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validatedData->errors()
            ], 400);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image')->getClientOriginalName();

            // Determine the image name to be used
            $imageName = $request->input('image') ?? 'ads/avatar.jpg';

            // Check if the current image name is 'avatar.jpg'
            if ($ads->image == 'ads/avatar.jpg') {
                // Do not delete 'avatar.jpg', just update the product's image
                $path = $request->file('image')->storeAs('ads',  $file );
            } else {
                if ($ads->image) {
                    Storage::delete($ads->image);
                }
                // Delete the old image and update the product's image

                $path = $request->file('image')->storeAs('ads', $file);
            }
        }

        $ads->update([
            'name' => $request->name,
            'image' => $path ?? $ads->image,
            'url' => $request->url,
        ]);

        return response()->json($ads, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ads = Ads::find($id);

        if (!$ads) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $ads->delete();
        return response()->json(['message' => 'Muvaffaqiyatli o\'chirildi'], 200);
    }
}
