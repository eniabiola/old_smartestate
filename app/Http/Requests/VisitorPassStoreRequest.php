<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorPassStoreRequest extends FormRequest
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
            'visitationdate' => 'required|date_format:Y-m-d H:i:s',
            'recurrentpass' => 'required',
            'dateexpires' => 'required|date_format:Y-m-d H:i:s',
            'guestname' => 'required',
            'gender' => 'nullable|sometimes',
            'specialfeature' => 'nullable|sometimes',
            'tenant' => 'required|integer',
            'user' => 'required|integer',
            'user_role' => 'required',
            'visitor_pass_category_id' => 'required|exists:visitor_pass_categories,id',
        ];
    }
}
