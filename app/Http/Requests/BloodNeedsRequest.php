<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BloodNeedsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'featured' => 'required|integer',
            'name'=> 'required|string|max:255',
            'blood_id' => 'required|integer',
            'city_id' => 'required|integer',
            'location_id' => 'required|integer',
            'religion' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'profession' => 'required|string',
            'details' => 'required',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
//            'image' => 'nullable|image|mimes:jpg,png|max:2048',
            'address' => 'required',
            'total_donate' => 'required',
            'gender' => 'required|in:Male,Female',
            'status' => 'required|in:0,1,2',
            'birth_date' => 'required',
            'last_donate' => 'required',
            'socialMedia' => 'required',
        ];
    }
}
