<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\listDetaineesRepresentedCourt;
use App\clientProfile;

class ListDetaineesRepresentedCourtController extends Controller
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

            // $results = DB::table('client_profile')
            // ->leftJoin('list_detainees_represented_court', 'client_profile.control_num', '=', 'list_detainees_represented_court.control_num')
            // ->select('list_detainees_represented_court.id', 'list_detainees_represented_court.attorney', 'client_profile.control_num', 'list_detainees_represented_court.item_no', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.detention_place', 'list_detainees_represented_court.court', 'list_detainees_represented_court.case_no', 'list_detainees_represented_court.offense', 'list_detainees_represented_court.status', 'list_detainees_represented_court.report_month')->get();
            //  return $results;
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
            if (listDetaineesRepresentedCourt::where('id', $request['report'][$i]['id'])->exists()) {
                $listDetaineesRepresentedCourt = listDetaineesRepresentedCourt::find($request['report'][$i]['id']);
                $listDetaineesRepresentedCourt->item_no = $request['report'][$i]['item_no'];
                $listDetaineesRepresentedCourt->name = $request['report'][$i]['client_name'];
                $listDetaineesRepresentedCourt->gender = $request['report'][$i]['client_gender'];
                $listDetaineesRepresentedCourt->place_detention = $request['report'][$i]['detention_place'];
                $listDetaineesRepresentedCourt->court = $request['report'][$i]['court'];
                $listDetaineesRepresentedCourt->case_no = $request['report'][$i]['case_no'];
                $listDetaineesRepresentedCourt->offense = $request['report'][$i]['offense'];
                $listDetaineesRepresentedCourt->status = $request['report'][$i]['status'];
                $listDetaineesRepresentedCourt->save();
            } else {
                if ($request['report'][$i]['item_no'] !== null || $request['report'][$i]['client_name'] !== null || $request['report'][$i]['client_gender'] !== null || $request['report'][$i]['detention_place'] !== null || $request['report'][$i]['court'] !== null || $request['report'][$i]['case_no'] !== null || $request['report'][$i]['offense'] !== null || $request['report'][$i]['status'] !== null) {
                    $listDetaineesRepresentedCourt = new listDetaineesRepresentedCourt;
                    $listDetaineesRepresentedCourt->attorney = $request['report'][$i]['attorney'];
                    $listDetaineesRepresentedCourt->control_num = $request['report'][$i]['control_num'];
                    $listDetaineesRepresentedCourt->item_no = $request['report'][$i]['item_no'];
                    $listDetaineesRepresentedCourt->name = $request['report'][$i]['client_name'];
                    $listDetaineesRepresentedCourt->gender = $request['report'][$i]['client_gender'];
                    $listDetaineesRepresentedCourt->place_detention = $request['report'][$i]['detention_place'];
                    $listDetaineesRepresentedCourt->court = $request['report'][$i]['court'];
                    $listDetaineesRepresentedCourt->case_no = $request['report'][$i]['case_no'];
                    $listDetaineesRepresentedCourt->offense = $request['report'][$i]['offense'];
                    $listDetaineesRepresentedCourt->status = $request['report'][$i]['status'];
                    $listDetaineesRepresentedCourt->save();
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
            ->leftJoin('list_detainees_represented_court', 'client_profile.control_num', '=', 'list_detainees_represented_court.control_num')
            ->select('list_detainees_represented_court.id', 'list_detainees_represented_court.attorney', 'client_profile.control_num', 'list_detainees_represented_court.item_no', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.detention_place', 'list_detainees_represented_court.court', 'list_detainees_represented_court.case_no', 'list_detainees_represented_court.offense', 'list_detainees_represented_court.status', 'list_detainees_represented_court.report_month')
            ->whereNotNull('client_profile.detention_place')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('client_profile.created_at', 'like', '%' . $date . '%')
            ->get();
        return $results;
    }
}
