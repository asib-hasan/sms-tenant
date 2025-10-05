<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\GradeModel;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{

    public function index() {
        #checking permission
        $this->authorize('grade_list', 20);

        try {
            #getting grade list
            $grade_list = GradeModel::latest()->get();
            $header_title = 'Grade List';
            return view('admin.grade.index', compact('grade_list','header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
}
