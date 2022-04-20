<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
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
        // @TODO implement
        return [
            'isbn' => 'required|unique:books|min:13|max:13|numeric',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'published_year' => 'required|integer|digits_between::1900,2022'
        ];
    }
}
