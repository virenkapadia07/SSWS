<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Mail;

class StudentController extends Controller {
   public function registeration(Request $request){
        $email1=\Request::Input('email');
        $email2=DB::table('student_info')->where('email',$email1)->value('email');
        $enroll1=\Request::Input('enrollment');
        $enroll2=DB::table('student_info')->where('enrollment',$enroll1)->value('enrollment');
        $mobileNumber="91".DB::table('student_info')->where('email',$email1)->value('mobileNo');
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $password = substr($random, 0, 10);
        $hashpass = Hash::make($password);

        $data = array('name'=>DB::table('student_info')->where('enrollment',$enroll1)->value('name'),
                    'enrollment'=>$enroll2,
                    'password'=>$password);
        $pass = DB::table('student')->where('enrollment',$enroll2)->value('password');

        $authKey = "Your AUTHKEY";
        $senderId = "NAME You want to display in message(only 6 Letters)";

        if($email1==$email2 && $enroll1==$enroll2)   {
            if($pass == null)   {
                Mail::send(['text'=>'user.registrationmail'], $data, function($message) {
                    $message->to(\Request::Input('email'), DB::table('student_info')
                             ->where('enrollment',\Request::Input('enrollment'))
                             ->value('name'))->subject('Student & Staff Welfare System - Registration Mail');
                    $message->from('Mail you used to send Email','Student & Staff Welfare System');
                });

                $message = 'Dear User, your One Time Password for registering in SSWS system is ##OTP##.';
                $postData = array(
                    'authkey' => $authKey,
                    'mobiles' => $mobileNumber,
                    'message' => $message,
                    'sender' => $senderId,
                    'otp_length' => 6,
                );
                $url="http://control.msg91.com/api/sendotp.php";

                $curl = curl_init($url);
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $postData,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                $request->session()->put('mobileNumber',$mobileNumber);
                $request->session()->put('enroll',$enroll1);

                DB::insert('insert into student (enrollment,password) values (?,?)',[\Request::Input('enrollment'),
                        $hashpass]);

                return redirect('/')->with('successOTP',"OTP send to your registered number.");
            }
            else  {
                return redirect('/')->with('wrong',"User already exists!");
            }
        }
        else  {
            return redirect('/')->with('wrong',"Entered data doesn't match");
        }
   }

   public function login(Request $request)  {
        $enrollment=$request->input('enrollment');
        $password=$request->input('password');
        $name=DB::table('student_info')->where('enrollment', $enrollment)->value('name');
        $department=DB::table('student_info')->where('enrollment', $enrollment)->value('branch');

        $checklogin=DB::table('student')->where(['enrollment'=>$enrollment])->get();
        if(count($checklogin)>0)  {
            $pw=DB::table('student')->where('enrollment', $enrollment)->value('password');

            if(Hash::check($password, $pw))  {
                if (DB::table('student')->where('enrollment',$enrollment)->value('active')==1)  {
                    $request->session()->put('logged_in',$name);
                    $request->session()->put('enrollment',$enrollment);
                    $request->session()->put('department',$department);
                    return redirect('/home');
                }
                else  {
                    return redirect('/')->with('firstverify',"To get acces, first verify your number by OTP sended to you.");
                }
            }
            else  {
                return redirect('/')->with('wrong2','Invalid Enrollment or Password!!!');
            }
        }
        else  {
                return redirect('/')->with('wrong2','You are not Registered!!!');
        }
    }

    public function home(Request $request)  {
        return view('user.home');
    }

    public function userLogout(Request $request) {
        $request->session()->flush();
        return redirect('/');
    }

    public function forgotpassword(Request $request)  {
        $email1=\Request::Input('email');
        $email2=DB::table('student_info')->where('email',$email1)->value('email');
        $enroll=DB::table('student_info')->where('email',$email1)->value('enrollment');
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $password = substr($random, 0, 10);
        $hashpass = Hash::make($password);

        $data = array('name'=>DB::table('student_info')->where('enrollment',$enroll)->value('name'),
            'enrollment'=>$enroll,
            'password'=>$password);

        if($email1==$email2)  {
            Mail::send(['text'=>'user.forgotpassword'], $data, function($message) {
                $message->to(\Request::Input('email'), DB::table('student_info')->where('enrollment',\Request::Input('enrollment'))->value('name'))->subject
                    ('Student & Staff Welfare System - Reset Password');
                $message->from('Mail you used to send Email','Student & Staff Welfare System');
            });

            DB::table('student')->where('enrollment',$enroll)->update(['password'=>$hashpass]);
            return redirect('/')->with('success1',"New Password Sended to your registered Email ID!!");
        }
        else  {
            return redirect('/')->with('wrong1',"No Match Found!!");
        }
    }

    public function changePassword(Request $request)  {
        $oldpassword=$request->input('password');
        $newpassword=$request->input('newpassword');
        $enrollment=\Session::get('enrollment');
        $pw=DB::table('student')->where('enrollment', $enrollment)->value('password');

        if(Hash::check($oldpassword, $pw))  {
            $hashedPassword=Hash::make($newpassword);
            DB::table('student')
            ->where('enrollment',$enrollment)
            ->update(['password'=>$hashedPassword]);
            return redirect('/home')->with('success','Your password is changed successfully');
        }
        else  {
            return redirect('setting')->with('wrong','Your Given Password is Wrong');
        }
    }

    public function otp(Request $request)  {
        $otp1=$request->input('otp');
        $enroll=$request->session()->get('enroll');
        $mobileNumber=$request->session()->get('mobileNumber');
        $authKey = "Your AUTHKEY";
        $senderId = "NAME You want to display in message(only 6 Letters)";

        $url="https://control.msg91.com/api/verifyRequestOTP.php?authkey=$authKey&mobile=$mobileNumber&otp=$otp1";

        $curl = curl_init($url);

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $res=(String)$response;

        curl_close($curl);

        if ($err) {
          return redirect('/')->with('wrong4',"OTP doesn't match. Enter valid OTP.");
        }
        else {
            if(preg_match('/\bsuccess\b/', $res))  {
                DB::update('update student set active = 1 where enrollment = ?', [$enroll]);
                return redirect('/')->with('success',"Username and Password Sended to your registered Email ID.");
                $request->session()->forget('enroll');
                $request->session()->forget('mobileNumber');
            }
            else {
                return redirect('/')->with('wrong4',"OTP doesn't match. Enter valid OTP.!!!");
            }
        }
    }

    public function resendotp(Request $request)  {
        $authKey = "Your AUTHKEY";
        $mobileNumber=$request->session()->get('mobileNumber');

        $url="http://control.msg91.com/api/retryotp.php?authkey=$authKey&mobile=$mobileNumber&retrytype=";

        $curl = curl_init($url);

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return redirect('/')->with('wrong4',"There is an error. Please try again.!!!");
          }

        return redirect('/')->with('successOTP',"Resending OTP via Voice.!!!");
    }
}
