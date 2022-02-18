<?php

namespace LaraBooking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProvider extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'image' => 'image|file',
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }
}