<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\clientProfile;
use App\natureRequest;
use App\intervieweePersonalCircumstances;
use App\natureOfTheCase;
use App\clientCaseInvolvement;
use App\clientClassification;
use App\additionalInformationCase;
use App\proofIndigency;
use App\Cases;
use App\Event;
use App\User;
use App\Notifications\TransferClient;
use Notification;
use Illuminate\Notifications\Notifiable;

class ClientsController extends Controller
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
        if(auth('api')->user()->type === 'Super Admin' || auth('api')->user()->type === 'Staff') {
            $results = DB::table('client_profile')
            ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
            ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
            ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact', 'client_profile.client_religion', 'client_profile.client_citizenship', 'client_profile.client_address', 'client_profile.client_email', 'client_profile.client_monthly_income', 'client_profile.detained', 'client_profile.detained_since', 'client_profile.client_age', 'client_profile.client_civil_status', 'client_profile.client_educational_attainment', 'client_profile.client_dialect', 'client_profile.client_spouse', 'client_profile.spouse_address', 'client_profile.spouse_contact', 'client_profile.detention_place', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at', 'proof_of_indigency.proof_of_indigency', 'control_reference_and_nature_of_request.status')
            ->latest()->paginate(10);
            $id = Cases::all()->pluck('control_num')->all();
            $cases = Cases::select('control_num', 'status')->get();
            $clientControlNum = DB::table('client_profile')->whereNotIn('control_num', $id)->select('control_num')->orderBy('created_at', 'DESC')->get();

            return [$results, $clientControlNum, $cases];
        }

        if (auth('api')->user()->type === 'Admin') {
            $results = DB::table('client_profile')
                ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
                ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at', 'proof_of_indigency.proof_of_indigency', 'control_reference_and_nature_of_request.status')
                ->where('control_reference_and_nature_of_request.assigned_to', '=', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)
                ->latest()->paginate(10);
            $id = Cases::all()->pluck('control_num')->all();
            $cases = Cases::select('control_num', 'status')->where('assigned_to', auth('api')->user()->firstname . ' ' . auth('api')->user()->lastname)->get();
            $clientControlNum = DB::table('client_profile')->whereNotIn('control_num', $id)->select('control_num')->orderBy('created_at', 'DESC')->get();

            return [$results, $clientControlNum, $cases];
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
        $results = DB::table('client_profile')
        ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
        ->join('interviewee_personal_circumstances', 'client_profile.control_num', '=', 'interviewee_personal_circumstances.control_num')
        ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
        ->join('client_case_involvement', 'client_profile.control_num', '=', 'client_case_involvement.control_num')
        ->join('client_classification', 'client_profile.control_num', '=', 'client_classification.control_num')
        ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
        ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
        ->select('client_profile.*', 'control_reference_and_nature_of_request.*', 'interviewee_personal_circumstances.*', 'nature_of_the_case.*', 'client_case_involvement.*', 'client_classification.*', 'additional_information_case.*', 'proof_of_indigency.*')
        ->where('client_profile.control_num', '=', $id)->get();
        $id = Cases::all()->pluck('control_num')->all();
        $clientControlNum = DB::table('client_profile')->whereNotIn('control_num', $id)->select('control_num')->orderBy('created_at', 'DESC')->get();
        return [$results, $clientControlNum];
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
        // STEP 1
        $natureRequest = DB::table('control_reference_and_nature_of_request')->where('control_num', $id)
            ->update([
                'interviewer' => $request['interviewer'],
                'assigned_to' => $request['assigned_to'],
                'referred_by' => $request['referred_by'],
                'refer_to' => $request['refer_to'],
                'nature_request' => $request['nature_request']
            ]);

            if($request['assigned_to'] !== $request['assigned_from']) {
            $assigned_to = User::where(DB::raw('CONCAT(firstname, " ", lastname)'), 'LIKE', '%' . $request['assigned_to'] . '%')->get();
            $assigned_from = User::where(DB::raw('CONCAT(firstname, " ", lastname)'), 'LIKE', '%' . $request['assigned_from'] . '%')->get();
            $assigned_to[0]->notify(new TransferClient($request['control_num'], $request['assigned_from'], $request['assigned_to'], $assigned_from[0]['image']));
            $assigned_from[0]->notify(new TransferClient($request['control_num'], $request['assigned_from'], $request['assigned_to'], $assigned_to[0]['image']));
        }

        $natureCase = DB::table('nature_of_the_case')->where('control_num', $id)
            ->update([
                'nature_case' => $request['nature_case'],
                'nature_specify_case' => $request['nature_specify_case']
            ]);

        $clientProfile = DB::table('client_profile')->where('control_num', $id)
            ->update([
                'client_name' => $request['client_name'],
                'client_religion' => $request['client_religion'],
                'client_citizenship' => $request['client_citizenship'],
                'client_email' => $request['client_email'],
                'client_address' => $request['client_address'],
                'client_monthly_income' => $request['client_monthly_income'],
                'detained' => $request['detained'],
                'detained_since' => $request['detained_since'],
                'client_age' => $request['client_age'],
                'client_gender' => $request['client_gender'],
                'client_civil_status' => $request['client_civil_status'],
                'client_educational_attainment' => $request['client_educational_attainment'],
                'client_dialect' => implode(',', $request['client_dialect']),
                'client_contact' => $request['client_contact'],
                'client_spouse' => $request['client_spouse'],
                'spouse_address' => $request['spouse_address'],
                'spouse_contact' => $request['spouse_contact'],
                'detention_place' => $request['detention_place'],
            ]);

        $interviewee = DB::table('interviewee_personal_circumstances')->where('control_num', $id)
            ->update([
                'interviewee_name' => $request['interviewee_name'],
                'interviewee_address' => $request['interviewee_address'],
                'interviewee_relationship_to_client' => $request['interviewee_relationship_to_client'],
                'interviewee_age' => $request['interviewee_age'],
                'interviewee_gender' => $request['interviewee_gender'],
                'interviewee_civil_status' => $request['interviewee_civil_status'],
                'interviewee_contact' => $request['interviewee_contact'],
                'interviewee_email' => $request['client_age']
            ]);

        $caseInvolvement = DB::table('client_case_involvement')->where('control_num', $id)
            ->update([
                'involvement' => $request['involvement'],
                'complaint' => implode(',', $request['complaint'])
            ]);

        $clientClassification = DB::table('client_classification')->where('control_num', $id)
            ->update([
                'class' => implode(',', $request['class']),
                'children_in_conflict' => $request['children_in_conflict'],
                'indigenous_group' => $request['indigenous_group'],
                'person_with_disability' => $request['person_with_disability'],
                'urban_poor' => $request['urban_poor'],
                'rural_poor' => $request['rural_poor'],
                'ofw' => $request['ofw'],
            ]);

        $additionalInformation = DB::table('additional_information_case')->where('control_num', $id)
            ->update([
                'adverse_party' => $request['adverse_party'],
                'adverse_party_name' => $request['adverse_party_name'],
                'adverse_party_address' => $request['adverse_party_address'],
                'fact_of_the_case' => $request['fact_of_the_case'],
                'case_of_action' => $request['case_of_action'],
                'pending_in_court' => $request['pending_in_court'],
                'title_of_case' => $request['title_of_case'],
                'court_body_tribunal' => $request['court_body_tribunal'],
                'other_case_of_action' => $request['other_case_of_action'],
                'other_court_body_tribunal' => $request['other_court_body_tribunal'],
            ]);

        $proofIndigency = DB::table('proof_of_indigency')->where('control_num', $id)
            ->update([
                'proof_of_indigency' => implode(',', $request['proof_of_indigency'])
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
        //
    }

    public function search()
    {
        if($search = \Request::get('val')) {
            $clients = DB::table('client_profile')
          ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
        ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_address', 'client_profile.client_contact', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at')->where(function($query) use ($search) {
                $query->where('client_name', 'LIKE', "%$search%")
                ->orWhere('client_address', 'LIKE', "%$search%")
                ->orWhere('client_contact', 'LIKE', "%$search%")
                ->orWhere('nature_request', 'LIKE', "%$search%")
                ->orWhere('assigned_to', 'LIKE', "%$search%");
            })->paginate(10);
        } else {
            $clients = DB::table('client_profile')
          ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
        ->select('client_profile.control_num', 'client_profile.client_name', 'client_profile.client_address', 'client_profile.client_contact', 'control_reference_and_nature_of_request.nature_request', 'control_reference_and_nature_of_request.assigned_to', 'control_reference_and_nature_of_request.created_at')->latest()->paginate(10);
        }
        return $clients;
    }

    public function prepare(Request $request)
    {
        // $this->validate($request, [
        //     'case_no' => 'required|string|unique:cases,case_no,'. $this->id,
        // ]);

        $control = DB::table('control_reference_and_nature_of_request')->where('control_num', $request['control_num'])
        ->update([
            'status' => 'Case'
        ]);

        $cases = new Cases;
        $cases->assigned_to = auth()->user()->firstname.' '.auth()->user()->lastname;
        $cases->control_num = $request['control_num'];
        $cases->case_no = $request['case_no'];
        $cases->case_title = $request['case_title'];
        $cases->court = $request['court'];
        $crimes = array();
        foreach($request['crimes'] as $i) {
            $crimes[] = $i['crime_title'];
        }
        $cases->crime = implode(',', $crimes);

        $cases->detained = $request['detained'];
        $complainants = array();
        foreach($request['complainants'] as $i) {
            $complainants[] = $i['complainant_name'];
        }
        $cases->complainant = implode(',', $complainants);
        $respondents = array();
        foreach($request['respondents'] as $i) {
            $respondents[] = $i['respondent_name'];
        }
        $cases->respondent = implode(',', $respondents);
        $cases->status = "Pending";
        $cases->access_code = str_random(6);
        $cases->access_status = "Disabled";
        $cases->save();

        $events = new Event;
        $events->user_id = auth()->user()->id;
        $events->control_num = $request['control_num'];
        $events->case_no = $request['case_no'];
        $events->title = $request['case_title'];
        $events->color = "#007bff";
        $events->start_date = null;
        $events->end_date = null;
        $events->save();
    }
}
