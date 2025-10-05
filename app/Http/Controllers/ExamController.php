<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ExamModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class ExamController extends Controller
{
    public function index()
    {
        #checking permission
        $this->authorize('exam_list', 16);

        try {
            #getting exam list
            $exam_list = ExamModel::getExams();
            $header_title = 'Exam';
            return view('admin.exam.index', compact('exam_list', 'header_title'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }
    public function store(Request $request)
    {
        #checking permission
        $this->authorize('exam_add', 17);

        $rules = [
            'name' => 'required|max:255|unique:exam',
            'bangla_name' => 'nullable|max:255',
            'status' => 'required',
        ];
        $message = [
            'name.required' => 'Exam name required',
            'bangla_name.max' => 'Name max length 255 characters',
            'name.unique' => 'Exam already exists',
            'status.required' => 'Status required',
        ];
        $this->validate($request, $rules, $message);
        try {
            DB::transaction(function () use ($request) {
                ExamModel::insert([
                    'name' => trim($request->name),
                    'status' => $request->status,
                    'created_by' => Auth::user()->user_id,
                ]);
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Exam information added #' . trim($request->name));
            });
            return redirect(route('exam'))->with('success', 'Exam information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function update(Request $request)
    {
        #checking permission
        $this->authorize('exam_edit', 18);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            #validation
            $rules = [
                'name' => ['required', Rule::unique('exam')->ignore($id, 'id'), 'max:255'],
                'status' => 'required',
            ];
            $message = [
                'name.required' => 'Exam name required',
                'name.max' => 'Exam name max length 255 characters',
                'name.unique' => 'Exam already exists',
                'status.required' => 'Status required',
            ];
            $this->validate($request, $rules, $message);
            try {
                DB::transaction(function () use ($request, $id) {
                    ExamModel::where('id', $id)->update([
                        'name' => trim($request->name),
                        'status' => $request->status,
                        'updated_by' => Auth::user()->user_id,
                    ]);
                    #activity process
                    Helper::store_activity(Auth::user()->user_id, 'Exam information updated #' . trim($request->name));
                });
                return redirect(route('exam'))->with('success', 'Exam information updated successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
    public function delete(Request $request)
    {
        #checking permission
        $this->authorize('exam_delete', 19);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if ($id > 0 && is_numeric($id)) {
            $exam_info = ExamModel::where('id', $id)->first();
            if ($exam_info == "") {
                return redirect()->back()->with('error', 'Exam information not found');
            }
            $name = $exam_info->name;
            $is_deletable = ExamModel::isDeletable($id);
            if ($is_deletable) {
                $exam_info->delete();
                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Exam information deleted #' . trim($name));
                return redirect(route('exam'))->with('success', 'Exam successfully deleted');
            } else {
                return redirect(route('exam'))->with('error', 'Exam already in use, Can not be deleted');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid parameter or request');
        }
    }
}
