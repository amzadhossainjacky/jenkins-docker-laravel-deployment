<?php

namespace App\Http\Controllers\Backend\Common;

use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\UserService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * UserController
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class UserController extends Controller
{
    ## Service properties
    private UserService $user_service;
    private RoleService $role_service;
    private $user_info;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->user_service = new UserService();
        $this->role_service = new RoleService();

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

            $user_list = $this->user_service->get_user_lists();
            $user = $this->user_info;

            if ($request->ajax()) {
                return Datatables::of($user_list)
                    ->addIndexColumn()
                    ->addColumn('action', function ($user_list) use ($user) {
                        if ($user->can('user-edit')) {
                            $btn = '<a href=' . route(\Request::segment(1) . '.users.edit', $user_list->id) . ' class="action-btn"><i class="bi bi-pen"></i></a>';
                            return $btn;
                        }
                    })
                    ->addColumn('role', function ($user_list) {

                        return $user_list->getRoleNames()[0];
                    })
                    ->addColumn('status', function ($user_list) {

                        $active = '<span class="badge bg-success">Active</span>';

                        return $user_list->is_active ? $active : '<span class="badge bg-secondary">Inactive</span>';
                    })
                    ->rawColumns(['action', 'status', 'role'])
                    ->make(true);
            }

            return view('backend.common.users.index');
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
        try {

            $roles = $this->role_service->get_role_lists();
            return view('backend.common.users.create', compact('roles'));
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = [
            'name' => $request->name,
            'gender' => $request->gender,
            'role' => $request->role,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password,
            'is_active' => $request->is_active,
        ];

        ## Validation rules
        $rules = [
            'name' => ['required', 'min:5', 'max:100'],
            'gender' => ['required'],
            'role' => ['required'],
            'email' => ['required', 'email', 'min:5', 'max:50', 'unique:users,email'],
            'mobile' => ['required', 'numeric', 'min:0', 'unique:users,mobile'],
            'password' => ['required', 'min:8', 'max:100'],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();


        try {
            $model_created = $this->user_service->create($inputs);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.users.create');
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
        try {
            $model = $this->user_service->edit($id);
            $roles = $this->role_service->get_role_lists();

            return view('backend.common.users.edit', compact('model', 'roles'));
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $inputs = [
            'name' => $request->name,
            'gender' => $request->gender,
            'role' => $request->role,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'is_active' => $request->is_active,
        ];


        if ($request->password != null) {
            $inputs = $inputs + ['password' => $request->password];
        }

        ## Validation rules
        $rules = [
            'name' => ['required', 'min:5', 'max:100'],
            'gender' => ['required'],
            'role' => ['required'],
            'email' => ['required', 'email', 'min:5', 'max:50', 'unique:users,email,' . $id],
            'mobile' => ['required', 'numeric', 'min:0', 'unique:users,mobile,' . $id],
            'password' => ['sometimes', 'min:8', 'max:100'],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();

        try {
            $model_updated = $this->user_service->update($inputs, $id);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.users');
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * get_validation_error_message method sets and display validation error messages
     * @return array<string, mixed>
     */
    private function get_validation_error_message()
    {
        return [
            'name.required' => 'User name required',
            'email.required' => 'User email required',
        ];
    }
}
