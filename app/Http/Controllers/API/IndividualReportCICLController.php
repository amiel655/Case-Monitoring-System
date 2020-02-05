<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\individualReportCICL;

class IndividualReportCICLController extends Controller
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
        //$results = DB::table('individual_report_cicl')->select('id', 'section', 'key_indicators_of_performance', 'total', 'cr', 'cv', 'adm1', 'adm2', 'adm3')->where('user_id', auth('api')->user()->id)->get();
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
        for ($i = 0; $i < 375; $i++) {
            if (individualReportCICL::where('id', $request[$i]['item'])->exists()) {
                $individualReportCICL = individualReportCICL::find($request[$i]['item']);
                $individualReportCICL->total = $request[$i]['total'];
                $individualReportCICL->cr = $request[$i]['cr'];
                $individualReportCICL->cv = $request[$i]['cv'];
                $individualReportCICL->adm1 = $request[$i]['adm1'];
                $individualReportCICL->adm2 = $request[$i]['adm2'];
                $individualReportCICL->adm3 = $request[$i]['adm3'];
                $individualReportCICL->save();
            } else {
                if ($request[$i]['total'] !== null || $request[$i]['cr'] !== null || $request[$i]['cv'] !== null || $request[$i]['adm1'] !== null || $request[$i]['adm2'] !== null || $request[$i]['adm3'] !== null) {
                    $individualReportCICL = new individualReportCICL;
                    $individualReportCICL->attorney = $request[$i]['atty'];
                    $individualReportCICL->report_month = $request[$i]['report_month'];
                    $individualReportCICL->section = $request[$i]['section'];
                    $individualReportCICL->key_indicators_of_performance = $request[$i]['key_indicators_of_performance'];
                    if ($request[$i]['title'] === 'TOTAL NO. OF INAMTES SERVED/RELEASED' || $request[$i]['title'] === 'TOTAL NUMBER OF CLIENTS ASSISTED' || $request[$i]['title'] === 'TOTAL NUMBER OF REQUEST FOR LEGAL ASSISTANCE/REPRESENTATION ACTED UPON WITHIN 3 WORKING DAYS (JUDICAL)' || $request[$i]['title'] === 'TOTAL NUMBER OF REQUEST FOR ASSISTANCE ACTED UPON WITHIN 2 HOURS (NON-JUDICIAL)' || $request[$i]['title'] === 'TOTAL NUMBER OF SCHEDULED HEARINGS (JUDICIAL & QUASI-JUDICIAL)' || $request[$i]['title'] === 'TOTAL NUMBER OF POSTPONEMENTS SOUGHT BY PUBLIC ATTORNEY (JUDICIAL & QUASI-JUDICIAL)') {
                        $individualReportCICL->key_indicators_of_performance = $request[$i]['title'];
                    }
                    $individualReportCICL->total = $request[$i]['total'];
                    $individualReportCICL->cr = $request[$i]['cr'];
                    $individualReportCICL->cv = $request[$i]['cv'];
                    $individualReportCICL->adm1 = $request[$i]['adm1'];
                    $individualReportCICL->adm2 = $request[$i]['adm2'];
                    $individualReportCICL->adm3 = $request[$i]['adm3'];
                    $individualReportCICL->save();
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
        //$date = date('Y-m', strtotime($request['date']));
        $results = DB::table('individual_report_cicl')->select('id', 'section', 'key_indicators_of_performance', 'total', 'cr', 'cv', 'adm1', 'adm2', 'adm3')
            ->where('attorney', $request['name'])
        //->where('created_at', 'like', '%' . $date . '%')
            ->where('report_month', $request['date'])
            ->get();
        return $results;
    }

    public function pendingCICLCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCICLCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCICLAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCICLAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCICLAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableCICL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableCICL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherCICL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsCICL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                    Indigenous Group
    --------------------------------------------------*/

    public function pendingIndigenousGroupCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingIndigenousGroupCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingIndigenousGroupAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingIndigenousGroupAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingIndigenousGroupAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableIndigenousGroup(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableIndigenousGroup(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherIndigenousGroup(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsIndigenousGroup(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->whereNotNull('client_classification.indigenous_group')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                        PWD
    --------------------------------------------------*/

    public function pendingPWDCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingPWDCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingPWDAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingPWDAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingPWDAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorablePWD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorablePWD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherPWD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsPWD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->whereNotNull('client_classification.person_with_disability')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                        Urban Poor
    --------------------------------------------------*/

    public function pendingUPCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingUPCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingUPAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingUPAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingUPAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableUP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableUP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherUP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->whereNotNull('client_classification.urban_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsUP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->whereNotNull('client_classification.urban_poor')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                        Rural Poor
    --------------------------------------------------*/

    public function pendingRPCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRPCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRPAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRPAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRPAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableRP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableRP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherRP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->whereNotNull('client_classification.rural_poor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsRP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->whereNotNull('client_classification.rural_poor')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                        OFW LAND
    --------------------------------------------------*/

    public function pendingOFWLCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWLCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWLAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWLAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWLAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableOFWL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableOFWL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherOFWL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_classification.ofw', 'Land-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsOFWL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_classification.ofw', 'Land-based')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                        OFW SEA
    --------------------------------------------------*/

    public function pendingOFWSCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWSCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWSAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWSAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingOFWSAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableOFWS(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableOFWS(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherOFWS(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsOFWS(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_classification.ofw', 'Sea-based')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                    Senior Citizen
    --------------------------------------------------*/

    public function pendingSCCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingSCCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingSCAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingSCAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingSCAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableSC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableSC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherSC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsSC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_classification.class', 'like','%' . 'Senior Citizen' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                   Human Security Act
    --------------------------------------------------*/

    public function pendingHSACriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingHSACivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingHSAAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingHSAAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingHSAAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableHSA(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableHSA(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherHSA(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsHSA(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_case_involvement', 'control_reference_and_nature_of_request.control_num', '=', 'client_case_involvement.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9372 (Human Security Act)' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                   Anti Torture Law
    --------------------------------------------------*/

    public function pendingATLCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATLCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATLAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATLAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATLAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableATL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableATL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherATL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsATL(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_case_involvement', 'control_reference_and_nature_of_request.control_num', '=', 'client_case_involvement.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9745 (Anti-Torture Law)' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                   Rape Victim
    --------------------------------------------------*/

    public function pendingRVCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRVCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRVAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRVAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRVAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableRV(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableRV(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherRV(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsRV(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('nature_of_the_case', 'control_reference_and_nature_of_request.control_num', '=', 'nature_of_the_case.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('nature_of_the_case.nature_specify_case', 'like','%' . 'Rape' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                Anti Trafficking in Person
    --------------------------------------------------*/

    public function pendingATIPCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATIPCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATIPAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATIPAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingATIPAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableATIP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableATIP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherATIP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsATIP(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_case_involvement', 'control_reference_and_nature_of_request.control_num', '=', 'client_case_involvement.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9208' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                Anti Trafficking in Person
    --------------------------------------------------*/

    public function pendingCDDCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCDDCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCDDAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCDDAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingCDDAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableCDD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableCDD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherCDD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsCDD(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_case_involvement', 'control_reference_and_nature_of_request.control_num', '=', 'client_case_involvement.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9165' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                Agrarian Case
    --------------------------------------------------*/

    public function pendingACCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingACCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingACAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingACAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingACAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableAC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableAC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherAC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsAC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_case_involvement', 'control_reference_and_nature_of_request.control_num', '=', 'client_case_involvement.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_case_involvement.complaint', 'like','%' . 'Agrarian Case' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                    Refugee/Evacuee
    --------------------------------------------------*/

    public function pendingRECriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingRECivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingREAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingREAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingREAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_classification', 'nature_of_the_case.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableRE(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableRE(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherRE(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsRE(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_classification.class', 'like','%' . 'Refugees/Evacuees' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                    Citizenship
    --------------------------------------------------*/

    public function pendingNFCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingNFCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingNFAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingNFAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingNFAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function favorableNF(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function unfavorableNF(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Archived')
            ->where('cases.status', '!=','Withdrawn')
            ->where('cases.status', '!=','Transferred to Private Lawyer, IBP, etc.')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function otherNF(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('cases.status', '!=','Acquitted')
            ->where('cases.status', '!=','Dismissed with Prejudice')
            ->where('cases.status', '!=','Motion to Quash Granted')
            ->where('cases.status', '!=','Demurrer to Evidence Granted')
            ->where('cases.status', '!=','Provisionally Dismissed')
            ->where('cases.status', '!=','Convicted to Lesser Offense')
            ->where('cases.status', '!=','Probation Granted')
            ->where('cases.status', '!=','Won')
            ->where('cases.status', '!=','Granted Lesser Award')
            ->where('cases.status', '!=','Dismissed Cases Based on Comprise Agreement')
            ->where('cases.status', '!=','Dismissed (respondent)')
            ->where('cases.status', '!=','Bail')
            ->where('cases.status', '!=','Recognizance')
            ->where('cases.status', '!=','Diversion Proceedings/Intervention')
            ->where('cases.status', '!=','Suspended Sentence')
            ->where('cases.status', '!=','Maximum Imposable Penalty Served')
            ->where('cases.status', '!=','Case Filed in Court (complainant)')
            ->where('cases.status', '!=','Convicted as Charged')
            ->where('cases.status', '!=','Lost')
            ->where('cases.status', '!=','Dismissed (civil, administrative & labor)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (complainant)')
            ->where('cases.status', '!=','Unfavorable: Dismissed (respondent)')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsNF(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_profile', 'control_reference_and_nature_of_request.control_num', '=', 'client_profile.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_profile.client_citizenship', 'Philippine, Filipino')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                VAWC Women
    --------------------------------------------------*/

    public function pendingVWCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->where('client_classification.class', 'like', '%' . 'Women Client' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVWCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->where('client_classification.class', 'like', '%' . 'Women Client' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVWAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->where('client_classification.class', 'like', '%' . 'Women Client' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVWAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->where('client_classification.class', 'like', '%' . 'Women Client' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVWAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->where('client_classification.class', 'like', '%' . 'Women Client' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }


    public function terminatedVW(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->where('client_classification.class', 'like', '%' . 'Women Client' . '%')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsVW(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_case_involvement', 'control_reference_and_nature_of_request.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->where('client_classification.class', 'like', '%' . 'Women Client' . '%')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    /*------------------------------------------------
                VAWC Women
    --------------------------------------------------*/

    public function pendingVCCriminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

        $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVCCivil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVCAdm1(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
            
            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVCAdm2(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Prosecutor Office')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }

    public function pendingVCAdm3(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('nature_of_the_case', 'cases.control_num', '=', 'nature_of_the_case.control_num')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.status', 'Pending')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->count();

        return $results;
    }


    public function terminatedVC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('cases')
            ->join('client_case_involvement', 'cases.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'cases.control_num', '=', 'client_classification.control_num')
            ->where('cases.status', '!=','Pending')
            ->where('cases.status', '!=','Arraignment')
            ->where('cases.status', '!=','Pre-Trial')
            ->where('cases.status', '!=','Prosecution Evidence')
            ->where('cases.status', '!=','Defense Evidence')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }

    public function oathsVC(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));

            $results = DB::table('control_reference_and_nature_of_request')
            ->join('client_case_involvement', 'control_reference_and_nature_of_request.control_num', '=', 'client_case_involvement.control_num')
            ->join('client_classification', 'control_reference_and_nature_of_request.control_num', '=', 'client_classification.control_num')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.status', 'Finished')
            ->where('client_case_involvement.complaint', 'like','%' . 'R.A 9262 (VAWC)' . '%')
            ->whereNotNull('client_classification.children_in_conflict')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('control_reference_and_nature_of_request.created_at', 'like', '%' . $date . '%')

            ->count();

        return $results;
    }
}
