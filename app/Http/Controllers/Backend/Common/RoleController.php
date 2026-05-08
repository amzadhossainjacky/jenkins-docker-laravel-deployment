<?php

namespace App\Http\Controllers\Backend\Common;

use DataTables;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


/**
 * RoleController
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class RoleController extends Controller
{

    ## Service properties
    private RoleService $role_service;
    private PermissionService $permission_service;
    private $user_info;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->role_service = new RoleService();
        $this->permission_service = new PermissionService();

        $this->middleware(function ($request, $next) {
            $this->user_info = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $role_list = $this->role_service->get_role_lists();
            $user = $this->user_info;

            if ($request->ajax()) {
                return Datatables::of($role_list)
                    ->addIndexColumn()
                    ->addColumn('action', function ($role_list) use ($user) {
                        $btn = "";
                        if ($user->can('role-edit')) {
                            $btn = $btn . '<a href=' . route(\Request::segment(1) . '.roles.edit', $role_list->id) . ' class="action-btn"><i class="bi bi-pen"></i></a>';
                        }

                        if ($user->can('role-delete')) {
                            $btn = $btn . '<a href=' . route(\Request::segment(1) . '.roles.destroy', $role_list->id) . ' class="destroy-btn"><i class="bi bi-trash"></i></a>';
                        }

                        return $btn;
                    })
                    ->addColumn('permissions', function ($role_list) {

                        $span = '<span>';

                        if (count($role_list->permissions) > 0) {
                            foreach ($role_list->permissions as $key => $item) {
                                $span .= ' <span class="badge bg-secondary">' . $item->name . '</span>';
                            }
                        } else {
                            $span .= '<span class="badge bg-secondary">None</span>';
                        }

                        $span .= '</span>';

                        return $span;
                    })
                    ->rawColumns(['action', 'permissions'])
                    ->make(true);
            }

            return view('backend.common.roles.index');
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = $this->permission_service->get_permission_lists_by_modules();
        return view('backend.common.roles.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = [
            'name' => $request->name,
            'route_segment' => $request->route_segment,
            'guard_name' => 'web',
            'permissions' => $request->permissions,
        ];

        //check permissions
        if ($inputs['permissions'] == null) {
            Toastr::error("Please select permissions", "Error");
            return redirect()->route(\Request::segment(1) . '.roles.create');
        }

        $this->call_for_validation($inputs);

        try {

            $this->role_service->create($inputs);
            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.roles.create');
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = $this->role_service->edit($id);
        $modules = $this->permission_service->get_permission_lists_by_modules();
        $db_role_permission_ids = $this->permission_service->get_db_role_permission_ds($id);
        return view('backend.common.roles.edit', compact('model', 'modules', 'db_role_permission_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = [
            'name' => $request->name,
            'route_segment' => $request->route_segment,
            'permissions' => $request->permissions,
        ];

        //check permissions
        if ($inputs['permissions'] == null) {
            Toastr::error("Please select permissions", "Error");
            return redirect()->back();
        }

        $this->call_for_validation($inputs, 'update', $id);
        try {

            $this->role_service->update($inputs, $id);
            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.roles');
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $model = $this->role_service->destroy($id);
            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.roles');
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * call_for_validation method validate input fields
     * @return void
     */
    private function call_for_validation($inputs, $methods = 'create', $id = -1): void
    {

        if ($methods == 'update') {
            ## Validation rules
            $rules = [
                'name' => ['required', 'unique:roles,name,' . $id],
                'route_segment' => ['required', 'unique:roles,route_segment,' . $id],
            ];
        } else {
            ## Validation rules
            $rules = [
                'name' => ['required', 'unique:roles,name'],
                'route_segment' => ['required', 'unique:roles,route_segment'],
            ];
        }

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();
    }

    /**
     * get_validation_error_message method sets and display validation error messages
     * @return array<string, mixed>
     */
    private function get_validation_error_message()
    {
        return [
            'name.required' => 'Role name required',
            'name.unique' => 'Role name already exist',
            'route_segment.required' => 'Route segment required',
            'route_segment.unique' => 'Route segment name already exist',
        ];
    }
}
