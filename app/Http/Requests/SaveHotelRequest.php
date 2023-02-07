<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveHotelRequest extends FormRequest
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
            'h_name' => 'required|string',
            'city' => 'required|string',
            'image' => 'required|image',
            'country_id' => 'required|numeric',
            'description' => 'required|string',
        ];
    }
}
