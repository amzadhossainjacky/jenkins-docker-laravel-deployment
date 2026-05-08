<?php

namespace App\Services;

use App\Models\Module;
use Illuminate\Support\Facades\DB;

/**
 * PermissionService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class PermissionService
{

    /**
     * get_permission_lists method returns list of role permission in array
     * @param int $id
     * @return array
     */
    public function get_permission_lists(): array
    {
        return [
            'setting_menu' => [
                'parent_checked' => 1,
                'label' => 'setting menu permissions',
                'list' => [
                    ['name' => 'setting-menu-list', 'checked' => 1],
                ],
            ],
            'roles' => [
                'parent_checked' => 1,
                'label' => 'role permissions',
                'list' => [
                    ['name' => 'role-list', 'checked' => 1],
                    ['name' => 'role-create', 'checked' => 1],
                    ['name' => 'role-edit', 'checked' => 1],
                    ['name' => 'role-delete', 'checked' => 1],
                ],
            ],
            'users' => [
                'parent_checked' => 1,
                'label' => 'user permissions',
                'list' => [
                    ['name' => 'user-list', 'checked' => 1],
                    ['name' => 'user-create', 'checked' => 1],
                    ['name' => 'user-edit', 'checked' => 1],
                    ['name' => 'user-delete', 'checked' => 1],
                ],
            ],
        ];
    }

    /**
     * get_permission_lists method returns list of role permission in array
     * @param int $id
     * @return array
     */
    public function get_permission_lists_by_modules()
    {
        $modules = Module::with('permissions')->get();
        return $modules;
    }

    /**
     * get_db_permission_ds method returns list of permissions by associate role id 
     * @param int $id
     * @return array
     */
    public function get_db_role_permission_ds($id): array
    {
        $db_role_permission_ds = DB::table('role_has_permissions')->where('role_id', $id)->get()->pluck('permission_id')->toArray();

        return $db_role_permission_ds;
    }
}
