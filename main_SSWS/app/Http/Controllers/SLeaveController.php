<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SLeaveController extends Controller
{
    public function submit(Request $request)
    {
        $typeOfLeave=$request->input('typeOfLeave');
        $department=\Session::get('department');

        if($typeOfLeave=="Half_Leave")
        {
            $reason=$request->input('Hreason');
            $time=$request->input('Htime');
            $enrollment=$request->input('enrollment');
            $CurrentTime=$request->input('CurrentTime');
            $CurrentDate=$request->input('CurrentDate');

            $data=array('enrollment'=>$enrollment,'type_of_leave'=>'Half Leave','reason'=>$reason,'leave_time'=>$time,'submitted_time'=>$CurrentTime,'submitted_date'=>$CurrentDate,'status'=>'pending',"department"=>$department);
            DB::table('student_applications')->insert($data);

            return redirect('leave')->with("success","Your Application Has Been Sent, Wait For Confirmation");
        }
        else
        {
            $reason=$request->input('Freason');
            $toDate=$request->input('FtoDate');
            $fromDate=$request->input('FfromDate');
            $enrollment=$request->input('enrollment');
            $CurrentTime=$request->input('CurrentTime');
            $CurrentDate=$request->input('CurrentDate');

            $data=array('enrollment'=>$enrollment,'type_of_leave'=>'Full Leave','reason'=>$reason,'leave_to_date'=>$toDate,'leave_from_date'=>$fromDate,'submitted_time'=>$CurrentTime,'submitted_date'=>$CurrentDate,'status'=>'pending');
            DB::table('student_applications')->insert($data);

            return redirect('leave')->with("success","Your Application Has Been Sent, Wait For Confirmation");

        }
    }

    public function home()
    {
        $enrollment=\Session::get('enrollment');

        $details=DB::table('student_applications')
        ->where('enrollment',$enrollment)->orderBy('submitted_date','desc')->paginate(5);


        return view('user.home', ['details' => $details]);
        // return view('user.home',compact('details'));
    }

    public function profile()
    {
        $enrollment=\Session::get('enrollment');
        $details=DB::table('student_info')
        ->where('enrollment',$enrollment)->get();

        $leaves=DB::table('student_applications')
        ->where('enrollment',$enrollment)->get();

        $data=DB::table('student_applications')
        ->where('enrollment',$enrollment)
        ->where('status','confirmed')->get();

        $data1=DB::table('student_applications')
        ->where('enrollment',$enrollment)
        ->where('status','pending')->get();

        $approved=$data->count();
        $pending=$data1->count();

        $total=$leaves->count();
        return view('user.profile',compact('leaves','details','approved','pending','total'));
    }

    public function DisplayLeaveInfo(Request $request)
    {
        $id=$request->input('id');
        $detail=DB::table('student_applications')
        ->where('id',$id)->get();

        return view('user.leave_info',compact('detail'));
    }
}
