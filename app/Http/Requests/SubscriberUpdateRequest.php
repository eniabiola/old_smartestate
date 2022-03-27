<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberUpdateRequest extends FormRequest
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

            'businessname' => 'required',
            'accountname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'state' => 'required|integer',
            'city' => 'required|integer',
            'address' => 'required',
            'bank' => 'required|integer',
            'accountno' => 'required',
            'contactperson' => 'required',
            'contactphone' => 'required',
            'contactemail' => 'required|email:rfc,dns',
            'user' => 'required',
            'tenant' => 'required',
        ];
    }
}
