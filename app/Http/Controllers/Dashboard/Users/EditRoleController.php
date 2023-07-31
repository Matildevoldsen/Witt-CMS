<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Users\PermissionResource;
use App\Http\Resources\Dashboard\Users\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EditRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Role $role)
    {
        return inertia('Dashboard/Users/Roles/Edit', [
            'role' => RoleResource::make($role),
            'permissions' => PermissionResource::collection(Permission::all()),
        ]);
    }
}
