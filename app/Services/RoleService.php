<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;

/**
 * RoleService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class RoleService
{

    /**
     * get_role_lists method returns list of roles
     * @return collection
     */
    public function get_role_lists()
    {
        return Role::all();
    }
    
    /**
     * create role
     * @param array $inputs
     * @return \App\Models\Role
     */
    public function create($inputs): Role
    {
        $permissions = $inputs['permissions'];
        unset($inputs['permissions']);

        $permission_names = [];

        foreach ($permissions as $index => $permission) {
            $name = Permission::where('id', $permission)->first();
            if ($name != null) {
                $permission_names[] = $name;
            }
        }

        $role_created = Role::Create(
            $inputs
        );

        if ($role_created) {
            $role_created->syncPermissions($permission_names);
        }

        return $role_created;
    }

    /**
     * edit role
     * @param array $id
     * @return \App\Models\Role
     */
    public function edit($id): Role
    {

        $data = Role::find($id);
        return $data;
    }

    /**
     * update role
     * @param array $inputs
     * @return \App\Models\Role
     */
    public function update($inputs, $id): Role
    {

        $permissions = $inputs['permissions'];
        $model_update = Role::find($id);
        $model_update->name = $inputs['name'];
        $model_update->route_segment = $inputs['route_segment'];
        $model_update->save();

        # Unset unwanted attributes from inputs for creating new task
        unset($inputs['permissions']);

        $permission_names = [];

        foreach ($permissions as $index => $permission) {
            $name = Permission::where('id', $permission)->first();
            if ($name != null) {
                $permission_names[] = $name;
            }
        }

        if ($model_update && count($permissions)) {
            $model_update->syncPermissions($permission_names);
        }

        return $model_update;
    }

    /**
     * destroy role
     * @param array $inputs
     * @return \App\Models\void
     */
    public function destroy($id): Void
    {
        $model_destroy = Role::destroy($id);
    }

}