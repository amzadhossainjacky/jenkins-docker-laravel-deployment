<?php

namespace App\Http\Controllers\Backend\Common;

use DataTables;
use Illuminate\Http\Request;
use App\Services\TutorialService;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;


/**
 * TutorialController
 * @author Md. Amzad Hossain Jacky <amzadhossainjacky@gmail.com>
 */
class TutorialController extends Controller
{
    ## Service properties
    private TutorialService $tutorial_service;

    /**
     * constructor method
     * @return void
     */
    public function __construct()
    {
        $this->tutorial_service = new TutorialService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $tutorial_list = $this->tutorial_service->get_tutorial_lists();

            if ($request->ajax()) {
                return Datatables::of($tutorial_list)
                    ->addIndexColumn()
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            }

            return view('backend.common.tutorials.index');
        } catch (\Throwable $th) {
            // Get the exception message
            $errorMessage = $th->getMessage();
            Toastr::error("Message: " . $errorMessage, "Error");
            return redirect()->route(\Request::segment(1) . '.dashboard');
        }
    }
}
