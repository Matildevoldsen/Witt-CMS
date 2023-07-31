<?php

namespace App\Http\Controllers\Dashboard\Users;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class DeleteRoleController extends Controller
{
    public function __invoke(Role $role)
    {
        $role->delete();

        return redirect()->back()->with('status', 'Role deleted successfully!');
    }
}
