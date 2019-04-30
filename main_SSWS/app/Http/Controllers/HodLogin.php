<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Crypt;
use DB;
use Hash;

class HodLogin extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
        ]);

        $username=$request->input('username');
        $password=$request->input('password');

        $checklogin=DB::table('hod')->where(['hod_id'=>$username])->get();
        if(count($checklogin)>0)
        {
            $pw=DB::table('hod')->where('hod_id', $username)->value('password');
            $department=DB::table('hod')->where('hod_id', $username)->value('department');
            $faculty_id=DB::table('hod')->where('hod_id', $username)->value('faculty_id');
            $fname=DB::table('faculty_info')->where('faculty_id', $faculty_id)->value('f_name');
            $lname=DB::table('faculty_info')->where('faculty_id', $faculty_id)->value('l_name');
            $name=$fname." ".$lname;
            $f_sn=DB::table('faculty')->where('faculty_id', $faculty_id)->value('f_sn');

            if(Hash::check($password, $pw))
            {
                $request->session()->put('hod',$username);
                $request->session()->put('name',$name);
                $request->session()->put('department',$department);
                $request->session()->put('faculty_id',$faculty_id);
                $request->session()->put('f_sn',$f_sn);
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
        return view('hod.home');
    }

    public function userLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function addUser(Request $request)
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
}
