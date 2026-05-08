<?php

namespace App\Http\Controllers\Backend\Common;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Services\ExamQuestionService;
use Illuminate\Support\Facades\Validator;

/**
 * ExamController
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class ExamQuestionController extends Controller
{
    ## Service properties
    private ExamQuestionService $exam_question_service;
    private $user_info;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->exam_question_service = new ExamQuestionService();

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

            $exam_question_lists = $this->exam_question_service->get_exam_question_lists();
            $user = $this->user_info;

            if ($request->ajax()) {
                return Datatables::of($exam_question_lists)
                    ->addIndexColumn()
                    ->addColumn('action', function ($exam_question_list) use ($user) {
                        if ($user->can('exam-edit')) {
                            $btn = '<a href=' . route(\Request::segment(1) . '.exam.questions.edit', $exam_question_list->id) . ' class="action-btn"><i class="bi bi-pen"></i></a>';
                            return $btn;
                        }
                    })
                    ->rawColumns(['action',])
                    ->make(true);
            }

            return view('backend.common.exam_questions.index');
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
            return view('backend.common.exam_questions.create');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
