<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Define your roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Define your permissions
        $permissions = [
            'dashboard.view' => 'Access to view dashboard',
            'siteSettings.view' => 'Access to view site settings',
            'siteSettings.edit' => 'Access to edit site settings',
            'siteSettings.create' => 'Access to create site settings',
            'blogPosts.view' => 'Access to view blog posts',
            'blogPosts.create' => 'Access to create blog posts',
            'blogPosts.edit' => 'Access to edit blog posts',
            'blogPosts.delete' => 'Access to delete blog posts',
            'forum.view' => 'Access to view forum',
            'forum.create' => 'Access to create forum topics',
            'forum.edit' => 'Access to edit forum topics',
            'forum.delete' => 'Access to delete forum topics',
            'users.view' => 'Access to view users in admin panel',
            'users.edit' => 'Access to edit users',
            'users.delete' => 'Access to delete users',
            'pages.view' => 'Access to view pages in admin panel',
            'pages.create' => 'Access to create pages',
            'pages.edit' => 'Access to edit pages',
            'pages.delete' => 'Access to delete pages',
            'navigation.view' => 'Access to view navigation in the admin panel',
            'navigation.edit' => 'Access to edit navigation',
            'navigation.delete' => 'Access to delete navigation',
            'navigation.create' => 'Access to create navigation',
        ];

        foreach ($permissions as $permissionName => $permissionDescription) {
            $permission = Permission::create([
                'name' => $permissionName,
                'description' => $permissionDescription,
            ]);

            // Assuming that your admin has all the permissions
            $adminRole->givePermissionTo($permission);

            // Assuming the user can view everything, create/edit/delete forum posts
            if (in_array($permissionName, [
                'dashboard.view',
                'siteSettings.view',
                'blogPosts.view',
                'forum.view',
                'forum.create',
                'forum.edit',
                'forum.delete',
            ])) {
                $userRole->givePermissionTo($permission);
            }
        }
    }
}
