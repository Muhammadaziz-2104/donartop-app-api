<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Http\Resources\UsersResource;
use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
//use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = AdminResource::collection(Admin::all());
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
            $default = $request->image = 'admins/avatar.jpg';
        }else {
            $file = $request->file('image')->getClientOriginalName();
            $name = $request->file('image')->storeAs('admins', $file);
        }
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'email' => 'required|email',
            'username' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg|max:10240',
            'password' => 'required',
        ]);

        $admins = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'image' => $name ?? $default,

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return response()->json($admins, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admins = Admin::find($id);

        if (!$admins) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        return response()->json($admins, 200);
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
        $admins = Admin::find($id);
        $validatedData = $request->validate([
            'name'=> 'required|string|max:255',
            'email' => 'required|email',
            'username' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg|max:10240',
            'password' => 'required',
        ]);

        if ($request->hasFile('image')) {
            // Get the new image file
            $file = $request->file('image')->getClientOriginalName();

            // Determine the image name to be used
            $imageName = $request->input('image') ?? 'admins/avatar.jpg';

            // Check if the current image name is 'avatar.jpg'
            if ($admins->image == 'admins/avatar.jpg') {
                // Do not delete 'avatar.jpg', just update the product's image
                $path = $request->file('image')->storeAs('admins',  $file );
            } else {
                if ($admins->image) {
                    Storage::delete($admins->image);
                }
                // Delete the old image and update the product's image

                $path = $request->file('image')->storeAs('admins', $file);
            }
        }

        $admins->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'image' => $path ?? $admins->image,
        ]);

        if (!$admins) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }
        return response()->json($admins, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admins = Admin::find($id);

        if (!$admins) {
            return response()->json(['message' => 'Bunday maʼlumot yo\'q'], 404);
        }

        $admins->delete();
        return response()->json(['message' => 'Muvaffaqiyatli o\'chirildi'], 200);
    }
}
