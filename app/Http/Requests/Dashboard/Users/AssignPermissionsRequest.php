<?php

namespace App\Http\Requests\Dashboard\Users;

use App\Rules\ValidPermissionIDs;
use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'permissions' => ['required', 'array', new ValidPermissionIDs],
            'permissions.*' => 'boolean',
        ];
    }
}
