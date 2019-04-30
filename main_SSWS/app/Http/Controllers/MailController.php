<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Request;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Mail;

class MailController extends Controller {
   public function email(Request $request){

    $this->validate($request,[
        'enrollment'=>'required|min:12|numeric',
        'email'=>'required|email'
    ]);

        $email1=\Request::Input('email');
        $email2=DB::table('student_info')->where('email',$email1)->value('email');
        $enroll1=\Request::Input('enrollment');
        $enroll2=DB::table('student_info')->where('enrollment',$enroll1)->value('enrollment');
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $password = substr($random, 0, 10);
        $hashpass = Hash::make($password);
        $data = array('name'=>DB::table('student_info')->where('enrollment',$enroll1)->value('name'),
                    'enrollment'=>$enroll2,
                    'password'=>$password);
        $pass = DB::table('student')->where('enrollment',$enroll2)->value('password');
        if($email1==$email2 && $enroll1==$enroll2)
        {
            if($pass == null)
            {
                Mail::send(['text'=>'user.mail'], $data, function($message) {
                    $message->to(\Request::Input('email'), DB::table('student_info')->where('enrollment',\Request::Input('enrollment'))->value('name'))->subject
                        ('Student & Staff Welfare System - Registration');
                    $message->from('Mail you used for send Email','Student & Staff Welfare System');
                });

                DB::insert('insert into student (enrollment,password) values (?,?)',[\Request::Input('enrollment'),
                        $hashpass]);

                return redirect('register')->with('success',"Username and Password Sended to your registered Email ID.");
            }
            else
            {
                return redirect('register')->with('wrong',"User already exists!");
            }
        }
        else
        {
            return redirect('register')->with('wrong',"Entered data doesn't match");
        }
   }
}
