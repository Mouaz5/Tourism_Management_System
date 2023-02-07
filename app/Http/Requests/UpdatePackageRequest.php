<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required',
            'package_image' => 'required|image',
            'no_people' => 'required|numeric',
            'description' => 'required|string',
            'country_id' => 'required|numeric'
        ];
    }
}
