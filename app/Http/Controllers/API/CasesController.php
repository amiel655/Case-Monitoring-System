<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Cases;
use App\Event;
use App\Hearing;
use App\natureRequest;
use App\caseTransfer;
use App\Notifications\TransferCase;
use Notification;
use Illuminate\Notifications\Notifiable;

class CasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth('api')->user()->type === 'Super Admin') {
            $results = DB::table('cases')->select('cases.*')->latest()->paginate(20);
            return $results;
        }

        if(auth('api')->user()->type === 'Admin') {
            $results = DB::table('cases')->select('cases.*')->where('cases.assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->latest()->paginate(20);
            return $results;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hearing = DB::table('hearing')
            ->join('cases', 'hearing.case_no', '=', 'cases.case_no')->orderBy('hearing_date', 'desc')
            ->select('hearing.*')
            ->where('cases.control_num', '=', $id)->get();
        $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->join('calendar', 'cases.case_no', '=', 'calendar.case_no')->orderBy('start_date', 'desc')
            ->select('cases.*', 'client_profile.client_name', 'client_profile.client_age', 'calendar.*')
            ->where('cases.control_num', '=', $id)->get();
        return [$results, $hearing];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $case = DB::table('cases')->where('case_no', $id)
        ->update([
            'assigned_to' => $request['assigned_to'],
            'case_title' => $request['case_title'],
            'court' => $request['court'],
            'crime' => implode(',', $request['crimes']),
            'detained' => $request['detained'],
            'complainant' => implode(',', $request['complainants']),
            'respondent' => implode(',', $request['respondents']),
            'status' => $request['status'],
            'case_summary' => $request['case_summary'],
            'access_code' => $request['access_code'],
            'access_status' => $request['access_status']
        ]);

        $form = natureRequest::where('control_num', $request['control_num'])->pluck('control_num');
        $update = natureRequest::where('control_num', $form)->update([
            'assigned_to' => $request['assigned_to']
        ]);

        if($request['assigned_to'] !== $request['assigned_from']) {
            $assigned_to = User::where(DB::raw('CONCAT(firstname, " ", lastname)'), 'LIKE', '%' . $request['assigned_to'] . '%')->get();
            $assigned_from = User::where(DB::raw('CONCAT(firstname, " ", lastname)'), 'LIKE', '%' . $request['assigned_from'] . '%')->get();
            $assigned_to[0]->notify(new TransferCase($request['case_no'], $request['assigned_from'], $request['assigned_to'], $assigned_from[0]['image']));
            $assigned_from[0]->notify(new TransferCase($request['case_no'], $request['assigned_from'], $request['assigned_to'], $assigned_to[0]['image']));
        }


        if($request['assigned_to'] !== auth()->user()->firstname.' '.auth()->user()->lastname) {
            $transfer = new caseTransfer;
            $transfer->case_no = $request['case_no'];
            $transfer->assigned_to = auth()->user()->firstname.' '.auth()->user()->lastname;
            $transfer->transfer_to = $request['assigned_to'];
            $transfer->save();
        }

        if($request['hearing_date'] !== null) {
            $hearing = new Hearing;
            $hearing->user_id = auth()->user()->id;
            $hearing->hearing_date = $request['hearing_date'];
            $hearing->case_status = $request['status'];
            $hearing->case_no = $request['case_no'];
            $hearing->case_summary = $request['case_summary'];
            $hearing->save();

            $calendar = new Event;
            $calendar->user_id = auth()->user()->id;
            $calendar->control_num = $request['control_num'];
            $calendar->case_no = $request['case_no'];
            $calendar->title = $request['case_title'];
            $calendar->color = "#007bff";
            $calendar->start_date = new \DateTime($request['hearing_date']);
            $calendar->end_date = new \DateTime($request['hearing_date']);
            $calendar->save();
        }

        // return view('includes.dashboard.navbar',compact(auth()->user()->unreadNotifications));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateAccessCode(Request $request) {
        $new_code = str_random(6);

        return $new_code;
    }

}
