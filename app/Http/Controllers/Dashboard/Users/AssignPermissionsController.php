<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Resources\Dashboard\Users\RoleResource;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Users\AssignPermissionsRequest;
use Spatie\Permission\Models\Permission;

class AssignPermissionsController extends Controller
{
    public function __invoke(AssignPermissionsRequest $request, Role $role)
    {
        $permissionsData = $request->input('permissions');
        $permissionsToAssign = array_keys(array_filter($permissionsData));

        $role->syncPermissions($permissionsToAssign);

        return to_route('roles.show');
    }
}
