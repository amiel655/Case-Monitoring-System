<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Event;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class CalendarController extends Controller
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
        $events = DB::table('calendar')->select('id', 'title', 'color', 'start_date', 'end_date', 'case_no', 'control_num')->where('user_id', auth('api')->user()->id)->where('start_date', '!=', null)->where('end_date', '!=', null)->get();
        return $events;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $events = new Event;
        $events->user_id = auth()->user()->id;
        $events->title = $request['title'];
        $events->color = $request['color'];
        $events->start_date = new \DateTime($request['start_date']);
        $events->end_date = new \DateTime($request['end_date']);
        $events->save();
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
        $event = Event::findorFail($id);
        $event = $event->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
    }

    public function updateHearingDate(Request $request, $id)
    {
        $calendar = DB::table('calendar')->where('id', $id)
            ->update([
                'user_id' => $request['user_id'],
                'case_no' => $request['case_no'],
                'title' => $request['title'],
                'start_date' => $request['hearing_date'],
                'end_date' => $request['hearing_date']
            ]);
    }
}
