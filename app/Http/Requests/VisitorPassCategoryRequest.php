<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorPassCategoryRequest extends FormRequest
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
            'name' => 'required|unique:visitor_pass_categories,name',
            'description' => 'required',
            'prefix' => 'required',
            'numberAllowed' => 'required|integer',
            'isActive' => 'required|boolean'
        ];
    }
}
