<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vide = Video::all();
        return response()->json($vide, 200);
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
            'name'=> 'required|string|max:255',
            'url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], 400);
        }

        $videos = Video::create([
            'name'=> $request->name,
            'url' => $request->url,
        ]);

        return response()->json($videos, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $videos = Video::find($id);

        if (!$videos) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        return response()->json($videos, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id)
    {
        $video = Video::find($id);

        if (!$video) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $video->update($request->all());

        return response()->json($video, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $videos = Video::find($id);

        if (!$videos) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $videos->delete();
        return response()->json(['message' => 'Muvaffaqiyatli o\'chirildi'], 200);
    }
}
