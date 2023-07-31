<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Users\CreateRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CreateRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRoleRequest $request)
    {
        Role::create(['name' => $request->input('name')]);

        return redirect()->back()->with('status', 'Role created successfully!');
    }
}
