<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = UsersResource::collection(User::all());
        return response()->json($users, 200);
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
            $default = $request->image = 'user/avatar.jpg';
        }else {
            $file = $request->file('image')->getClientOriginalName();
            $name = $request->file('image')->storeAs('users', $file);
        }
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'blood_id' => 'required|integer',
            'city_id' => 'required|integer',
            'location_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required',
            'birth_date' => 'required',
            'profession' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg|max:10240',
            'password' => 'required',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], 400);
        }

        $users = User::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
            'location_id' => $request->location_id,
            'blood_id' => $request->blood_id,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'profession' => $request->profession,
            'phone' => $request->phone,
            'status' => $request->status,
            'password' => $request->password,
            'image' => $name ?? $default,
        ]);

        return response()->json($users, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $users = User::find($id);

        if (!$users) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        return response()->json( new UsersResource($users), 200);
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
        $users = User::find($id);

        if (!$users) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $validatedData = $request->validate([
            'name'=> 'required|string|max:255',
            'blood_id' => 'required|integer',
            'city_id' => 'required|integer',
            'location_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required',
            'birth_date' => 'required',
            'profession' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg|max:10240',
            'password' => 'required',
            'status' => 'required|in:0,1',
        ]);

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
            $imageName = $request->input('image') ?? 'users/avatar.jpg';

            // Check if the current image name is 'avatar.jpg'
            if ($users->image == 'users/avatar.jpg') {
                // Do not delete 'avatar.jpg', just update the product's image
                $path = $request->file('image')->storeAs('users',  $file );
            } else {
                if ($users->image) {
                    Storage::delete($users->image);
                }
                // Delete the old image and update the product's image

                $path = $request->file('image')->storeAs('users', $file);
            }
        }

        $users->update([
            'name' => $request->name,
            'city_id' => $request->city_id,
            'location_id' => $request->location_id,
            'blood_id' => $request->blood_id,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'profession' => $request->profession,
            'phone' => $request->phone,
            'status' => $request->status,
            'password' => $request->password,
            'image' => $path ?? $users->image,
        ]);


        return response()->json($users, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $users = User::find($id);

        if (!$users) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $users->delete();
        return response()->json(['message' => 'Muvaffaqiyatli o\'chirildi'], 200);
    }
}
