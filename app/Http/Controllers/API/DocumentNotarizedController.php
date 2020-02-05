<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\documentNotarized;

class DocumentNotarizedController extends Controller
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
        // $results = DB::table('document_notarized')->select('id', 'date', 'nature_instrument', 'executor', 'gender', 'contact_no', 'address', 'witnesses')->where('user_id', auth('api')->user()->id)->get();
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
            if (documentNotarized::where('id', $request['report'][$i]['id'])->exists()) {
                $documentNotarized = documentNotarized::find($request['report'][$i]['id']);
                $documentNotarized->date = $request['report'][$i]['updated_at'];
                $documentNotarized->nature_instrument = $request['report'][$i]['nature_instrument'];
                $documentNotarized->executor = $request['report'][$i]['executor'];
                $documentNotarized->gender = $request['report'][$i]['client_gender'];
                $documentNotarized->contact_no = $request['report'][$i]['client_contact'];
                $documentNotarized->address = $request['report'][$i]['client_address'];
                $documentNotarized->witnesses = $request['report'][$i]['witnesses'];
                $documentNotarized->save();
            } else {
                if ($request['report'][$i]['updated_at'] !== null || $request['report'][$i]['nature_instrument'] !== null || $request['report'][$i]['executor'] !== null || $request['report'][$i]['client_gender'] !== null || $request['report'][$i]['client_contact'] !== null || $request['report'][$i]['client_address'] !== null || $request['report'][$i]['witnesses'] !== null) {
                    $documentNotarized = new documentNotarized;
                    $documentNotarized->attorney = $request['report'][$i]['attorney'];
                    $documentNotarized->control_num = $request['report'][$i]['control_num'];
                    $documentNotarized->date = $request['report'][$i]['updated_at'];
                    $documentNotarized->nature_instrument = $request['report'][$i]['nature_instrument'];
                    $documentNotarized->executor = $request['report'][$i]['executor'];
                    $documentNotarized->gender = $request['report'][$i]['client_gender'];
                    $documentNotarized->contact_no = $request['report'][$i]['client_contact'];
                    $documentNotarized->address = $request['report'][$i]['client_address'];
                    $documentNotarized->witnesses = $request['report'][$i]['witnesses'];
                    $documentNotarized->save();
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
            ->leftJoin('document_notarized', 'control_reference_and_nature_of_request.control_num', '=', 'document_notarized.control_num')
            ->select('document_notarized.id', 'document_notarized.attorney', 'document_notarized.nature_instrument', 'document_notarized.executor', 'document_notarized.witnesses', 'control_reference_and_nature_of_request.updated_at', 'control_reference_and_nature_of_request.control_num', 'client_profile.client_gender', 'client_profile.client_address', 'client_profile.client_contact')
            ->where('control_reference_and_nature_of_request.nature_request', 'Administration of Oath')
            ->where('control_reference_and_nature_of_request.assigned_to', $request['name'])
            ->where('client_profile.created_at', 'like', '%' . $date . '%')
            ->get();
        return $results;
        
    }
}
