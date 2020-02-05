<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\clientProfile;
use App\natureRequest;
use App\User;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = clientProfile::all();
        return view('clientProfile.create')->with('name', $name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $natureRequest = new natureRequest;
        $natureRequest->interviewer = $request->input('interviewer');
        $natureRequest->assigned_to = $request->input('assigned_to');
        $natureRequest->referred_by = $request->input('referred_by');
        $natureRequest->refer_to = $request->input('refer_to');
        $natureRequest->approved_by = $request->input('approved_by');
        $natureRequest->nature_request = $request->input('nature_request');
        $natureRequest->save();

        $clientProfile = new clientProfile;
        $clientProfile->name = $request->input('name');
        $clientProfile->religion = $request->input('religion');
        $clientProfile->citizenship = $request->input('citizenship');
        $clientProfile->address = $request->input('address');
        $clientProfile->email = $request->input('email');
        $clientProfile->monthly_net_income = $request->input('monthly_net_income');
        $clientProfile->detained = $request->input('detained');
        $clientProfile->detained_since = $request->input('detained_since');
        $clientProfile->age = $request->input('age');
        $clientProfile->gender = $request->input('gender');
        $clientProfile->civil_status = $request->input('civil_status');
        $clientProfile->educational_attainment = $request->input('educational_attainment');
        $clientProfile->language = $request->input('language');
        $clientProfile->contact = $request->input('contact');
        $clientProfile->spouse = $request->input('spouse');
        $clientProfile->spouse_address = $request->input('spouse_address');
        $clientProfile->spouse_contact = $request->input('spouse_contact');
        $clientProfile->detention_place = $request->input('detention_place');
        $clientProfile->save();

        return redirect('/client-profile');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function control_reference()
    {
        $user = User::where('type' , 'Super Admin')->
                    orWhere('type' , 'Admin')->pluck('firstname' , 'firstname');

        return view();
    }



    public function searchCase()
    {
        $input = Input::only('access_code');
        $case = DB::table('cases')->select('case_summary')
                ->where([
                    ['access_code', '=', $input['access_code']],['access_status', '=', 'Enabled']
                ])->get();
        return view('client-case')->with('summary', $case);
    }

}
