<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\monthlyInventoryCases;
use App\natureOfTheCase;

class MonthlyInventoryCasesController extends Controller
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
        // $results = DB::table('monthly_inventory_cases')->select('id', 'section' ,'item_no', 'control_no', 'party_represented', 'gender', 'title_case', 'court_body', 'case_no', 'cause_action', 'status_case', 'last_action_taken', 'cause_termination', 'date_termination')->where('user_id', auth('api')->user()->id)->get();
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
            if (monthlyInventoryCases::where('id', $request['report'][$i]['id'])->exists()) {
                $monthlyInventoryCases = monthlyInventoryCases::find($request['report'][$i]['id']);
                $monthlyInventoryCases->name = $request['report'][$i]['client_name'];
                $monthlyInventoryCases->address = $request['report'][$i]['client_address'];
                $monthlyInventoryCases->age = $request['report'][$i]['client_age'];
                $monthlyInventoryCases->gender = $request['report'][$i]['client_gender'];
                $monthlyInventoryCases->contact_no = $request['report'][$i]['client_contact'];
                $monthlyInventoryCases->email = $request['report'][$i]['client_email'];
                $monthlyInventoryCases->class = $request['report'][$i]['class'];
                $monthlyInventoryCases->cicl = $request['report'][$i]['children_in_conflict'];
                $monthlyInventoryCases->indigenous_group = $request['report'][$i]['indigenous_group'];
                $monthlyInventoryCases->pwd = $request['report'][$i]['person_with_disability'];
                $monthlyInventoryCases->urban = $request['report'][$i]['urban_poor'];
                $monthlyInventoryCases->rural = $request['report'][$i]['rural_poor'];
                $monthlyInventoryCases->ofw = $request['report'][$i]['ofw'];
                $monthlyInventoryCases->judicial = $request['report'][$i]['judicial'];
                $monthlyInventoryCases->quasi_judicial = $request['report'][$i]['quasi_judicial'];
                $monthlyInventoryCases->non_judicial = $request['report'][$i]['non_judicial'];
                $monthlyInventoryCases->action_taken = $request['report'][$i]['action_taken'];
                $monthlyInventoryCases->title_of_the_case = $request['report'][$i]['case_title'];
                $monthlyInventoryCases->case_no = $request['report'][$i]['case_no'];
                $monthlyInventoryCases->case_status = $request['report'][$i]['status'];
                $monthlyInventoryCases->nature_case = $request['report'][$i]['nature_case'];
                $monthlyInventoryCases->save();
            } else {
                if ($request['report'][$i]['client_name'] !== null || $request['report'][$i]['client_address'] !== null ||
                $request['report'][$i]['client_age'] !== null || $request['report'][$i]['client_gender'] !== null ||
                $request['report'][$i]['client_contact'] !== null || $request['report'][$i]['client_email'] !== null ||
                 $request['report'][$i]['class'] !== null || $request['report'][$i]['children_in_conflict'] !== null ||
                  $request['report'][$i]['indigenous_group'] !== null || $request['report'][$i]['indigenous_group'] !== null || $request['report'][$i]['person_with_disability'] !== null
                  || $request['report'][$i]['urban_poor'] !== null || $request['report'][$i]['rural_poor'] !== null || $request['report'][$i]['ofw'] !== null
                  || $request['report'][$i]['judicial'] !== null || $request['report'][$i]['quasi_judicial'] !== null || $request['report'][$i]['non_judicial'] !== null
                  || $request['report'][$i]['action_taken'] !== null || $request['report'][$i]['case_title'] !== null || $request['report'][$i]['case_no'] !== null
                  || $request['report'][$i]['status'] !== null || $request['report'][$i]['nature_case'] !== null
                  ) {
                    $monthlyInventoryCases = new monthlyInventoryCases;
                    $monthlyInventoryCases->attorney = $request['report'][$i]['attorney'];
                    $monthlyInventoryCases->control_num = $request['report'][$i]['control_num'];
                    $monthlyInventoryCases->name = $request['report'][$i]['client_name'];
                    $monthlyInventoryCases->address = $request['report'][$i]['client_address'];
                    $monthlyInventoryCases->age = $request['report'][$i]['client_age'];
                    $monthlyInventoryCases->gender = $request['report'][$i]['client_gender'];
                    $monthlyInventoryCases->contact_no = $request['report'][$i]['client_contact'];
                    $monthlyInventoryCases->email = $request['report'][$i]['client_email'];
                    $monthlyInventoryCases->class = $request['report'][$i]['class'];
                    $monthlyInventoryCases->cicl = $request['report'][$i]['children_in_conflict'];
                    $monthlyInventoryCases->indigenous_group = $request['report'][$i]['indigenous_group'];
                    $monthlyInventoryCases->pwd = $request['report'][$i]['person_with_disability'];
                    $monthlyInventoryCases->urban = $request['report'][$i]['urban_poor'];
                    $monthlyInventoryCases->rural = $request['report'][$i]['rural_poor'];
                    $monthlyInventoryCases->ofw = $request['report'][$i]['ofw'];
                    $monthlyInventoryCases->judicial = $request['report'][$i]['judicial'];
                    $monthlyInventoryCases->quasi_judicial = $request['report'][$i]['quasi_judicial'];
                    $monthlyInventoryCases->non_judicial = $request['report'][$i]['non_judicial'];
                    $monthlyInventoryCases->action_taken = $request['report'][$i]['action_taken'];
                    $monthlyInventoryCases->title_of_the_case = $request['report'][$i]['case_title'];
                    $monthlyInventoryCases->case_no = $request['report'][$i]['case_no'];
                    $monthlyInventoryCases->case_status = $request['report'][$i]['status'];
                    $monthlyInventoryCases->nature_case = $request['report'][$i]['nature_case'];
                    $monthlyInventoryCases->save();
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
            ->join('client_classification', 'client_profile.control_num', '=', 'client_classification.control_num')
            ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
            ->leftJoin('cases', 'client_profile.control_num', '=', 'cases.control_num')
            ->leftJoin('monthly_inventory_cases', 'nature_of_the_case.control_num', '=', 'monthly_inventory_cases.control_num')
            ->select('monthly_inventory_cases.id', 'monthly_inventory_cases.attorney', 'monthly_inventory_cases.judicial', 'monthly_inventory_cases.quasi_judicial', 'monthly_inventory_cases.non_judicial', 'monthly_inventory_cases.action_taken', 'client_profile.control_num', 'client_profile.client_name', 'client_profile.client_address', 'client_profile.client_age', 'client_profile.client_gender', 'client_profile.client_contact', 'client_profile.client_email','client_classification.class', 'client_classification.children_in_conflict', 'client_classification.indigenous_group', 'client_classification.person_with_disability', 'client_classification.urban_poor', 'client_classification.rural_poor', 'client_classification.ofw', 'cases.case_title', 'cases.status', 'cases.case_no', 'nature_of_the_case.nature_case')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('client_profile.created_at', 'like', '%' . $date . '%')
            ->get();
        return $results;
    }

    public function Criminal(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
        $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
            ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
            ->leftJoin('hearing', 'cases.case_no', '=', 'hearing.case_no')
            ->select('cases.id', 'cases.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'cases.case_title', 'cases.court', 'cases.case_no', 'additional_information_case.case_of_action', 'cases.case_summary', 'cases.status', 'cases.updated_at')
            ->where('nature_of_the_case.nature_case', 'Criminal')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->distinct('cases.control_num')->get();

        return $results;
    }

    public function Civil(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
        $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
            ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
            ->leftJoin('hearing', 'cases.case_no', '=', 'hearing.case_no')
            ->select('cases.id', 'cases.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'cases.case_title', 'cases.court', 'cases.case_no', 'additional_information_case.case_of_action', 'cases.case_summary', 'cases.status', 'cases.updated_at')
            ->where('nature_of_the_case.nature_case', 'Civil')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->distinct('cases.control_num')->get();

        return $results;
    }

    public function Labor(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
        $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
            ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
            ->leftJoin('hearing', 'cases.case_no', '=', 'hearing.case_no')
            ->select('cases.id', 'cases.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'cases.case_title', 'cases.court', 'cases.case_no', 'additional_information_case.case_of_action', 'cases.case_summary', 'cases.status', 'cases.updated_at')
            ->where('nature_of_the_case.nature_case', 'Labor')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->distinct('cases.control_num')->get();

        return $results;
    }

    public function Adm(Request $request)
    {
        $date = date('Y-m', strtotime($request['date']));
        $results = DB::table('cases')
            ->join('client_profile', 'cases.control_num', '=', 'client_profile.control_num')
            ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
            ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
            ->leftJoin('hearing', 'cases.case_no', '=', 'hearing.case_no')
            ->select('cases.id', 'cases.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'cases.case_title', 'cases.court', 'cases.case_no', 'additional_information_case.case_of_action', 'cases.case_summary', 'cases.status', 'cases.updated_at')
            ->where('nature_of_the_case.nature_case', 'Administrative Case Proper')
            ->where('cases.assigned_to', $request['name'])
            ->where('cases.created_at', 'like', '%' . $date . '%')
            ->distinct('cases.control_num')->get();

        return $results;
    }
}
