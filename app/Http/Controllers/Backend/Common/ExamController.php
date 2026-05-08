<?php

namespace App\Http\Controllers\Backend\Common;

use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ExamService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

/**
 * ExamController
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class ExamController extends Controller
{
    ## Service properties
    private ExamService $exam_service;
    private $user_info;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->exam_service = new ExamService();

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

            $exam_list = $this->exam_service->get_exam_lists();
            $user = $this->user_info;

            if ($request->ajax()) {
                return Datatables::of($exam_list)
                    ->addIndexColumn()
                    ->addColumn('action', function ($exam_list) use ($user) {
                        if ($user->can('exam-edit')) {
                            $btn = '<a href=' . route(\Request::segment(1) . '.exams.edit', $exam_list->id) . ' class="action-btn"><i class="bi bi-pen"></i></a>';
                            return $btn;
                        }
                    })
                    ->addColumn('question_info', function ($exam_list) {
                        $question_info = "";
                        $question_info = $question_info . '<p>Total num of questions: ' . $exam_list->total_num_of_questions . ' </p>';
                        $question_info = $question_info . '<p>Time per question(seconds): ' . $exam_list->time_per_question . 's</p>';
                        $question_info = $question_info . '<p>Passing percentage: ' . $exam_list->passing_percentage . '%</p>';
                        return $question_info;
                    })
                    ->addColumn('other', function ($exam_list) {
                        $other = "";
                        $other = $other . '<p>Start time: ' . (function_exists('_get_date_from_datetime') ? _get_date_from_datetime($exam_list->start_time) : $exam_list->start_time) . '</p>';
                        $other = $other . '<p>End time : ' . (function_exists('_get_date_from_datetime') ? _get_date_from_datetime($exam_list->end_time) : $exam_list->end_time)  . '</p>';
                        return $other;
                    })
                    ->addColumn('status', function ($exam_list) {
                        $active = '<span class="badge bg-success">Active</span>';
                        return $exam_list->is_active ? $active : '<span class="badge bg-secondary">Inactive</span>';
                    })
                    ->rawColumns(['action', 'status', 'other', 'question_info'])
                    ->make(true);
            }

            return view('backend.common.exams.index');
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
            return view('backend.common.exams.create');
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
            'user_id' => Auth::id(),
            'description' => $request->description,
            'title' => $request->title,
            'total_num_of_questions' => $request->total_num_of_questions,
            'time_per_question' => $request->time_per_question,
            'passing_percentage' => $request->passing_percentage,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_active' => $request->is_active,
        ];

        ## Validation rules
        $rules = [
            'title' => ['required', 'min:3', 'max:100', 'unique:exams,title'],
            'description' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'total_num_of_questions' => ['required', 'integer', 'min:1'],
            'time_per_question' => ['required', 'integer', 'min:1'],
            'passing_percentage' => ['required', 'numeric', 'between:1,100'],
            'is_active' => ['required'],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();

        $inputs = $inputs + ['exam_total_duration' => $request->total_num_of_questions * $request->time_per_question];


        try {
            $model_created = $this->exam_service->create($inputs);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.exams.create');
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
            $model = $this->exam_service->edit($id);

            return view('backend.common.exams.edit', compact('model'));
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
            'user_id' => Auth::id(),
            'description' => $request->description,
            'title' => $request->title,
            'total_num_of_questions' => $request->total_num_of_questions,
            'time_per_question' => $request->time_per_question,
            'passing_percentage' => $request->passing_percentage,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_active' => $request->is_active,
        ];

        ## Validation rules
        $rules = [
            'title' => ['required', 'min:3', 'max:100', "unique:exams,title,{$id}"],
            'description' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'total_num_of_questions' => ['required', 'integer', 'min:1'],
            'time_per_question' => ['required', 'integer', 'min:1'],
            'passing_percentage' => ['required', 'numeric', 'between:1,100'],
            'is_active' => ['required'],
        ];

        ## Validate rules
        Validator::make(
            $inputs,
            $rules,
            $this->get_validation_error_message()
        )->validate();

        $inputs = $inputs + ['exam_total_duration' => $request->total_num_of_questions * $request->time_per_question];

        try {
            $model_updated = $this->exam_service->update($inputs, $id);

            Toastr::success("Action successful", "Success");
            return redirect()->route(\Request::segment(1) . '.exams');
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
            'title.unique' => 'Ttitle already exist',
            'description.required' => 'Description required',
            'start_time.required' => 'Start time required',
            'end_time.required' => 'End time required',
            'total_num_of_questions.required' => 'Total num of questions required',
            'time_per_question.required' => 'Time per question required',
            'passing_percentage.required' => 'Passing percentage required',
        ];
    }
}
