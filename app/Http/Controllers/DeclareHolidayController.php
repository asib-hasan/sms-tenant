<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\HolidayModel;
use App\Models\HolidayRecordModel;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\TextUI\Help;

class DeclareHolidayController extends Controller
{
    public function index(Request $request)
    {
        #checking permission
        $this->authorize('declare_holiday', 94);

        try {
            $year = null;
            if($request->has('year') && $request->year != null){
                $year = $request->year;
                $holiday_list = HolidayRecordModel::whereYear('from_date', $year)->get();
            } else {
                #getting holiday list
                $holiday_list = HolidayRecordModel::whereYear('from_date', date('Y'))->get();
            }
            $header_title = 'Declare Holiday';
            return view('admin.declare_holiday.index', compact('holiday_list', 'header_title','year'));
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        #checking permission
        $this->authorize('declare_holiday', 94);

        $rules = [
            'name' => 'required|max:100',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after:from_date',
        ];

        $message = [
            'name.required' => 'Name required',
            'from_date.required' => 'From date required',
            'to_date.required' => 'To date required',
            'to_date.after' => 'To date must be after date from',
        ];

        $this->validate($request, $rules, $message);
        $from_date = $request->from_date;
        if($request->to_date == null){
            $to_date = $request->from_date;
        } else {
            $to_date = $request->to_date;
        }
        $holiday_info = HolidayModel::whereBetween('date',[$from_date,$to_date])->get();

        if($holiday_info->count() > 0){
            return redirect()->back()->with('error', 'Selected date range already exists');
        }

        try {
            DB::transaction(function () use ($request, $from_date, $to_date) {
                $from_date = Carbon::parse($from_date);
                $to_date = Carbon::parse($to_date);

                HolidayRecordModel::insert([
                   'name' => $request->name,
                   'from_date' => $from_date,
                   'to_date' => $to_date,
                   'created_by' => Auth::user()->user_id,
                ]);
                #bulk insert
                $holidays = [];
                for ($date = $from_date; $date <= $to_date; $date->addDay()) {
                    $holidays[] = [
                        'name' => $request->name,
                        'date' => $date->format('Y-m-d'),
                    ];
                }
                HolidayModel::insert($holidays);

                #activity process
                Helper::store_activity(Auth::user()->user_id, 'Holidays added successfully #' . trim($request->name));
            });
            return redirect(route('hrmgt/declare/holiday'))->with('success', 'Holidays information saved successfully');
        } catch (QueryException $ex) {
            return redirect()->back()->with('error', 'Process failed for - ' . $ex->getMessage());
        }
    }

    public function delete(Request $request)
    {
        #checking permission
        $this->authorize('declare_holiday', 94);

        $id = Helper::encrypt_decrypt('decrypt', $request->id);
        if(is_numeric($id) && $id > 0) {
            try {
                $holiday_record_info = HolidayRecordModel::where('id', $id)->first();
                if(!$holiday_record_info){
                    return redirect()->back()->with('error', 'Holiday record information not found');
                }
                DB::transaction(function () use ($id, $holiday_record_info) {
                    $name = $holiday_record_info->name;
                    #delete
                    HolidayModel::whereBetween('date', [$holiday_record_info->from_date, $holiday_record_info->to_date])->delete();
                    $holiday_record_info->delete();
                    #store activity
                    Helper::store_activity(Auth::user()->user_id, 'Holiday deleted successfully #' . $name);
                });

                return redirect(route('hrmgt/declare/holiday'))->with('success', 'Holiday deleted successfully');
            } catch (QueryException $ex) {
                return redirect()->back()->with('error', 'Delete process failed for - ' . $ex->getMessage());
            }
        } else{
            return redirect(route('hrmgt/declare/holiday'))->with('error', 'Invalid parameter or request');
        }
    }
}
