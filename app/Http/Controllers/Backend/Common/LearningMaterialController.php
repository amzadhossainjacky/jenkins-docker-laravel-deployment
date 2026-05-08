<?php

namespace App\Http\Controllers\Backend\Common;

use DataTables;
use Illuminate\Http\Request;
use App\Services\LearningMaterialService;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * LearningMaterialController
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class LearningMaterialController extends Controller
{
    ## Service properties
    private LearningMaterialService $leaning_material_service;
    private $user_info;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->leaning_material_service = new LearningMaterialService();

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

            $learning_material_list = $this->leaning_material_service->get_learning_material_lists();
            $user = $this->user_info;

            if ($request->ajax()) {
                return Datatables::of($learning_material_list)
                    ->addIndexColumn()
                    ->addColumn('action', function ($learning_material_list) use ($user) {
                        if ($user->can('learning-material-edit')) {
                            $btn = '<a href=' . route(\Request::segment(1) . '.learning.materials.edit', $learning_material_list->id) . ' class="action-btn"><i class="bi bi-pen"></i></a>';
                            return $btn;
                        }
                    })
                    ->addColumn('status', function ($learning_material_list) {

                        $active = '<span class="badge bg-success">Active</span>';

                        return $learning_material_list->is_active ? $active : '<span class="badge bg-secondary">Inactive</span>';
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }

            return view('backend.common.learning_materials.index');
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
            return view('backend.common.learning_materials.create');
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
        $request->validate([
            'files.*' => ['sometimes', 'mimes:jpeg,jpg,png,pdf,xlsx,docx,doc,ppt,pptx,txt'],
        ], [
            'files.*.mimes' => 'Attachment extension should be jpeg, jpg, png, pdf, xlsx, docx, doc, ppt, pptx, or txt.',
        ]);

        $inputs = [
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ];
        if (count($request->files) > 0) {
            $inputs = $inputs + ['attachment' => $request['files']];
        }

        ## Validation rules
        $rules = [
            'title' => ['required', 'min:3', 'max:100', 'unique:learning_materials,title'],
            'description' => ['required'],
            'is_active' => ['required'],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();


        try {

            $this->leaning_material_service->create($inputs);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.learning.materials');
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }

    /**
     * remove the specified resource.
     */
    public function remove_attachment(string $id, $attachment_id)
    {

        try {
            $remove_attachment = $this->leaning_material_service->remove_attachment($id, $attachment_id);
            return redirect()->route(\Request::segment(1) . '.learning.materials.edit', $id);
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
            $model = $this->leaning_material_service->edit($id);

            return view('backend.common.learning_materials.edit', compact('model'));
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
        $request->validate([
            'files.*' => ['sometimes', 'mimes:jpeg,jpg,png,pdf,xlsx,docx,doc,ppt,pptx,txt'],
        ], [
            'files.*.mimes' => 'Attachment extension should be jpeg, jpg, png, pdf, xlsx, docx, doc, ppt, pptx, or txt.',
        ]);

        $inputs = [
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ];
        if (count($request->files) > 0) {
            $inputs = $inputs + ['attachment' => $request['files']];
        }

        ## Validation rules
        $rules = [
            'title' => ['required', 'min:3', 'max:100', 'unique:learning_materials,title,' . $id],
            'description' => ['required'],
            'is_active' => ['required'],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();


        try {

            $this->leaning_material_service->update($inputs, $id);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.learning.materials');
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
            'title.required' => 'Title required',
            'title.unique' => 'Title already exist',
            'description.required' => 'Description required',
        ];
    }
}
