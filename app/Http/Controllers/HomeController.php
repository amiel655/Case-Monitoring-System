<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hearing;
use Carbon\Carbon;
use App\Notifications\HearingIsNear;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hearings = Hearing::where('user_id', auth()->user()->id)->get();
        for ($i = 0; $i < count($hearings); $i++) {
            $control_num = DB::table('cases')->where('case_no', '=', $hearings[$i]['case_no'])->select('control_num')->first();
            $dataString = (object) ['hearing_date' => $hearings[$i]['hearing_date'], 'control_num' => $control_num->control_num];
            $date = new Carbon($hearings[$i]['hearing_date']);
            $subtracted_date = $date->subDays(1);
            $present_date = Carbon::now();
            $checkRecord = DB::table('notifications')->where('data', '=', json_encode($dataString))->where('notifiable_id', '=', auth()->user()->id)->first();
            if($checkRecord === null) {
                if ($subtracted_date->format('Y-m-d') === $present_date->format('Y-m-d')) {
                    auth()->user()->notify(new HearingIsNear($hearings[$i]['hearing_date'], $control_num->control_num));
                }
            }
        }
            return view('dashboard');

    }

}
