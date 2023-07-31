<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1',
            'email' => 'required|email',
            'phone' => 'min:2',
            'address' => 'min:5',
            'description' => 'required|string',
            'logo_path' => [
                ...$this->isPrecognitive() ? [] : ['required'],
                'mimes:jpeg,png,svg,webp'
            ]
        ];
    }
}
