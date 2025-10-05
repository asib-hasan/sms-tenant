<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\MonthsModel;
use App\Models\SchoolInfoModel;
use App\Models\SessionModel;
use Illuminate\Http\Request;
use PDF;

class FeesCollectionSummaryController extends Controller
{
    public function index(Request $request)
    {
        # Authorize the action
        $this->authorize('fees_collection', 52);

        # Initialize variables
        $flag = $class_id = $session_id =  null;

        if($request->has(['session_id'])){
            $session_id = $request->session_id;
            $flag = 1;
        }
        $month_list = MonthsModel::all();
        $session_list = SessionModel::getActiveSessions();
        $class_list = ClassModel::getActiveClasses();
        $header_title = "Collection Summary";
        return view('admin.student_fee.fees_collection.collection_summary', compact('class_id', 'class_list', 'month_list', 'session_id', 'session_list', 'flag', 'header_title'));
    }
    public function print(Request $request)
    {
        # Authorize the action
        $this->authorize('fees_collection', 52);

        if($request->has(['session_id'])){
            $data = [
                'session_id' => $request->session_id,
                'school_info' => SchoolInfoModel::first(),
                'month_list' => MonthsModel::all(),
            ];
            $pdf = PDF::loadView('admin.student_fee.fees_collection.collection_summary_pdf', $data);
            $file_name ='Collection_summary.pdf';
            return $pdf->stream($file_name);
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
