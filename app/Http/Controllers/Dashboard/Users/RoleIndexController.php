<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Users\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return inertia('Dashboard/Users/Roles/Index', [
            'roles' => RoleResource::collection($roles),
            'permissions' => $permissions,
        ]);
    }
}
