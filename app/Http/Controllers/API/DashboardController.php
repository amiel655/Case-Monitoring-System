<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Hearing;
use App\Cases;

class DashboardController extends Controller
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
        if (auth('api')->user()->type === 'Super Admin') {
            $currentMonth = date('m');
            $montly = DB::table('cases')->select('cases.*')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->latest()->get();
            Carbon::setWeekStartsAt(Carbon::SUNDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);
            $weekly = Cases::whereBetween('created_at', [Carbon::now()->startOfWeek()->format('Y/m/d'), Carbon::now()->endOfWeek()->format('Y/m/d')])->get();

            $presentYear = Cases::whereYear('created_at', date('Y'))->get();
            $pastYear = Cases::whereYear('created_at', date('Y', strtotime('-1 year')))->get();

            $legalAdvice = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Advice')->whereMonth('created_at', Carbon::now()->month)->count();
            $legalDocumentation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Documentation')->whereMonth('created_at', Carbon::now()->month)->count();
            $representation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Representation in Court/Quasi-Judicial Bodies')->whereMonth('created_at', Carbon::now()->month)->count();
            $inquest = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Inquest/Legal Assistance')->whereMonth('created_at', Carbon::now()->month)->count();
            $mediation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Mediation/Concillation')->whereMonth('created_at', Carbon::now()->month)->count();
            $administration = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Administration of Oath')->whereMonth('created_at', Carbon::now()->month)->count();
            $others = DB::table('control_reference_and_nature_of_request')->select('nature_request')
                ->where('nature_request', '!=', 'Legal Advice')
                ->where('nature_request', '!=', 'Legal Documentation')
                ->where('nature_request', '!=', 'Representation in Court/Quasi-Judicial Bodies')
                ->where('nature_request', '!=', 'Inquest/Legal Assistance')
                ->where('nature_request', '!=', 'Mediation/Concillation')
                ->where('nature_request', '!=', 'Administration of Oath')

                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

            $allCrimes = [];
            $crimes = Cases::select('crime')->whereMonth('created_at', Carbon::now()->month)->get();
            for ($i = 0; $i < count($crimes); $i++) {
                $crime = explode(',', $crimes[$i]['crime']);
                array_push($allCrimes, $crime);
            }

            $clientsServed = DB::table('client_profile')
                ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
                ->where('proof_of_indigency.proof_of_indigency', '!=', '')
                ->where('proof_of_indigency.proof_of_indigency', '!=', null)
                ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at', 'proof_of_indigency.proof_of_indigency')
                ->whereYear('client_profile.created_at', date('Y'))->count();

            $users = DB::table('users')->select('users')->count();

            return [$weekly, $montly, $presentYear, $pastYear, $legalAdvice, $legalDocumentation, $representation, $inquest, $mediation, $administration, $others, $allCrimes, $clientsServed, $users];
        }

        if(auth('api')->user()->type === 'Admin') {
            $currentMonth = date('m');
            $montly = DB::table('cases')->select('cases.*')->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->latest()->get();
            Carbon::setWeekStartsAt(Carbon::SUNDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);
            $weekly = Cases::whereBetween('created_at', [Carbon::now()->startOfWeek()->format('Y/m/d'), Carbon::now()->endOfWeek()->format('Y/m/d')])->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();

            $presentYear = Cases::whereYear('created_at', date('Y'))->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();
            $pastYear = Cases::whereYear('created_at', date('Y', strtotime('-1 year')))->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();

            $legalAdvice = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Advice')->whereMonth('created_at', Carbon::now()->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $legalDocumentation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Documentation')->whereMonth('created_at', Carbon::now()->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $representation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Representation in Court/Quasi-Judicial Bodies')->whereMonth('created_at', Carbon::now()->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $inquest = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Inquest/Legal Assistance')->whereMonth('created_at', Carbon::now()->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $mediation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Mediation/Concillation')->whereMonth('created_at', Carbon::now()->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $administration = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Administration of Oath')->whereMonth('created_at', Carbon::now()->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $others = DB::table('control_reference_and_nature_of_request')->select('nature_request')
                ->where('nature_request', '!=', 'Legal Advice')
                ->where('nature_request', '!=', 'Legal Documentation')
                ->where('nature_request', '!=', 'Representation in Court/Quasi-Judicial Bodies')
                ->where('nature_request', '!=', 'Inquest/Legal Assistance')
                ->where('nature_request', '!=', 'Mediation/Concillation')
                ->where('nature_request', '!=', 'Administration of Oath')
                ->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

            $allCrimes = [];
            $crimes = Cases::select('crime')->whereMonth('created_at', Carbon::now()->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();
            for($i = 0; $i < count($crimes); $i++) {
                $crime = explode(',', $crimes[$i]['crime']);
                array_push($allCrimes, $crime);
            }

            $clientsServed = DB::table('client_profile')
                ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
                ->where('proof_of_indigency.proof_of_indigency', '!=', '')
                ->where('proof_of_indigency.proof_of_indigency', '!=', null)
                ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at', 'proof_of_indigency.proof_of_indigency')
                ->where('control_reference_and_nature_of_request.assigned_to', auth('api')->user()->firstname . ' ' . auth('api')->user()->lastname)
                ->whereYear('client_profile.created_at', date('Y'))->count();

            $users = DB::table('users')->select('users')->count();

            return [$weekly, $montly, $presentYear, $pastYear, $legalAdvice, $legalDocumentation, $representation, $inquest, $mediation, $administration, $others, $allCrimes, $clientsServed, $users];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth('api')->user()->type === 'Super Admin') {
            $date = new Carbon($request['date']);
            $montly = DB::table('cases')->select('cases.*')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->latest()->get();
            Carbon::setWeekStartsAt(Carbon::SUNDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);
            $weekly = Cases::whereBetween('created_at', [$date->timezone('UTC')->startOfWeek()->format('Y/m/d'), $date->timezone('UTC')->endOfWeek()->format('Y/m/d')])->get();

            $presentYear = Cases::whereYear('created_at', $date->year)->get();
            $pastYear = Cases::whereYear('created_at', $date->subYear(1))->get();

            $legalAdvice = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Advice')->whereMonth('created_at', $date->month)->count();
            $legalDocumentation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Documentation')->whereMonth('created_at', $date->month)->count();
            $representation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Representation in Court/Quasi-Judicial Bodies')->whereMonth('created_at', $date->month)->count();
            $inquest = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Inquest/Legal Assistance')->whereMonth('created_at', $date->month)->count();
            $mediation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Mediation/Concillation')->whereMonth('created_at', $date->month)->count();
            $administration = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Administration of Oath')->whereMonth('created_at', $date->month)->count();
            $others = DB::table('control_reference_and_nature_of_request')->select('nature_request')
                ->where('nature_request', '!=', 'Legal Advice')
                ->where('nature_request', '!=', 'Legal Documentation')
                ->where('nature_request', '!=', 'Representation in Court/Quasi-Judicial Bodies')
                ->where('nature_request', '!=', 'Inquest/Legal Assistance')
                ->where('nature_request', '!=', 'Mediation/Concillation')
                ->where('nature_request', '!=', 'Administration of Oath')
                ->whereMonth('created_at', $date->month)
                ->count();

            $allCrimes = [];
            $crimes = Cases::select('crime')->whereMonth('created_at', $date->month)->get();
            for ($i = 0; $i < count($crimes); $i++) {
                $crime = explode(',', $crimes[$i]['crime']);
                array_push($allCrimes, $crime);
            }

            $clientsServed = DB::table('client_profile')
                ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
                ->where('proof_of_indigency.proof_of_indigency', '!=', '')
                ->where('proof_of_indigency.proof_of_indigency', '!=', null)
                ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at', 'proof_of_indigency.proof_of_indigency')
                ->whereYear('client_profile.created_at', date('Y'))->count();

            $users = DB::table('users')->select('users')->count();

            return [$weekly, $montly, $presentYear, $pastYear, $legalAdvice, $legalDocumentation, $representation, $inquest, $mediation, $administration, $others, $allCrimes, $clientsServed, $users];
        }

       if(auth('api')->user()->type === 'Admin') {
            $date = new Carbon($request['date']);
            $montly = DB::table('cases')->select('cases.*')->whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->latest()->get();
            Carbon::setWeekStartsAt(Carbon::SUNDAY);
            Carbon::setWeekEndsAt(Carbon::SATURDAY);
            $weekly = Cases::whereBetween('created_at', [$date->timezone('UTC')->startOfWeek()->format('Y/m/d'), $date->timezone('UTC')->endOfWeek()->format('Y/m/d')])->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();

            $presentYear = Cases::whereYear('created_at', $date->year)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();
            $pastYear = Cases::whereYear('created_at', $date->subYear(1))->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();

            $legalAdvice = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Advice')->whereMonth('created_at', $date->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $legalDocumentation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Legal Documentation')->whereMonth('created_at', $date->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $representation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Representation in Court/Quasi-Judicial Bodies')->whereMonth('created_at', $date->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $inquest = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Inquest/Legal Assistance')->whereMonth('created_at', $date->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $mediation = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Mediation/Concillation')->whereMonth('created_at', $date->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $administration = DB::table('control_reference_and_nature_of_request')->select('nature_request')->where('nature_request', '=', 'Administration of Oath')->whereMonth('created_at', $date->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->count();
            $others = DB::table('control_reference_and_nature_of_request')->select('nature_request')
                ->where('nature_request', '!=', 'Legal Advice')
                ->where('nature_request', '!=', 'Legal Documentation')
                ->where('nature_request', '!=', 'Representation in Court/Quasi-Judicial Bodies')
                ->where('nature_request', '!=', 'Inquest/Legal Assistance')
                ->where('nature_request', '!=', 'Mediation/Concillation')
                ->where('nature_request', '!=', 'Administration of Oath')
                ->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)
                ->whereMonth('created_at', $date->month)
                ->count();

            $allCrimes = [];
            $crimes = Cases::select('crime')->whereMonth('created_at', $date->month)->where('assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)->get();
            for ($i = 0; $i < count($crimes); $i++) {
                $crime = explode(',', $crimes[$i]['crime']);
                array_push($allCrimes, $crime);
            }

            $clientsServed = DB::table('client_profile')
                ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
                ->where('proof_of_indigency.proof_of_indigency', '!=', '')
                ->where('proof_of_indigency.proof_of_indigency', '!=', null)
                ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at', 'proof_of_indigency.proof_of_indigency')
                ->where('control_reference_and_nature_of_request.assigned_to', auth('api')->user()->firstname . ' ' . auth('api')->user()->lastname)
                ->whereYear('client_profile.created_at', date('Y'))->count();

            $users = DB::table('users')->select('users')->count();


            return [$weekly, $montly, $presentYear, $pastYear, $legalAdvice, $legalDocumentation, $representation, $inquest, $mediation, $administration, $others, $allCrimes, $clientsServed, $users];
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

    public function markAsReadNotification(Request $request, $id) {
        return auth('api')->user()->unreadNotifications->where('id', $id)->markAsRead();


    }
}
