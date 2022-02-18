<?php

namespace LaraBooking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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
            'name' => 'required|max:128',
            'email' => 'required|email|max:128',
            'password' => 'nullable|string|min:6|confirmed',
            'phones.*.phone'  => 'required|max:128',
        ];
    }
}