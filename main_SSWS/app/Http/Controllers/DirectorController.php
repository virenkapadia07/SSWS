<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;

class DirectorController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
        ]);

        $username=$request->input('username');
        $password=$request->input('password');

        $checklogin=DB::table('director')->where(['username'=>$username])->get();
        if(count($checklogin)>0)
        {
            $pw=DB::table('director')->where('username', $username)->value('password');

            if(Hash::check($password, $pw))
            {
                $request->session()->put('director',$username);

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

    function home()
    {
        $leave_details=DB::table('faculty_applications')->where('hod_status','confirm')->where('director_status','pending')->get();

        $leave_details=$leave_details->unique('leave_id');

        return view('director.home',compact('leave_details'));
    }

    function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    function show(Request $request)
    {
        $leave_id=$request->get('id');
        $faculty_name=$request->get('name');
        $leave_details=DB::table('faculty_applications')->where('leave_id',$leave_id)->get();
        $leav_details=array();
        foreach ($leave_details as $key => $value) {
            $lec_id=$value->lec_id;
            $lec_details=DB::table('lecture_arrangement')->where('lec_id',$lec_id)->get();
            $ldetails=DB::table('faculty_applications')->where('lec_id',$lec_id)->get();
            $lecture_details=array();
            array_push($leav_details,$value);
            for($i=1;$i<=6;$i++)
            {
                $lec='lecture'.$i;
                if($lec_details[0]->$lec)
                {
                    $class="class".$i;
                    $status="status".$i;
                    $get_id=DB::table('faculty_applications')->where('lec_id',$lec_id)->get();
                    $get_faculty_id=$lec_details[0]->$lec;

                    $get_faculty_details=DB::table('faculty_info')->where('faculty_id',$get_faculty_id)->select('f_name','l_name')->get();

                    $full_name=$get_faculty_details[0]->f_name." ".$get_faculty_details[0]->l_name;
                    $class=$lec_details[0]->$class;
                    $date=$get_id[0]->leave_date;
                    $b=array('lecture'=>$i,'class'=>$class,'name'=>$full_name,"lec_id"=>$lec_id);
                    $lecture_details[$i]=$b;
                }
            }
        }
        return view('director.faculty_leave_details',compact('faculty_name','lecture_details','leave_details','leav_details'));
    }

    function accpetFacultyLeave(Request $request)
    {
        $leave_id=$request->leave_id;
        DB::table('faculty_applications')->where('leave_id',$leave_id)->update(['director_status'=>'confirm']);

        return redirect('home')->with('success','Leave has been Approved');
    }

    function rejectFacultyLeave(Request $request)
    {
        $leave_id=$request->leave_id;
        DB::table('faculty_applications')->where('leave_id',$leave_id)->update(['director_status'=>'rejected']);

        return redirect('home')->with('success','Leave has been Rejected');;
    }
}
