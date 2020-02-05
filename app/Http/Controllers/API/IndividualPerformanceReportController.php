<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\individualPerformanceReport;
use App\Cases;
use Carbon\Carbon;

class IndividualPerformanceReportController extends Controller
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
        // $results = DB::table('individual_performance_report')->select('id', 'section', 'key_indicators_of_performance', 'total', 'cr', 'cv', 'adm1', 'adm2', 'adm3')->where('attorney', 'Shernon Severino')->get();
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
        for ($i = 0; $i < 162; $i++) {
            if (individualPerformanceReport::where('id', $request[$i]['item'])->exists()) {
                $individualPerformanceReport = individualPerformanceReport::find($request[$i]['item']);
                $individualPerformanceReport->total = $request[$i]['total'];
                $individualPerformanceReport->cr = $request[$i]['cr'];
                $individualPerformanceReport->cv = $request[$i]['cv'];
                $individualPerformanceReport->adm1 = $request[$i]['adm1'];
                $individualPerformanceReport->adm2 = $request[$i]['adm2'];
                $individualPerformanceReport->adm3 = $request[$i]['adm3'];
                $individualPerformanceReport->save();
            } else {
                if ($request[$i]['total'] !== null || $request[$i]['total'] !== null || $request[$i]['cr'] !== null || $request[$i]['cv'] !== null || $request[$i]['adm1'] !== null || $request[$i]['adm2'] !== null || $request[$i]['adm3'] !== null) {
                    $individualPerformanceReport = new individualPerformanceReport;
                    $individualPerformanceReport->attorney = $request[$i]['atty'];
                    $individualPerformanceReport->report_month = $request[$i]['report_month'];
                    $individualPerformanceReport->section = $request[$i]['section'];
                    $individualPerformanceReport->key_indicators_of_performance = $request[$i]['key_indicators_of_performance'];
                    if ($request[$i]['title'] === 'TOTAL NO. OF INAMTES SERVED/RELEASED' || $request[$i]['title'] === 'TOTAL NUMBER OF CLIENTS ASSISTED' || $request[$i]['title'] === 'TOTAL NUMBER OF REQUEST FOR LEGAL ASSISTANCE/REPRESENTATION ACTED UPON WITHIN 3 WORKING DAYS (JUDICAL)' || $request[$i]['title'] === 'TOTAL NUMBER OF REQUEST FOR ASSISTANCE ACTED UPON WITHIN 2 HOURS (NON-JUDICIAL)' || $request[$i]['title'] === 'TOTAL NUMBER OF SCHEDULED HEARINGS (JUDICIAL & QUASI-JUDICIAL)' || $request[$i]['title'] === 'TOTAL NUMBER OF POSTPONEMENTS SOUGHT BY PUBLIC ATTORNEY (JUDICIAL & QUASI-JUDICIAL)') {
                        $individualPerformanceReport->key_indicators_of_performance = $request[$i]['title'];
                    }
                    $individualPerformanceReport->total = $request[$i]['total'];
                    $individualPerformanceReport->cr = $request[$i]['cr'];
                    $individualPerformanceReport->cv = $request[$i]['cv'];
                    $individualPerformanceReport->adm1 = $request[$i]['adm1'];
                    $individualPerformanceReport->adm2 = $request[$i]['adm2'];
                    $individualPerformanceReport->adm3 = $request[$i]['adm3'];
                    $individualPerformanceReport->save();
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
        return $id;
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
        //$date = date('Y-m', strtotime($request['date']));
        $results = DB::table('individual_performance_report')->select('id', 'section', 'key_indicators_of_performance', 'total', 'cr', 'cv', 'adm1', 'adm2', 'adm3')
            ->where('attorney', $request['name'])
        //->where('created_at', 'like', '%' . $date . '%')
            ->where('report_month', $request['date'])
            ->get();
        return $results;
    }

    public function pendingCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingADM1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingADM2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingADM3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function receivedCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedADM1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedADM2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedADM3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferADM1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferADM2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferADM3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function totalTerminatedOld(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
        $dates = Carbon::parse($request['date']);
        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', '>=' , $dates->subMonth())
            ->count();

        return $results;
    }
    
    public function totalTerminatedNew(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
        $dates = Carbon::parse($request['date']);
        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function AquittedCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Acquitted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function AquittedCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Acquitted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function AquittedAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Acquitted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function AquittedAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Acquitted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function AquittedAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Aquitted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedwpCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Dismissed with Prejudice')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedwpCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Dismissed with Prejudice')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }
    
    public function DismissedwpAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Dismissed with Prejudice')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedwpAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Dismissed with Prejudice')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedwpAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Dismissed with Prejudice')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MotionCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Motion to Quash Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MotionCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Motion to Quash Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MotionAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Motion to Quash Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MotionAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Motion to Quash Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MotionAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Motion to Quash Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DemurrerCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Demurrer to Evidence Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DemurrerCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Demurrer to Evidence Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DemurrerAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Demurrer to Evidence Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DemurrerAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Demurrer to Evidence Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DemurrerAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Demurrer to Evidence Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProvisionallyDCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Provisionally Dismissed')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProvisionallyDCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Provisionally Dismissed')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProvisionallyDAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Provisionally Dismissed')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProvisionallyDAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Provisionally Dismissed')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProvisionallyDAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Provisionally Dismissed')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedToLesserCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Convicted to Lesser Offense')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }
    
    public function ConvictedToLesserCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Convicted to Lesser Offense')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedToLesserAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Convicted to Lesser Offense')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedToLesserAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Convicted to Lesser Offense')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedToLesserAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Convicted to Lesser Offense')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProbationGrantedCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Probation Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }
    
    public function ProbationGrantedCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Probation Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }
    
    public function ProbationGrantedAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Probation Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProbationGrantedAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Probation Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ProbationGrantedAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Probation Granted')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WonCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Won')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WonCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Won')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WonAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Won')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WonAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Won')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WonAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Won')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function GrantedLesserCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Granted Lesser Award')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function GrantedLesserCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Granted Lesser Award')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function GrantedLesserAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Granted Lesser Award')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function GrantedLesserAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Granted Lesser Award')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function GrantedLesserAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Granted Lesser Award')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCasesCACriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Dismissed Cases Based on Comprise Agreement')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCasesCACivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Dismissed Cases Based on Comprise Agreement')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCasesCAAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Dismissed Cases Based on Comprise Agreement')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCasesCAAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Dismissed Cases Based on Comprise Agreement')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCasesCAAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Dismissed Cases Based on Comprise Agreement')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function CaseFiledCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Favorable: Case Filed in Court (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function CaseFiledCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Favorable: Case Filed in Court (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function CaseFiledAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Favorable: Case Filed in Court (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function CaseFiledAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Favorable: Case Filed in Court (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function CaseFiledAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Favorable: Case Filed in Court (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function FavorableDismissedRespondentCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Favorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function FavorableDismissedRespondentCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Favorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function FavorableDismissedRespondentAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Favorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function FavorableDismissedRespondentAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Favorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function FavorableDismissedRespondentAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Favorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function BailCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Bail')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function BailCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Bail')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function BailAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Bail')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function BailAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Bail')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function BailAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Bail')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function RecognizanceCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Recognizance')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function RecognizanceCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Recognizance')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function RecognizanceAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Recognizance')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function RecognizanceAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Recognizance')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function RecognizanceAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Recognizance')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DiversionProceedingCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Diversion Proceedings/Intervention')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DiversionProceedingCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Diversion Proceedings/Intervention')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DiversionProceedingAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Diversion Proceedings/Intervention')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DiversionProceedingAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Diversion Proceedings/Intervention')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DiversionProceedingAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Diversion Proceedings/Intervention')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }
    
    public function SuspenseSentenceCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Suspended Sentence')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function SuspenseSentenceCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Suspended Sentence')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function SuspenseSentenceAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Suspended Sentence')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function SuspenseSentenceAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Suspended Sentence')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function SuspenseSentenceAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Suspended Sentence')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MaximumImposableCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Maximum Imposable Penalty Served')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MaximumImposableCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Maximum Imposable Penalty Served')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MaximumImposableAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Maximum Imposable Penalty Served')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MaximumImposableAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Maximum Imposable Penalty Served')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function MaximumImposableAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Maximum Imposable Penalty Served')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedChargeCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Convicted as Charged')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedChargeCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Convicted as Charged')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedChargeAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Convicted as Charged')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedChargeAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Convicted as Charged')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ConvictedChargeAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Convicted as Charged')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function LostCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Lost')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function LostCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Lost')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function LostAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Lost')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function LostAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Lost')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function LostAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Lost')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCALCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Dismissed (civil, administrative & labor)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCALCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Dismissed (civil, administrative & labor)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCALAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Dismissed (civil, administrative & labor)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCALAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Dismissed (civil, administrative & labor)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function DismissedCALAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Dismissed (civil, administrative & labor)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedComplainantCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Unfavorable: Dismissed (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedComplainantCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Unfavorable: Dismissed (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedComplainantAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Unfavorable: Dismissed (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedComplainantAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Unfavorable: Dismissed (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedComplainantAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Unfavorable: Dismissed (complainant)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedRespondentCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Unfavorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedRespondentCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Unfavorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedRespondentAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Unfavorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedRespondentAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Unfavorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function UnfavorableDismissedRespondentAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Unfavorable: Dismissed (respondent)')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ArchivedCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Archived')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ArchivedCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Archived')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ArchivedAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Archived')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ArchivedAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Archived')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function ArchivedAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Archived')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WithdrawnCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Withdrawn')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WithdrawnCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Withdrawn')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WithdrawnAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Withdrawn')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WithdrawnAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Withdrawn')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function WithdrawnAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Withdrawn')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function TransferredtoPrivateLawyerCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function TransferredtoPrivateLawyerCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function TransferredtoPrivateLawyerAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function TransferredtoPrivateLawyerAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function TransferredtoPrivateLawyerAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingInvestigationCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingInvestigationCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingInvestigationAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingInvestigationAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingInvestigationAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function receivedInvestigationCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedInvestigationCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedInvestigationAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedInvestigationAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function receivedInvestigationAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.transfer_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferInvestigationCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferInvestigationCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferInvestigationAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferInvestigationAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function transferInvestigationAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('case_transfer')
            ->join('cases', 'case_transfer.case_no', '=', 'cases.case_no')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('case_transfer.assigned_to', $request['name'])
            ->count();

        return $results;
    }

    public function CaseFiledInvestigation(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Favorable: Case Filed in Court (complainant)')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function terminatedInvestigation(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('client_case_involvement.complaint', 'like', '%' .'R.A 9745 (Anti-Torture Law)'. '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->count();

        return $results;
    }
}
