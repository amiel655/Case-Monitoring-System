<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|string|max:50',
            'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'username' => 'required|string|min:4|max:191|unique:users'
        ]);

        $User = new User;
        $User->firstname = Str::ucfirst($request['firstname']);
        $User->middlename =  Str::ucfirst($request['middlename']);
        $User->lastname =  Str::ucfirst($request['lastname']);
        $User->username = $request['username'];
        $User->gender = $request['gender'];
        $User->type = $request['type'];
        $User->status = $request['status'];
        $User->image = $request['image'];
        $User->password = Hash::make($request['username']);
        $User->save();
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
        $user = User::findorFail($id);

        $this->validate($request, [
            'firstname' => 'required|string|max:50',
            'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'username' => 'required|string|max:191|unique:users,username,'.$user->id,
            'password' => 'sometimes|string|min:8',
        ]);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user = $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $currentImage = $user->image;

        $this->validate($request, [
            'firstname' => 'required|string|max:50',
            'middlename' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'username' => 'required|string|max:191|unique:users,username,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if($request->image !== $currentImage) {
            $name = time().'.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
            Image::make($request->image)->save(public_path('img/profile-picture/').$name);
            $request->merge(['image' => $name]);

            $userImage = public_path('img/profile-picture/').$currentImage;

            if(file_exists($userImage) && $userImage !== public_path('img/profile-picture/profile-placeholder.jpg')){
                @unlink($userImage);
            }
        }

        if(!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        // Updates all tables when user change info
        $cases = DB::table('cases')->where('assigned_to', '=', $user->firstname .' '. $user->lastname)->update([
            'assigned_to' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $control_reference_assigned = DB::table('control_reference_and_nature_of_request')->where('assigned_to', '=', $user->firstname . ' ' . $user->lastname)->update([
            'assigned_to' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $control_reference_interviewer = DB::table('control_reference_and_nature_of_request')->where('interviewer', '=', $user->firstname . ' ' . $user->lastname)->update([
            'interviewer' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $document_notarized = DB::table('document_notarized')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $individual_performance_report = DB::table('individual_performance_report')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $individual_report_cicl = DB::table('individual_report_cicl')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $inquest_report = DB::table('inquest_report')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $list_detainees_represented_court = DB::table('list_detainees_represented_court')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $list_favorable_decision_disposition = DB::table('list_favorable_decision_disposition')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $monthly_inventory_cases = DB::table('monthly_inventory_cases')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $report_victims_cases_handled = DB::table('report_victims_cases_handled')->where('attorney', '=', $user->firstname . ' ' . $user->lastname)->update([
            'attorney' => $request['firstname'] . ' ' . $request['lastname']
        ]);

        $user->update($request->all());

    }

        public function search()
        {
            if(auth('api')->user()->type === 'Super Admin') {
            if ($search = \Request::get('val')) {
                $arr = [];
                $users = User::where(function ($query) use ($search) {
                    $query->where('firstname', 'LIKE', "%$search%")
                        ->orWhere('middlename', 'LIKE', "%$search%")
                        ->orWhere('lastname', 'LIKE', "%$search%")
                        ->orWhere('username', 'LIKE', "%$search%")
                        ->orWhere('type', 'LIKE', "%$search%")
                        ->orWhere('gender', 'LIKE', "%$search%");
                })->get();
                $cases = DB::table('cases')->where(function ($query) use ($search) {
                    $query->where('control_num', 'LIKE', "%$search%")
                        ->orWhere('case_no', 'LIKE', "%$search%")
                        ->orWhere('case_title', 'LIKE', "%$search%")
                        ->orWhere('court', 'LIKE', "%$search%")
                        ->orWhere('crime', 'LIKE', "%$search%")
                        ->orWhere('detained', 'LIKE', "%$search%")
                        ->orWhere('complainant', 'LIKE', "%$search%")
                        ->orWhere('respondent', 'LIKE', "%$search%")
                        ->orWhere('status', 'LIKE', "%$search%")
                        ->orWhere('access_status', 'LIKE', "%$search%");
                })->get();
                $clients = DB::table('client_profile')
                    ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                    ->join('interviewee_personal_circumstances', 'client_profile.control_num', '=', 'interviewee_personal_circumstances.control_num')
                    ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
                    ->join('client_case_involvement', 'client_profile.control_num', '=', 'client_case_involvement.control_num')
                    ->join('client_classification', 'client_profile.control_num', '=', 'client_classification.control_num')
                    ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
                    ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')->where(function ($query) use ($search) {
                        $query->where('client_name', 'LIKE', "%$search%")
                            ->orWhere('client_religion', 'LIKE', "%$search%")
                            ->orWhere('client_citizenship', 'LIKE', "%$search%")
                            ->orWhere('client_address', 'LIKE', "%$search%")
                            ->orWhere('client_email', 'LIKE', "%$search%")
                            ->orWhere('client_monthly_income', 'LIKE', "%$search%")
                            ->orWhere('detained', 'LIKE', "%$search%")
                            ->orWhere('detained_since', 'LIKE', "%$search%")
                            ->orWhere('client_age', 'LIKE', "%$search%")
                            ->orWhere('client_gender', 'LIKE', "%$search%")
                            ->orWhere('client_civil_status', 'LIKE', "%$search%")
                            ->orWhere('client_dialect', 'LIKE', "%$search%")
                            ->orWhere('client_contact', 'LIKE', "%$search%")
                            ->orWhere('client_spouse', 'LIKE', "%$search%")
                            ->orWhere('spouse_address', 'LIKE', "%$search%")
                            ->orWhere('spouse_contact', 'LIKE', "%$search%")
                            ->orWhere('detention_place', 'LIKE', "%$search%")
                            ->orWhere('interviewer', 'LIKE', "%$search%")
                            ->orWhere('assigned_to', 'LIKE', "%$search%")
                            ->orWhere('referred_by', 'LIKE', "%$search%")
                            ->orWhere('refer_to', 'LIKE', "%$search%")
                            ->orWhere('nature_request', 'LIKE', "%$search%")
                            ->orWhere('interviewee_name', 'LIKE', "%$search%")
                            ->orWhere('interviewee_address', 'LIKE', "%$search%")
                            ->orWhere('interviewee_relationship_to_client', 'LIKE', "%$search%")
                            ->orWhere('interviewee_age', 'LIKE', "%$search%")
                            ->orWhere('interviewee_gender', 'LIKE', "%$search%")
                            ->orWhere('interviewee_civil_status', 'LIKE', "%$search%")
                            ->orWhere('interviewee_contact', 'LIKE', "%$search%")
                            ->orWhere('interviewee_email', 'LIKE', "%$search%")
                            ->orWhere('nature_case', 'LIKE', "%$search%")
                            ->orWhere('nature_specify_case', 'LIKE', "%$search%")
                            ->orWhere('involvement', 'LIKE', "%$search%")
                            ->orWhere('complaint', 'LIKE', "%$search%")
                            ->orWhere('class', 'LIKE', "%$search%")
                            ->orWhere('children_in_conflict', 'LIKE', "%$search%")
                            ->orWhere('indigenous_group', 'LIKE', "%$search%")
                            ->orWhere('person_with_disability', 'LIKE', "%$search%")
                            ->orWhere('urban_poor', 'LIKE', "%$search%")
                            ->orWhere('rural_poor', 'LIKE', "%$search%")
                            ->orWhere('ofw', 'LIKE', "%$search%")
                            ->orWhere('adverse_party', 'LIKE', "%$search%")
                            ->orWhere('adverse_party_name', 'LIKE', "%$search%")
                            ->orWhere('fact_of_the_case', 'LIKE', "%$search%")
                            ->orWhere('case_of_action', 'LIKE', "%$search%")
                            ->orWhere('pending_in_court', 'LIKE', "%$search%")
                            ->orWhere('title_of_case', 'LIKE', "%$search%")
                            ->orWhere('court_body_tribunal', 'LIKE', "%$search%")
                            ->orWhere('other_case_of_action', 'LIKE', "%$search%")
                            ->orWhere('other_court_body_tribunal', 'LIKE', "%$search%")
                            ->orWhere('proof_of_indigency', 'LIKE', "%$search%");
                    })->get();
                $hearings = DB::table('hearing')->where(function ($query) use ($search) {
                    $query->where('case_no', 'LIKE', "%$search%")
                        ->orWhere('case_status', 'LIKE', "%$search%")
                        ->orWhere('hearing_date', 'LIKE', "%$search%")
                        ->orWhere('case_Summary', 'LIKE', "%$search%");
                })->get();

                array_push($arr, $users);
                array_push($arr, $cases);
                array_push($arr, $clients);
                array_push($arr, count($users));
                array_push($arr, count($cases));
                array_push($arr, count($clients));
                return $arr;
            } else {
                return [];
            }
            }

            if(auth('api')->user()->type === 'Admin') {
            if ($search = \Request::get('val')) {
                $arr = [];
                $users = [];
                $cases = DB::table('cases')->where('cases.user_id', auth('api')->user()->id)->where(function ($query) use ($search) {
                    $query->where('control_num', 'LIKE', "%$search%")
                        ->orWhere('case_no', 'LIKE', "%$search%")
                        ->orWhere('case_title', 'LIKE', "%$search%")
                        ->orWhere('court', 'LIKE', "%$search%")
                        ->orWhere('crime', 'LIKE', "%$search%")
                        ->orWhere('detained', 'LIKE', "%$search%")
                        ->orWhere('complainant', 'LIKE', "%$search%")
                        ->orWhere('respondent', 'LIKE', "%$search%")
                        ->orWhere('status', 'LIKE', "%$search%")
                        ->orWhere('access_status', 'LIKE', "%$search%");
                })->get();
                $clients = DB::table('client_profile')
                    ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                    ->join('interviewee_personal_circumstances', 'client_profile.control_num', '=', 'interviewee_personal_circumstances.control_num')
                    ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
                    ->join('client_case_involvement', 'client_profile.control_num', '=', 'client_case_involvement.control_num')
                    ->join('client_classification', 'client_profile.control_num', '=', 'client_classification.control_num')
                    ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
                    ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')
                    ->where('control_reference_and_nature_of_request.assigned_to', auth('api')->user()->firstname.' '.auth('api')->user()->lastname)
                    ->where(function ($query) use ($search) {
                        $query->where('client_name', 'LIKE', "%$search%")
                            ->orWhere('client_religion', 'LIKE', "%$search%")
                            ->orWhere('client_citizenship', 'LIKE', "%$search%")
                            ->orWhere('client_address', 'LIKE', "%$search%")
                            ->orWhere('client_email', 'LIKE', "%$search%")
                            ->orWhere('client_monthly_income', 'LIKE', "%$search%")
                            ->orWhere('detained', 'LIKE', "%$search%")
                            ->orWhere('detained_since', 'LIKE', "%$search%")
                            ->orWhere('client_age', 'LIKE', "%$search%")
                            ->orWhere('client_gender', 'LIKE', "%$search%")
                            ->orWhere('client_civil_status', 'LIKE', "%$search%")
                            ->orWhere('client_dialect', 'LIKE', "%$search%")
                            ->orWhere('client_contact', 'LIKE', "%$search%")
                            ->orWhere('client_spouse', 'LIKE', "%$search%")
                            ->orWhere('spouse_address', 'LIKE', "%$search%")
                            ->orWhere('spouse_contact', 'LIKE', "%$search%")
                            ->orWhere('detention_place', 'LIKE', "%$search%")
                            ->orWhere('interviewer', 'LIKE', "%$search%")
                            ->orWhere('assigned_to', 'LIKE', "%$search%")
                            ->orWhere('referred_by', 'LIKE', "%$search%")
                            ->orWhere('refer_to', 'LIKE', "%$search%")
                            ->orWhere('nature_request', 'LIKE', "%$search%")
                            ->orWhere('interviewee_name', 'LIKE', "%$search%")
                            ->orWhere('interviewee_address', 'LIKE', "%$search%")
                            ->orWhere('interviewee_relationship_to_client', 'LIKE', "%$search%")
                            ->orWhere('interviewee_age', 'LIKE', "%$search%")
                            ->orWhere('interviewee_gender', 'LIKE', "%$search%")
                            ->orWhere('interviewee_civil_status', 'LIKE', "%$search%")
                            ->orWhere('interviewee_contact', 'LIKE', "%$search%")
                            ->orWhere('interviewee_email', 'LIKE', "%$search%")
                            ->orWhere('nature_case', 'LIKE', "%$search%")
                            ->orWhere('nature_specify_case', 'LIKE', "%$search%")
                            ->orWhere('involvement', 'LIKE', "%$search%")
                            ->orWhere('complaint', 'LIKE', "%$search%")
                            ->orWhere('class', 'LIKE', "%$search%")
                            ->orWhere('children_in_conflict', 'LIKE', "%$search%")
                            ->orWhere('indigenous_group', 'LIKE', "%$search%")
                            ->orWhere('person_with_disability', 'LIKE', "%$search%")
                            ->orWhere('urban_poor', 'LIKE', "%$search%")
                            ->orWhere('rural_poor', 'LIKE', "%$search%")
                            ->orWhere('ofw', 'LIKE', "%$search%")
                            ->orWhere('adverse_party', 'LIKE', "%$search%")
                            ->orWhere('adverse_party_name', 'LIKE', "%$search%")
                            ->orWhere('fact_of_the_case', 'LIKE', "%$search%")
                            ->orWhere('case_of_action', 'LIKE', "%$search%")
                            ->orWhere('pending_in_court', 'LIKE', "%$search%")
                            ->orWhere('title_of_case', 'LIKE', "%$search%")
                            ->orWhere('court_body_tribunal', 'LIKE', "%$search%")
                            ->orWhere('other_case_of_action', 'LIKE', "%$search%")
                            ->orWhere('other_court_body_tribunal', 'LIKE', "%$search%")
                            ->orWhere('proof_of_indigency', 'LIKE', "%$search%");
                    })->get();
                $hearings = DB::table('hearing')->where(function ($query) use ($search) {
                    $query->where('case_no', 'LIKE', "%$search%")
                        ->orWhere('case_status', 'LIKE', "%$search%")
                        ->orWhere('hearing_date', 'LIKE', "%$search%")
                        ->orWhere('case_Summary', 'LIKE', "%$search%");
                })->get();

                array_push($arr, $users);
                array_push($arr, $cases);
                array_push($arr, $clients);
                array_push($arr, count($users));
                array_push($arr, count($cases));
                array_push($arr, count($clients));
                return $arr;
            } else {
                return [];
            }
            }

            if(auth('api')->user()->type === 'Staff') {
            if ($search = \Request::get('val')) {
                $arr = [];
                $users = [];
                $cases = [];
                $clients = DB::table('client_profile')
                    ->join('control_reference_and_nature_of_request', 'client_profile.control_num', '=', 'control_reference_and_nature_of_request.control_num')
                    ->join('interviewee_personal_circumstances', 'client_profile.control_num', '=', 'interviewee_personal_circumstances.control_num')
                    ->join('nature_of_the_case', 'client_profile.control_num', '=', 'nature_of_the_case.control_num')
                    ->join('client_case_involvement', 'client_profile.control_num', '=', 'client_case_involvement.control_num')
                    ->join('client_classification', 'client_profile.control_num', '=', 'client_classification.control_num')
                    ->join('additional_information_case', 'client_profile.control_num', '=', 'additional_information_case.control_num')
                    ->join('proof_of_indigency', 'client_profile.control_num', '=', 'proof_of_indigency.control_num')->where(function ($query) use ($search) {
                        $query->where('client_name', 'LIKE', "%$search%")
                            ->orWhere('client_religion', 'LIKE', "%$search%")
                            ->orWhere('client_citizenship', 'LIKE', "%$search%")
                            ->orWhere('client_address', 'LIKE', "%$search%")
                            ->orWhere('client_email', 'LIKE', "%$search%")
                            ->orWhere('client_monthly_income', 'LIKE', "%$search%")
                            ->orWhere('detained', 'LIKE', "%$search%")
                            ->orWhere('detained_since', 'LIKE', "%$search%")
                            ->orWhere('client_age', 'LIKE', "%$search%")
                            ->orWhere('client_gender', 'LIKE', "%$search%")
                            ->orWhere('client_civil_status', 'LIKE', "%$search%")
                            ->orWhere('client_dialect', 'LIKE', "%$search%")
                            ->orWhere('client_contact', 'LIKE', "%$search%")
                            ->orWhere('client_spouse', 'LIKE', "%$search%")
                            ->orWhere('spouse_address', 'LIKE', "%$search%")
                            ->orWhere('spouse_contact', 'LIKE', "%$search%")
                            ->orWhere('detention_place', 'LIKE', "%$search%")
                            ->orWhere('interviewer', 'LIKE', "%$search%")
                            ->orWhere('assigned_to', 'LIKE', "%$search%")
                            ->orWhere('referred_by', 'LIKE', "%$search%")
                            ->orWhere('refer_to', 'LIKE', "%$search%")
                            ->orWhere('nature_request', 'LIKE', "%$search%")
                            ->orWhere('interviewee_name', 'LIKE', "%$search%")
                            ->orWhere('interviewee_address', 'LIKE', "%$search%")
                            ->orWhere('interviewee_relationship_to_client', 'LIKE', "%$search%")
                            ->orWhere('interviewee_age', 'LIKE', "%$search%")
                            ->orWhere('interviewee_gender', 'LIKE', "%$search%")
                            ->orWhere('interviewee_civil_status', 'LIKE', "%$search%")
                            ->orWhere('interviewee_contact', 'LIKE', "%$search%")
                            ->orWhere('interviewee_email', 'LIKE', "%$search%")
                            ->orWhere('nature_case', 'LIKE', "%$search%")
                            ->orWhere('nature_specify_case', 'LIKE', "%$search%")
                            ->orWhere('involvement', 'LIKE', "%$search%")
                            ->orWhere('complaint', 'LIKE', "%$search%")
                            ->orWhere('class', 'LIKE', "%$search%")
                            ->orWhere('children_in_conflict', 'LIKE', "%$search%")
                            ->orWhere('indigenous_group', 'LIKE', "%$search%")
                            ->orWhere('person_with_disability', 'LIKE', "%$search%")
                            ->orWhere('urban_poor', 'LIKE', "%$search%")
                            ->orWhere('rural_poor', 'LIKE', "%$search%")
                            ->orWhere('ofw', 'LIKE', "%$search%")
                            ->orWhere('adverse_party', 'LIKE', "%$search%")
                            ->orWhere('adverse_party_name', 'LIKE', "%$search%")
                            ->orWhere('fact_of_the_case', 'LIKE', "%$search%")
                            ->orWhere('case_of_action', 'LIKE', "%$search%")
                            ->orWhere('pending_in_court', 'LIKE', "%$search%")
                            ->orWhere('title_of_case', 'LIKE', "%$search%")
                            ->orWhere('court_body_tribunal', 'LIKE', "%$search%")
                            ->orWhere('other_case_of_action', 'LIKE', "%$search%")
                            ->orWhere('other_court_body_tribunal', 'LIKE', "%$search%")
                            ->orWhere('proof_of_indigency', 'LIKE', "%$search%");
                    })->get();
                $hearings = DB::table('hearing')->where(function ($query) use ($search) {
                    $query->where('case_no', 'LIKE', "%$search%")
                        ->orWhere('case_status', 'LIKE', "%$search%")
                        ->orWhere('hearing_date', 'LIKE', "%$search%")
                        ->orWhere('case_Summary', 'LIKE', "%$search%");
                })->get();

                array_push($arr, $users);
                array_push($arr, $cases);
                array_push($arr, $clients);
                array_push($arr, count($users));
                array_push($arr, count($cases));
                array_push($arr, count($clients));
                return $arr;
            } else {
                return [];
            }
            }
        }

        public function audit() {
            $audits = DB::table('audits')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->select('users.firstname', 'users.lastname', 'audits.event', 'audits.auditable_type', 'audits.ip_address', 'audits.created_at')
            ->where('auditable_type', '!=', "App\User")
            ->where('user_id', auth('api')->user()->id)
            ->paginate(10);
            return $audits;
        }

    public function allAudit()
    {
        $allAudit = DB::table('audits')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->select('users.firstname', 'users.lastname', 'audits.event', 'audits.auditable_type', 'audits.ip_address', 'audits.created_at')
            ->where('auditable_type', '!=', "App\User")
            ->paginate(20);
        return $allAudit;
    }

    public function checkPassword(Request $request)
    {
        $password = auth('api')->user()->password;
        $old = Hash::check( $request['old_password'], $password);
        return [$old];
    }
}
