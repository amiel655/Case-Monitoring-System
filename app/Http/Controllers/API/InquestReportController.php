<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\inquestReport;

class InquestReportController extends Controller
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
        //  $results = DB::table('inquest_report')->select('id', 'name', 'gender', 'address', 'contact', 'legal_advice', 'custodial', 'precint', 'subject', 'time_call', 'time_attend')->where('user_id', auth('api')->user()->id)->get();
        //return $results;
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
            if (inquestReport::where('id', $request['report'][$i]['id'])->exists()) {
                $inquestReport = inquestReport::find($request['report'][$i]['id']);
                $inquestReport->name = $request['report'][$i]['client_name'];
                $inquestReport->gender = $request['report'][$i]['client_gender'];
                $inquestReport->address = $request['report'][$i]['client_address'];
                $inquestReport->contact = $request['report'][$i]['client_contact'];
                $inquestReport->legal_advice = $request['report'][$i]['legal_advice'];
                $inquestReport->custodial = $request['report'][$i]['custodial'];
                $inquestReport->precint = $request['report'][$i]['precint'];
                $inquestReport->subject = $request['report'][$i]['subject'];
                $inquestReport->time_call = $request['report'][$i]['time_call'];
                $inquestReport->time_attend = $request['report'][$i]['time_attend'];
                $inquestReport->save();
            } else {
                if ($request['report'][$i]['client_name'] !== null || $request['report'][$i]['client_gender'] !== null || $request['report'][$i]['client_address'] !== null || $request['report'][$i]['client_contact'] !== null || $request['report'][$i]['legal_advice'] !== null || $request['report'][$i]['custodial'] !== null || $request['report'][$i]['precint'] !== null || $request['report'][$i]['subject'] !== null || $request['report'][$i]['time_call'] !== null || $request['report'][$i]['time_attend'] !== null) {
                    $inquestReport = new inquestReport;
                    $inquestReport->attorney = $request['report'][$i]['attorney'];
                    $inquestReport->control_num = $request['report'][$i]['control_num'];
                    $inquestReport->name = $request['report'][$i]['client_name'];
                    $inquestReport->gender = $request['report'][$i]['client_gender'];
                    $inquestReport->address = $request['report'][$i]['client_address'];
                    $inquestReport->contact = $request['report'][$i]['client_contact'];
                    $inquestReport->legal_advice = $request['report'][$i]['legal_advice'];
                    $inquestReport->custodial = $request['report'][$i]['custodial'];
                    $inquestReport->precint = $request['report'][$i]['precint'];
                    $inquestReport->subject = $request['report'][$i]['subject'];
                    $inquestReport->time_call = $request['report'][$i]['time_call'];
                    $inquestReport->time_attend = $request['report'][$i]['time_attend'];
                    $inquestReport->save();
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
            ->leftJoin('inquest_report', 'control_reference_and_nature_of_request.control_num', '=', 'inquest_report.control_num')
            ->select('inquest_report.id', 'client_profile.control_num', 'inquest_report.legal_advice', 'inquest_report.custodial', 'inquest_report.precint', 'inquest_report.subject', 'inquest_report.time_call', 'inquest_report.time_attend', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact')
            ->where('control_reference_and_nature_of_request.nature_request', 'Inquest/Legal Assistance')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')
            ->get();
        return $results;
    }
}
