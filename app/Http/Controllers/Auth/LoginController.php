<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        if (Auth::user()->type === 'Super Admin' || Auth::user()->type === 'Admin') {
            $username = DB::table('users')->where('id', auth()->user()->id)->select('username')->first();
        $password = DB::table('users')->where('id', auth()->user()->id)->select('password')->first();
            if(Hash::check($username->username, $password->password)) {
                return '/profile';
            } else {
                return '/dashboard';
            }
        }
        if (Auth::user()->type === 'Staff') {
            $username = DB::table('users')->where('id', auth()->user()->id)->select('username')->first();
            $password = DB::table('users')->where('id', auth()->user()->id)->select('password')->first();
            if(Hash::check($username->username, $password->password)) {
                return '/profile';
            } else {
                return '/interview-form';
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['status'] = ["Available", "On-Leave"];
        return $credentials;
    }

    public function username()
    {
        return 'username';
    }

}
