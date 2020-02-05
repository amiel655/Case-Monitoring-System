<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use App\User;
use App\clientProfile;
use App\natureRequest;
use App\intervieweePersonalCircumstances;
use App\natureOfTheCase;
use App\clientCaseInvolvement;
use App\clientClassification;
use App\additionalInformationCase;
use App\proofIndigency;
use App\Notifications\CreateClient;
use Notification;
use Illuminate\Notifications\Notifiable;

class FormController extends Controller
{
    use Notifiable;
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $now = Carbon::now();
        $control_num = '';
        // STEP 1
        $natureRequest = new natureRequest;
        if(natureRequest::all()->count() > 0){
            $id = natureRequest::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $natureRequest->control_num = "III-".$now->format('M')."-".$x;
            $control_num = "III-" . $now->format('M') . "-" . $x;
        }
        else{
            $natureRequest->control_num = "III-".$now->format('M')."-"."1";
            $control_num = "III-" . $now->format('M') . "-" . "1";
        }

        $natureRequest->interviewer = $request->step1['interviewer'];
        $natureRequest->assigned_to = $request->step1['assigned_to'];
        $natureRequest->referred_by = $request->step1['referred_by'];
        $natureRequest->refer_to = $request->step1['refer_to'];
        $natureRequest->nature_request = $request->step1['nature_request'];
        $natureRequest->status = 'On-Going';
        $natureRequest->save();

        $natureCase = new natureOfTheCase;
        if(natureOfTheCase::all()->count() > 0){
            $id = natureOfTheCase::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $natureCase->control_num = "III-".$now->format('M')."-".$x;

        }
        else{
            $natureCase->control_num = "III-".$now->format('M')."-"."1";
        }
        $natureCase->nature_case = $request->step1['nature_case']['case'];
        $natureCase->nature_specify_case = $request->step1['nature_case']['input'];
        $natureCase->save();

        // STEP 2
        $clientProfile = new clientProfile;
        if(clientProfile::all()->count() > 0){
            $id = clientProfile::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $clientProfile->control_num = "III-".$now->format('M')."-".$x;

        }
        else{
            $clientProfile->control_num = "III-".$now->format('M')."-"."1";
        }
        $clientProfile->client_name = $request->step2['client_name'];
        $clientProfile->client_religion = $request->step2['client_religion'];
        $clientProfile->client_citizenship = $request->step2['client_citizenship'];
        $clientProfile->client_address = $request->step2['client_address'];
        $clientProfile->client_email = $request->step2['client_email'];
        $clientProfile->client_monthly_income = $request->step2['client_monthly_income'];
        $clientProfile->detained = $request->step2['detained'];
        if($request->step2['detained_since'] === 'None') {
            $clientProfile->detained_since = null;
        } else{
            $clientProfile->detained_since = $request->step2['detained_since'];
        }
        $clientProfile->client_age = $request->step2['client_age'];
        $clientProfile->client_gender = $request->step2['client_gender'];
        $clientProfile->client_civil_status = $request->step2['client_civil_status'];
        $clientProfile->client_educational_attainment = $request->step2['client_educational_attainment'];
        $clientProfile->client_dialect = implode(',', $request->step2['client_dialect']);
        $clientProfile->client_contact = $request->step2['client_contact'];
        $clientProfile->client_spouse = $request->step2['client_spouse'];
        $clientProfile->spouse_address = $request->step2['spouse_address'];
        $clientProfile->spouse_contact = $request->step2['spouse_contact'];
        $clientProfile->detention_place = $request->step2['detention_place'];
        $clientProfile->save();

        $interviewee = new intervieweePersonalCircumstances;
        if(intervieweePersonalCircumstances::all()->count() > 0){
            $id = intervieweePersonalCircumstances::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $interviewee->control_num = "III-".$now->format('M')."-".$x;

        }
        else{
            $interviewee->control_num = "III-".$now->format('M')."-"."1";
        }
        $interviewee->interviewee_name = $request->step2['interviewee_name'];
        $interviewee->interviewee_address = $request->step2['interviewee_address'];
        $interviewee->interviewee_relationship_to_client = $request->step2['interviewee_relationship_to_client'];
        $interviewee->interviewee_age = $request->step2['interviewee_age'];
        $interviewee->interviewee_gender = $request->step2['interviewee_gender'];
        $interviewee->interviewee_civil_status = $request->step2['interviewee_civil_status'];
        $interviewee->interviewee_contact = $request->step2['interviewee_contact'];
        $interviewee->interviewee_email = $request->step2['interviewee_email'];
        $interviewee->save();

