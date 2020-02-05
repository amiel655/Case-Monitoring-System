<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\listFavorableDecisionDisposition;

class ListFavorableDecisionDispositionController extends Controller
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
        // $results = DB::table('list_favorable_decision_disposition')->select('id', 'name_client', 'case_title', 'docket_no', 'place_detention', 'court', 'nature_case', 'remarks')->where('user_id', auth('api')->user()->id)->get();
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
            if (listFavorableDecisionDisposition::where('id', $request['report'][$i]['id'])->exists()) {
                $listFavorableDecisionDisposition = listFavorableDecisionDisposition::find($request['report'][$i]['id']);
                $listFavorableDecisionDisposition->name_client = $request['report'][$i]['client_name'];
                $listFavorableDecisionDisposition->case_title = $request['report'][$i]['case_title'];
                $listFavorableDecisionDisposition->docket_no = $request['report'][$i]['docket_no'];
                $listFavorableDecisionDisposition->place_detention = $request['report'][$i]['detention_place'];
                $listFavorableDecisionDisposition->court = $request['report'][$i]['court'];
                $listFavorableDecisionDisposition->nature_case = $request['report'][$i]['nature_case'];
                $listFavorableDecisionDisposition->remarks = $request['report'][$i]['remarks'];
                $listFavorableDecisionDisposition->save();
            } else {
                if ($request['report'][$i]['client_name'] !== null || $request['report'][$i]['case_title'] !== null || $request['report'][$i]['docket_no'] !== null || $request['report'][$i]['detention_place'] !== null || $request['report'][$i]['court'] !== null || $request['report'][$i]['nature_case'] !== null || $request['report'][$i]['remarks'] !== null) {
                    $listFavorableDecisionDisposition = new listFavorableDecisionDisposition;
                    $listFavorableDecisionDisposition->attorney = $request['report'][$i]['attorney'];
                    $listFavorableDecisionDisposition->control_num = $request['report'][$i]['control_num'];
                    $listFavorableDecisionDisposition->name_client = $request['report'][$i]['client_name'];
                    $listFavorableDecisionDisposition->case_title = $request['report'][$i]['case_title'];
                    $listFavorableDecisionDisposition->docket_no = $request['report'][$i]['docket_no'];
                    $listFavorableDecisionDisposition->place_detention = $request['report'][$i]['detention_place'];
                    $listFavorableDecisionDisposition->court = $request['report'][$i]['court'];
                    $listFavorableDecisionDisposition->nature_case = $request['report'][$i]['nature_case'];
                    $listFavorableDecisionDisposition->remarks = $request['report'][$i]['remarks'];
                    $listFavorableDecisionDisposition->save();
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

        $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
            ->leftJoin('list_favorable_decision_disposition', 'nature_of_the_case.control_num', '=', 'list_favorable_decision_disposition.control_num')
            ->select('list_favorable_decision_disposition.id', 'list_favorable_decision_disposition.attorney', 'list_favorable_decision_disposition.docket_no', 'list_favorable_decision_disposition.remarks', 'cases.case_title', 'client_profile.control_num', 'client_profile.client_name', 'client_profile.detention_place', 'cases.court', 'nature_of_the_case.nature_case')
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
            ->where('cases.assigned_to', $request['name'])
            ->where('client_profile.created_at', 'like', '%' . $date . '%')
            ->get();
        return $results;
    }
}
