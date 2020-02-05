<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Hearing;
use App\Event;

class HearingController extends Controller
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
        //
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
        $arr = explode(',', $id);
        $dates = array_diff($arr, [$arr[0], $arr[1], $arr[2]]);
        $arrDate = array_values((array)$dates);
        $find = [];
        $ids = [];

        foreach($arrDate as $i) {
            $date = Event::where('case_no', $arr[1])->where('title', $arr[2])->where('start_date', $i)->where('end_date', $i)->select('id')->first();
            if(is_object($date)) {
                $calendar = Event::where('id', $date->id)
                    ->update([
                        'title' => $request['case_title'],
                        'start_date' => $request['hearing_date'],
                        'end_date' => $request['hearing_date']
                    ]);
            }
        }

        $hearing = DB::table('hearing')->where('id', $arr[0])
        ->update([
            'case_status' => $request['case_status'],
            'hearing_date' => $request['hearing_date'],
            'case_summary' => $request['case_summary']
        ]);








    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $arr = explode(',', $id);

        $hearing = Hearing::findOrFail($arr[0]);
        $hearing->delete();

        $calendar = Event::where('case_no', '=', $arr[1])->where('start_date', '=', $arr[2])->where('end_date', '=', $arr[2]);
        $calendar->delete();
    }
}
