<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * UserService
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class UserService
{
    /**
     * get_user_lists method returns list of users
     * @return collection
     */
    public function get_user_lists()
    {
        return User::orderBy('id', 'DESC');
    }

    /**
     * create methods returns create resource
     * @param array $inputs
     * @return \App\Models\User
     */
    public function create(array $inputs): User
    {

        $inputs['password'] = Hash::make($inputs['password']);

        $user_created = User::Create(
            $inputs
        );

        $user_created->assignRole($inputs['role']);
        return $user_created;
    }

    /**
     * edit user
     * @param array $id
     * @return \App\Models\User
     */
    public function edit($id): User
    {
        $data = User::with('roles')->find($id);
        return $data;
    }

    /**
     * update user
     * @param array $inputs
     */
    public function update($inputs, $id)
    {

        $user = User::find($id);

        if (isset($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        }

        $user->fill($inputs);
        $user->save();

        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();

        $user->assignRole($inputs['role']);

        return $user;
    }
}
