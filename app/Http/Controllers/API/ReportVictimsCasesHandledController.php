<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\reportVictimsCasesHandled;

class ReportVictimsCasesHandledController extends Controller
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
        // $results = DB::table('report_victims_cases_handled')->select('id', 'item_no', 'nature_client', 'gender', 'address', 'contact_no', 'action_taken', 'remarks')->where('user_id', auth('api')->user()->id)->get();
        // return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        for ($i = 0; $i < $request['length']; $i++) {
            if (reportVictimsCasesHandled::where('id', $request['report'][$i]['id'])->exists()) {
                $reportVictims = reportVictimsCasesHandled::find($request['report'][$i]['id']);
                $reportVictims->item_no = $request['report'][$i]['id'];
                $reportVictims->nature_client = $request['report'][$i]['client_name'];
                $reportVictims->gender = $request['report'][$i]['client_gender'];
                $reportVictims->address = $request['report'][$i]['client_address'];
                $reportVictims->contact_no = $request['report'][$i]['client_contact'];
                $reportVictims->action_taken = $request['report'][$i]['action_taken'];
                $reportVictims->remarks = $request['report'][$i]['remarks'];
                $reportVictims->save();
            } else {
                if ($request['report'][$i]['id'] !== null || $request['report'][$i]['client_name'] !== null || $request['report'][$i]['client_gender'] !== null || $request['report'][$i]['client_address'] !== null || $request['report'][$i]['client_contact'] !== null || $request['report'][$i]['action_taken'] !== null || $request['report'][$i]['remarks'] !== null) {
                    $reportVictims = new reportVictimsCasesHandled;
                    $reportVictims->attorney = $request['report'][$i]['attorney'];
                    $reportVictims->control_num = $request['report'][$i]['control_num'];
                    $reportVictims->item_no = $request['report'][$i]['id'];
                    $reportVictims->nature_client = $request['report'][$i]['client_name'];
                    $reportVictims->gender = $request['report'][$i]['client_gender'];
                    $reportVictims->address = $request['report'][$i]['client_address'];
                    $reportVictims->contact_no = $request['report'][$i]['client_contact'];
                    $reportVictims->action_taken = $request['report'][$i]['action_taken'];
                    $reportVictims->remarks = $request['report'][$i]['remarks'];
                    $reportVictims->save();
                }
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

    public function loadReport(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('client_profile')
            ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
            ->join('client_case_involvement', 'client_profile.control_num', '=', 'client_case_involvement.control_num')
            ->leftJoin('report_victims_cases_handled', 'client_profile.control_num', '=', 'report_victims_cases_handled.control_num')
            ->select('report_victims_cases_handled.id', 'report_victims_cases_handled.attorney', 'client_profile.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact', 'report_victims_cases_handled.action_taken', 'report_victims_cases_handled.remarks')
            ->where('client_case_involvement.involvement', 'Complainant/Victim')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('client_profile.created_at', 'like', '%' . $date . '%')
            ->get();
        return $results;
    }
}
