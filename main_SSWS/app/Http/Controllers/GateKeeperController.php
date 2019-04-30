<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
class GateKeeperController extends Controller
{
    public function login(Request $request)
    {

        $username=$request->input('username');
        $password=$request->input('password');

        $checklogin=DB::table('gatekeeper')->where(['username'=>$username])->get();
        if(count($checklogin)>0)
        {
            $pw=DB::table('gatekeeper')->where('username', $username)->value('password');

            if(Hash::check($password, $pw))
            {
                $request->session()->put('gatekeeper','gatekeeper');
                return redirect('home');
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

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function checkStudent(Request $request)
    {
        $this->validate($request,[
            'enrollment'=>'required|min:12',
        ]);

        $enrollment=$request->input('enrollment');
        $today=$request->input('todate');

        $details=DB::table('student_applications')
        ->where('enrollment',$enrollment)
        ->where('submitted_date',$today)
        ->where('status','confirmed')
        ->where('type_of_leave',"Half Leave")
        ->get();

        $student=DB::table('student_info')
        ->where('enrollment',$enrollment)->get();

        if($details->count()==0)
        {
            return redirect('home')->with('wrong','No Data Found');
        }
        else
        {
            return view('gatekeeper.result',compact('details','student'));
        }
    }
}
