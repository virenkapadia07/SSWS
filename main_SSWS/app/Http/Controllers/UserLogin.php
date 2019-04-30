<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Crypt;
use DB;
use Hash;

class UserLogin extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request,[
            'enrollment'=>'required|min:12|numeric',
            'password'=>'required',
        ]);

        $enrollment=$request->input('enrollment');
        $password=$request->input('password');
        $name=DB::table('student_info')->where('enrollment', $enrollment)->value('name');

        $checklogin=DB::table('student')->where(['enrollment'=>$enrollment])->get();
        if(count($checklogin)>0)
        {
            $pw=DB::table('student')->where('enrollment', $enrollment)->value('password');

            if(Hash::check($password, $pw))
            {
                $request->session()->put('logged_in',$name);
                $request->session()->put('enrollment',$enrollment);
                return redirect('/home');
            }
            else
            {
                return redirect('/')->with('wrong','Entered Details Are Incorrect!!!');
            }
        }
        else
        {
                return redirect('/')->with('wrong','Entered Details Are Incorrect!!!');
        }
    }

    public function home(Request $request)
    {
        return view('user.home');
    }

    public function userLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function changePassword(Request $request)
    {
        $oldpassword=$request->input('password');
        $newpassword=$request->input('newpassword');
        $enrollment=\Session::get('enrollment');

        $pw=DB::table('student')->where('enrollment', $enrollment)->value('password');

        if(Hash::check($oldpassword, $pw))
        {
            $hashedPassword=Hash::make($newpassword);
            DB::table('student')
            ->where('enrollment',$enrollment)
            ->update(['password'=>$hashedPassword]);
            return redirect('/home')->with('success','Your password is changed successfully');
        }
        else
        {
            return redirect('setting')->with('wrong','Your Given Password is Wrong');
        }
    }
}
