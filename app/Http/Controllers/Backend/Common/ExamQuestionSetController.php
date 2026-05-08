<?php

namespace App\Http\Controllers\Backend\Common;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ExamQuestionSetService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

/**
 * ExamQuestionSetController
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class ExamQuestionSetController extends Controller
{
    ## Service properties
    private ExamQuestionSetService $exam_question_set_service;
    private $user_info;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->exam_question_set_service = new ExamQuestionSetService();

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

            $exam_question_set_list = $this->exam_question_set_service->get_exam_question_set_lists();
            $user = $this->user_info;

            if ($request->ajax()) {
                return Datatables::of($exam_question_set_list)
                    ->addIndexColumn()
                    ->addColumn('action', function ($exam_question_set_list) use ($user) {
                        if ($user->can('exam-question-set-edit')) {
                            $btn = '<a href=' . route(\Request::segment(1) . '.exam.question.sets.edit', $exam_question_set_list->id) . ' class="action-btn"><i class="bi bi-pen"></i></a>';
                            return $btn;
                        }
                    })
                    ->addColumn('status', function ($exam_question_set_list) {

                        $active = '<span class="badge bg-success">Active</span>';

                        return $exam_question_set_list->is_active ? $active : '<span class="badge bg-secondary">Inactive</span>';
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }

            return view('backend.common.exam_question_sets.index');
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
            return view('backend.common.exam_question_sets.create');
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
            'set_name' => $request->set_name,
            'is_active' => $request->is_active,
        ];

        ## Validation rules
        $rules = [
            'set_name' => ['required', 'min:1', 'max:100', 'unique:exam_question_sets,set_name'],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();


        try {
            $model_created = $this->exam_question_set_service->create($inputs);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.exam.question.sets.create');
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
            $model = $this->exam_question_set_service->edit($id);

            return view('backend.common.exam_question_sets.edit', compact('model'));
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
            'set_name' => $request->set_name,
            'is_active' => $request->is_active,
        ];

        ## Validation rules
        $rules = [
            'set_name' => ['required', 'min:1', 'max:100', 'unique:exam_question_sets,set_name,' . $id],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();

        try {
            $model_updated = $this->exam_question_set_service->update($inputs, $id);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.exam.question.sets');
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
            'set_name.required' => 'Set name required',
            'set_name.unique' => 'Set name already exist',
        ];
    }
}
