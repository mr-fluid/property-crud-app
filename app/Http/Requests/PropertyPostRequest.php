<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyPostRequest extends FormRequest
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
            "county" =>  'required|string',
            "country" =>  'required|string',
            "town" =>  'required|string',
            "description" =>  'required|string',
            "address" =>  'required|string',
            "image" => 'required|image',
            "postcode" =>  'required|numeric',
            "num_bedrooms" =>  'required',
            "num_bathrooms" =>  'required',
            "price" =>  'required|numeric',
            "type" =>  'required',
            "property_type" =>  'required',
        ];
    }
}
