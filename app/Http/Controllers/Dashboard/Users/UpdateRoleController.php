<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Users\UpdateRoleRequest;
use Spatie\Permission\Models\Role;

class UpdateRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRoleRequest $request, Role $role)
    {
        $role->name = $request->input('name');
        $role->save();

        return redirect()->back()->with('status', 'Role updated successfully!');
    }
}
