<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Mail;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class FacultyController extends Controller
{
    function login(Request $request)
    {
        $faculty_id=$request->input('facultyID');
        $password=$request->input('password');
        $fname=DB::table('faculty_info')->where('faculty_id', $faculty_id)->value('f_name');
        $lname=DB::table('faculty_info')->where('faculty_id', $faculty_id)->value('l_name');
        $department=DB::table('faculty_info')->where('faculty_id', $faculty_id)->value('department');
        $mNo=DB::table('faculty_info')->where('faculty_id', $faculty_id)->value('mobile_no');
        $name=$fname." ".$lname;
        $f_sn=DB::table('faculty')->where('faculty_id', $faculty_id)->value('f_sn');

        $checklogin=DB::table('faculty')->where(['faculty_id'=>$faculty_id])->get();
        if(count($checklogin)>0)
        {
            $pw=DB::table('faculty')->where('faculty_id', $faculty_id)->value('password');

            if(Hash::check($password, $pw))
            {
                if (DB::table('faculty')->where('faculty_id',$faculty_id)->value('active')==1)  {
                    $request->session()->put('logged_in',$name);
                    $request->session()->put('faculty_id',$faculty_id);
                    $request->session()->put('f_sn',$f_sn);
                    $request->session()->put('department',$department);
                    return redirect('/home');
                }
                else  {
                    $authKey = "Your AUTHKEY";
                    $senderId = "NAME You want to display in message(only 6 Letters)";

                    $message = 'Dear User, your One Time Password for registering in SSWS system is ##OTP##.';
                    $postData = array(
                        'authkey' => $authKey,
                        'mobiles' => $mNo,
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

                    $request->session()->put('mobileNumber',$mNo);
                    $request->session()->put('fid',$faculty_id);

                    return redirect('/')->with('firstverify',"To get acces, first verify your number by OTP sended to you.");
                }
            }
            else  {
                return redirect('/')->with('wrong','Invalid Faculty ID or Password!!!');
            }
        }
        else
        {
            return redirect('/')->with('wrong','You are not Registered!!!');
        }
    }

    public function userLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function fp(Request $request){

        $email1=\Request::Input('email');
        $email2=DB::table('faculty_info')->where('email',$email1)->value('email');
        $faculty_id=DB::table('faculty_info')->where('email',$email1)->value('faculty_id');
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $password = substr($random, 0, 10);
        $hashpass = Hash::make($password);
        $fname=DB::table('faculty_info')->where('email',$email2)->value('f_name');
        $lname=DB::table('faculty_info')->where('email',$email2)->value('l_name');
        $name=$fname." ".$lname;

        $data = array('name'=>$name,'facultyid'=>$faculty_id,'password'=>$password);

        if($email1==$email2)
        {
            Mail::send(['text'=>'faculty.cp'], $data, function($message) {
                $message->to(\Request::Input('email'),\Request::Input('fname')." ".\Request::Input('lname'))->subject
                    ('Student & Staff Welfare System - Reset Password');
                $message->from('Mail You are using to send Email','Student & Staff Welfare System');
            });
            DB::table('faculty')->where('faculty_id',$faculty_id)->update(['password'=>$hashpass]);
            return redirect('/')->with('success1',"New Password Sended to your registered Email ID!!");
        }
        else
        {
            return redirect('/')->with('wrong1',"No Match Found!!");
        }
    }

    public function facultyotp(Request $request)  {
        $otp1=$request->input('otp');
        $mobileNumber=$request->session()->get('mobileNumber');
        $fid=$request->session()->get('fid');
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
                return redirect('/')->with('success5',"OTP verified. Now, change your password!!!");
                $request->session()->forget('mobileNumber');
            }
            else {
                return redirect('/')->with('wrong4',"OTP doesn't match. Enter valid OTP.!!!");
            }
        }
    }

    public function frotp(Request $request)  {

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

    public function change(Request $request)
    {
        $newpassword=$request->input('np');
        $hashpass3 = Hash::make($newpassword);
        $fid=$request->session()->get('fid');
        DB::table('faculty')->where('faculty_id',$fid)->update(['password'=>$hashpass3,'active'=>1]);

        return redirect('/')->with('success','Now, Log In with your new Password!!');
    }

    public function forgotpassword(Request $request){

        $email1=\Request::Input('email');
        $email2=DB::table('faculty_info')->where('email',$email1)->value('email');
        $faculty_id=DB::table('faculty_info')->where('email',$email1)->value('faculty_id');
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890');
        $password = substr($random, 0, 10);
        $hashpass = Hash::make($password);
        $data = array('name'=>DB::table('faculty_info')->where('faculty_id',$faculty_id)->value('name'),
            'faculty'=>$faculty_id,
            'password'=>$password);

        if($email1==$email2)
        {
            Mail::send(['text'=>'user.forgotpassword'], $data, function($message) {
                $message->to(\Request::Input('email'), DB::table('faculty_info')->where('enrollment',\Request::Input('enrollment'))->value('name'))->subject
                    ('Student & Staff Welfare System - Reset Password');
                $message->from('Mail you are using to send Email','Student & Staff Welfare System');
            });
            DB::table('faculty')->where('enrollment',$enroll)->update(['password'=>$hashpass]);
            return redirect('/')->with('success1',"New Password Sended to your registered Email ID!!");
        }
        else
        {
            return redirect('/')->with('wrong1',"No Match Found!!");
        }
    }

    public function home(Request $request)
    {
        $faculty_id=\Session::get('faculty_id');
        $department=\Session::get('department');
        $dt=Carbon::now('Asia/Kolkata');
        $today=$dt->format('Y-m-d');

        $check=DB::table('faculty_applications')->where('leave_date','>=',$today)->select('lec_id')->get();
        $details=array();
        $j=0;

        #Displaying Lecture request start____________________________
        foreach ($check as $key => $value) {
            $lec_id=$value->lec_id;
            $given_lecture=DB::table('lecture_arrangement')->where('lec_id',$lec_id)->get();
            foreach ($given_lecture as $key2 => $value2) {
                for($i=1;$i<=6;$i++)
                {
                    $lec='lecture'.$i;
                    if($value2->$lec==$faculty_id)
                    {
                        $class="class".$i;
                        $status="status".$i;
                        if($value2->$status=="pending")
                        {
                            $get_id=DB::table('faculty_applications')->where('lec_id',$lec_id)->get();
                            $get_faculty_id=$get_id[0]->faculty_id;

                            $get_faculty_details=DB::table('faculty_info')->where('faculty_id',$get_faculty_id)->select('f_name','l_name')->get();

                            $full_name=$get_faculty_details[0]->f_name." ".$get_faculty_details[0]->l_name;
                            $class=$value2->$class;
                            $date=$get_id[0]->leave_date;
                            $b=array('lecture'=>$i,'class'=>$class,'name'=>$full_name,"date"=>$date,"lec_id"=>$lec_id);
                            $details[$j]=$b;
                            $j+=1;
                        }
                    }
                }

            }
        }

        #Displaying Lecture request end___________________________________________

        $check=DB::table('faculty_applications')->where('leave_date','>=',$today)->where('faculty_id',$faculty_id)->select('lec_id','leave_date','hod_status','director_status')->get();

        $pending_details=array();
        $get_status=array();
        foreach ($check as $key => $value) {
            $lec_id=$value->lec_id;
            $given_lecture=DB::table('lecture_arrangement')->where('lec_id',$lec_id)->get();
            foreach ($given_lecture as $key2 => $value2) {
                $lec_details=array();
                for($i=1;$i<=6;$i++)
                {
                    $status='status'.$i;
                    $lecture='lecture'.$i;
                    if($value2->$status!=null){

                        $lec_details[$i]=array('lec_id'=>$i,'status'=>$value2->$status);
                        $fac_id=$value2->$lecture;
                        $name_fac=DB::table('faculty_info')->select('f_name','l_name')->where('faculty_id',$fac_id)->get();
                        $fac_name=$name_fac[0]->f_name." ".$name_fac[0]->l_name;
                        $lec_details[$i]=array('lec_id'=>$i,'status'=>$value2->$status,'faculty_name'=>$fac_name);
                    }
                }
                $dt=$value->leave_date;
                $dt=explode('-',$dt);
                $date=$dt[2]."-".$dt[1]."-".$dt[0];
                $pending_details[$date]=$lec_details;
                $get_status[$date]=array('hod_status'=>$value->hod_status,'director_status'=>$value->director_status);
            }
        }

        return view('faculty.home', ['details' => $details,'pending_details'=>$pending_details,'get_status'=>$get_status]);
    }

    function profile(Request $request)
    {
        $faculty_id=\Session::get('faculty_id');
        $faculty_info=DB::table('faculty_info')->where('faculty_id',$faculty_id)->get()->first();
        $faculty_name=$faculty_info->f_name." ".$faculty_info->l_name;

        $approved_leave=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->where('director_status','confirm')->get()->unique('leave_id');
        $approved=count($approved_leave);

        $rejected_leave=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->where('director_status','rejected')->get()->unique('leave_id');
        $rejected=count($rejected_leave);

        $pending_leave=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->where('director_status','pending')->get()->unique('leave_id');
        $pending=count($pending_leave);

        $leave=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->get();
        $leave_details=array();
        foreach ($leave->unique('leave_id') as $key => $value) {
            array_push($leave_details,$value);
        }

        return view('faculty.profile',compact('faculty_info','approved','rejected','pending','faculty_name','leave_details'));
    }

    public function changePassword(Request $request)
    {
        $oldpassword=$request->input('password');
        $newpassword=$request->input('newpassword');
        $faculty_id=\Session::get('faculty_id');

        $pw=DB::table('faculty')->where('faculty_id', $faculty_id)->value('password');

        if(Hash::check($oldpassword, $pw))
        {
            $hashedPassword=Hash::make($newpassword);
            DB::table('faculty')
            ->where('faculty_id',$faculty_id)
            ->update(['password'=>$hashedPassword]);
            return redirect('/home')->with('success','Your password is changed successfully');
        }
        else
        {
            return redirect('setting')->with('wrong','Your Given Password is Wrong');
        }
    }
}

