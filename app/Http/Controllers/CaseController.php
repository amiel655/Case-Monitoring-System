<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cases;
use App\Hearing;
class CaseController extends Controller
{
    public function index(Request $request)
    {
        $status = Cases::where('access_code', $request->input('access_code'))->first();
        $count = Cases::where('access_code', $request->input('access_code'))->get();


        if($count->count() > 0){
            if($status->access_status === "Disabled")
            {
                return redirect('/');
            }
            else
            {
                $results = Cases::where('access_code', $request->input('access_code'))->pluck('case_no');
                if(Hearing::where('case_no', $results)->count() > 0){
                    $data = Hearing::where('case_no', $results)->get();
                    return view('access')->with('data', $data);
                }
                else{
                    return redirect('/');
                }
            }
        }
        else
        {
            return redirect('/');
        }
    }
}
