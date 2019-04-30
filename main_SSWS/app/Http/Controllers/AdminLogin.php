<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Crypt;
use DB;
use Hash;
use Mail;

class AdminLogin extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
        ]);

        $username=$request->input('username');
        $password=$request->input('password');

        $checklogin=DB::table('admin')->where(['username'=>$username])->get();
        if(count($checklogin)>0)
        {
            $pw=DB::table('admin')->where('username', $username)->value('password');

            if(Hash::check($password, $pw))
            {
                $request->session()->put('admin','admin');
                return redirect('/AdminHome');
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
        return view('admin.home');
    }

    public function userLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function addStudent(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:3',
            'enrollment'=>'required|min:12',
            'email'=>'required|email',
            'branch'=>'required|',
            'semester'=>'required|numeric',
            'mobileNo'=>'required|numeric',
            'photo'=>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $name=$request->input('name');
        $enrollment=$request->input('enrollment');
        $email=$request->input('email');
        $branch=$request->input('branch');
        $semester=$request->input('semester');
        $mobileNo=$request->input('mobileNo');
        $file = file_get_contents($_FILES["photo"]["tmp_name"]);

        DB::table('student_info')
        ->insert(['name'=>$name,'enrollment'=>$enrollment,'email'=>$email,'branch'=>$branch,'semester'=>$semester,'mobileNo'=>$mobileNo,'image'=>$file]);
        return redirect('manage')->with('success','User added successfully');
    }

    public function addFaculty(Request $request){

        $this->validate($request,[
            'fname'=>'required|min:3',
            'lname'=>'required|min:3',
            'mname'=>'required|min:3',
            'email'=>'required|email',
            'department'=>'required|',
            'mobileNo'=>'required|numeric',
        ]);

        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $mname=$request->input('mname');
        $name=$fname." ".$lname;
        $email=$request->input('email');
        $department=$request->input('department');
        $mobileNo=$request->input('mobileNo');

        $f_sn=strtoupper($fname[0]).strtoupper($mname[0]).strtoupper($lname[0]);

        $default_password="ssws2019";
        $random = str_shuffle('0123456789');
        $faculty_id=$f_sn;
        $faculty_id .= substr($random, 0, 3);
        $hashpass = Hash::make($default_password);

        //echo $f_sn."|".$faculty_id."|".$hashpass;

        $data = array('name'=>$name,'facultyid'=>$faculty_id,'password'=>$default_password);

        Mail::send(['text'=>'admin.registrationmail'], $data, function($message) {
            $message->to(\Request::Input('email'),\Request::Input('fname')." ".\Request::Input('lname'))->subject
                ('Student & Staff Welfare System - Registration Mail');
            $message->from('sswsproject@outlook.com','Student & Staff Welfare System');
        });

        DB::table('faculty_info')
        ->insert(['faculty_id'=>$faculty_id,'f_name'=>$fname,'m_name'=>$mname,'l_name'=>$lname,'email'=>$email,'department'=>$department,'mobile_no'=>$mobileNo]);

        DB::table('faculty')
        ->insert(['faculty_id'=>$faculty_id,'password'=>$hashpass,'f_sn'=>$f_sn]);

        DB::table('leave_used')
        ->insert(['faculty_id'=>$faculty_id]);

        DB::table('leave_avaliable')
        ->insert(['faculty_id'=>$faculty_id]);

        return redirect('manageFaculty')->with('success','User added successfully');
    }
}