        // STEP 3
        $caseInvolvement = new clientCaseInvolvement;
        if(clientCaseInvolvement::all()->count() > 0){
            $id = clientCaseInvolvement::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $caseInvolvement->control_num = "III-".$now->format('M')."-".$x;

        }
        else{
            $caseInvolvement->control_num = "III-".$now->format('M')."-"."1";
        }
        $caseInvolvement->involvement = $request->step3['client_involvement'];
        $caseInvolvement->complaint = implode(',', $request->step3['client_complaint']);
        $caseInvolvement->save();


        $clientClassification = new clientClassification;
        if(clientClassification::all()->count() > 0){
            $id = clientClassification::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $clientClassification->control_num = "III-".$now->format('M')."-".$x;

        }
        else{
            $clientClassification->control_num = "III-".$now->format('M')."-"."1";
        }
        $clientClassification->class = implode(',', $request->step3['client_class']);
        $clientClassification->children_in_conflict = $request->step3['client_classification']['children_in_conflict']['input'];
        $clientClassification->indigenous_group = $request->step3['client_classification']['indigenous_group']['input'];
        $clientClassification->person_with_disability = $request->step3['client_classification']['person_with_disability']['input'];
        $clientClassification->urban_poor = $request->step3['client_classification']['urban_poor']['input'];
        $clientClassification->rural_poor = $request->step3['client_classification']['rural_poor']['input'];
        $clientClassification->ofw = $request->step3['client_classification']['ofw']['input'];
        $clientClassification->save();


        // STEP 4
        $additionalInformation = new additionalInformationCase;
        if(additionalInformationCase::all()->count() > 0){
            $id = additionalInformationCase::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $additionalInformation->control_num = "III-".$now->format('M')."-".$x;

        }
        else{
            $additionalInformation->control_num = "III-".$now->format('M')."-"."1";
        }
        $additionalInformation->adverse_party = $request->step4['adverse_party'];
        $additionalInformation->adverse_party_name = $request->step4['adverse_party_name'];
        $additionalInformation->adverse_party_address = $request->step4['adverse_party_address'];
        $additionalInformation->fact_of_the_case = $request->step4['fact_of_the_case'];



        // STEP 5
        $additionalInformation->case_of_action = $request->step5['case_of_action'];
        $additionalInformation->pending_in_court = $request->step5['pending_in_court'];
        $additionalInformation->title_of_case = $request->step5['title_of_case'];
        $additionalInformation->court_body_tribunal = $request->step5['court_body_tribunal'];
        $additionalInformation->other_case_of_action = $request->step5['other_case_of_action'];
        $additionalInformation->other_court_body_tribunal = $request->step5['other_court_body_tribunal'];
        $additionalInformation->save();

        $proofIndigency = new proofIndigency;
        if (proofIndigency::all()->count() > 0) {
            $id = proofIndigency::select('id')->latest()->value('id') + 1;
            $x = (string)$id;
            $proofIndigency->control_num = "III-" . $now->format('M') . "-" . $x;

        } else {
            $proofIndigency->control_num = "III-" . $now->format('M') . "-". "1";
        }
        $proofIndigency->proof_of_indigency = implode(',', $request->step5['proof_of_indigency']);
        $proofIndigency->save();

        $assigned_by = auth('api')->user()->firstname.' '. auth('api')->user()->lastname;
        $assigned_by_image = User::where('firstname', auth('api')->user()->firstname)->where('lastname', auth('api')->user()->lastname)->select('image')->first();
        $assigned_to = User::where('firstname', $request->step1['firstname'])->where('lastname', $request->step1['lastname'])->select('*')->get();
        $assigned_to[0]->notify(new CreateClient($assigned_by, $assigned_by_image->image, $control_num));
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

    public function updateClientStatus(Request $request)
    {
        return DB::table('control_reference_and_nature_of_request')->where('control_num', $request['control_num'])->update([
            'status' => $request['status']
        ]);
    }


}
