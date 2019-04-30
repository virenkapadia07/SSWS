<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class FacultyLeaveController extends Controller
{
    function getTypeofLeaveResult(Request $request)
    {
        $main_number_of_days=0;
        if($request->ajax())
        {
            $output = '';
            $second_output= '';
            $no_of_days =(int) $request->get('no_of_days');
            $to_date = $request->get('to_date');
            $from_date = $request->get('from_date');
            $leave_type=$request->get('leave');
            $od=$request->get('od');
            $faculty_id=\Session::get('faculty_id');
            $query=DB::table('leave_avaliable')->where('faculty_id',$faculty_id)->get();
            $cl=$query[0]->cl;
            $rh=$query[0]->rh;
            $fdate=explode("-",$from_date);
            $tdate=explode("-",$to_date);
            $dt=Carbon::create($fdate[0],$fdate[1],$fdate[2]-1);
            if($no_of_days<=8)
            {

                for($i=0;$i<$no_of_days;$i++)
                {
                    $dt=$dt->addDay();
                    $dt->toDateString();
                    $tmp_dt=$dt->year.'-'.$dt->month.'-'.$dt->day;
                    $check=DB::table('holidays')->where('date',$tmp_dt)->get();
                    $type_of_leave="";
                    $lwp=0;
                    $check_rh=DB::table('holidays')->where('date',$tmp_dt)->where('type','RH')->get();
                    $check_holidays=DB::table('holidays')->where('date',$tmp_dt)->where('type','H')->get();
                    $check_ph=DB::table('holidays')->where('date',$tmp_dt)->where('type','PH')->get();

                    if($check=="[]" || $check_rh!="[]")
                    {
                        if($od=="od")
                        {
                            $type_of_leave="OD";
                            $main_number_of_days+=1;
                        }
                        else if($leave_type=='ml')
                        {
                            $type_of_leave="ML";
                            $main_number_of_days+=1;
                        }
                        else
                        {
                            if($cl==1)
                            {
                                $type_of_leave="CL";
                                $cl=0;
                                $main_number_of_days+=1;
                            }
                            else if($rh>0 && $check_rh!="[]")
                            {
                                $type_of_leave="RH";
                                $rh-=1;
                                $main_number_of_days+=1;
                            }
                            else {
                                $type_of_leave="LWP";
                                $lwp+=1;
                                $main_number_of_days+=1;
                            }
                        }
                }
                    if($check=="[]" || $check_rh!="[]"){
                        $tmp_dt=$dt->day.'-'.$dt->month.'-'.$dt->year;
                        $main_dt=$dt->year.'-'.$dt->month.'-'.$dt->day;
                    $output .= '
                    <tr>
                    <td>'.$tmp_dt.'
                    <input type="hidden" name="date'.$main_number_of_days.'" value="'.$main_dt.'"/></td>
                    <td>
                    <input type="hidden" name="leavetype'.$main_number_of_days.'" value="'.$type_of_leave.'"/>'.$type_of_leave.'</td>
                    </tr>';

                    $second_output .= '<input type="hidden" id="sdate'.$main_number_of_days.'" value="'.$main_dt.'"/>';
                    }
                }
            }
            else {
                $output .='<tr>
                    <td colspan=3 align=center>No Data Found</td>
                </tr>';

                $second_output='';
            }
            $output .='<input type="hidden" name="total_days" value="'.$main_number_of_days.'"/>';
            $second_output .='<input type="hidden" id="stotal_days" value="'.$main_number_of_days.'"/>';

        }
        $request->session()->put('total_days',$main_number_of_days);
      $data = array(
        'table_data'  => $output,
        'second_data' => $second_output
    );
    echo json_encode($data);
    }

    function getLeaveResult(Request $request){
        $output='';
        $total_days=\Session::get('total_days');
        $f_sn=\Session::get('f_sn');
        $dates=$request->get('dates');
        $get_date=explode(",",$dates);

        if($request->ajax()){
            for($i=1;$i<=$total_days;$i++)
            {
                $fdate=explode("-",$get_date[$i-1]);
                $dt=Carbon::create($fdate[0],$fdate[1],$fdate[2]);
                $today_day=$dt->format('l');

                $a= shell_exec("python python_script/php_python.py ".$today_day." ".$f_sn);
                $a=str_replace("'",'"',$a);
                $b=json_decode($a);


                $output .='<div class="card">
                <div class="card-header" id="heading'.$i.'">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">'.$get_date[$i-1].'</button>
                    </h5>
                </div>
                <div id="collapse'.$i.'" class="collapse show" aria-labelledby="heading'.$i.'" data-parent="#accordionExample">
					<div class="card-body">';
					foreach ($b as $key => $value)
					{
                        if($value!=null){
                            $splitting_key=explode("_",$key);
                            $lecture=$splitting_key[0];
                            $class=$splitting_key[1];

						$output .='<div class="form-group row" style="align:center">
                            <label class="col-sm-3 col-form-label"><b>Lecture '.$lecture.'</b></label>
                            <div class="col-md-4">
								<select name="lec_'.$i.'_'.$lecture.'" class="form-control">';
								for($j=0;$j<sizeof($value);$j++)
								{
                                    $all_details = DB::table('faculty_info')
                                    ->where('faculty_id', 'like', '%'.$value[$j].'%')->get();
                                    $name=$all_details[0]->f_name." ".$all_details[0]->l_name;
									$output .='<option value="'.$all_details[0]->faculty_id.'">'.$name.'</option>';
					            }
                     $output .='</select>
                                <input type="hidden" name="class_'.$i.'_'.$lecture.'" value="'.$class.'">
							</div>
                        </div>';
                            }
					}
				$output .='</div>
				</div>
            </div>';
            }
        }
        $data = array(
            'table_data'  => $output
        );
        echo json_encode($data);
    }

    function SubmitLeave(Request $request)
    {
        #calculating actual date by removing holidays
        $no_of_days=$request->get('total_days');

        #Number of days entered by user
        $total_days=$request->get('no_of_days');

        $faculty_id=\Session::get('faculty_id');
        $department=\Session::get('department');
        $reason=$request->get('reason');

        $dates=array();
        $leavetype=array();
        $allocated_faculty=array();
        $allocated_class=array();

        $todays_dt=Carbon::now('Asia/Kolkata');
        $submitted_date=$todays_dt->format('Y-m-d');
        $submited_time=$todays_dt->toTimeString();
        $type_of_leave=$request->get('type_of_leave');

        $f_sn=\Session::get('f_sn');
        $random = str_shuffle('0123456789');
        $leave_id=$f_sn.$todays_dt->format('md').substr($random, 0, 2);

        for($i=1;$i<=$total_days;$i++)
        {
            if($request->get('date'.$i))
            {
                $dates[$i]=$request->get('date'.$i);
            }
            if($request->get('date'.$i)){
                $leavetype[$i]=$request->get('leavetype'.$i);
            }
            for($j=1;$j<=6;$j++)
            {
                if($request->get('lec_'.$i."_".$j))
                {
                    $allocated_faculty[$i][$j]=$request->get('lec_'.$i."_".$j);
                    $allocated_class[$i][$j]=$request->get('class_'.$i."_".$j);
                }
            }
        }



        if($total_days<7)
        {
            $reason=$request->get('reason');

            foreach ($allocated_faculty as $key1 => $value1) {
                $lec_id=$f_sn.substr(str_shuffle($random), 0, 7);

                #data for leave applications table
                $faculty_applications=array();

                $faculty_applications['faculty_id']=$faculty_id;
                $faculty_applications['leave_id']=$leave_id;
                $faculty_applications['lec_id']=$lec_id;
                $faculty_applications['type_of_leave']=$leavetype[$key1];
                $faculty_applications['leave_date']=$dates[$key1];
                $faculty_applications['submitted_date']=$submitted_date;
                $faculty_applications['submitted_time']=$submited_time;
                $faculty_applications['hod_status']="pending";
                $faculty_applications['director_status']="pending";
                $faculty_applications['department']=$department;
                $faculty_applications['reason']=$reason;





                if($leavetype[$key1]=="OD")
                {
                    $faculty_applications['proof']=$file;
                    $file = file_get_contents($_FILES["proof"]["tmp_name"]);
                }

                #Making changes in Leave count table
                if($leavetype[$key1]=="CL"){
                    $cl=DB::table('leave_used')->select('cl')->where('faculty_id',$faculty_id)->get();
                    $cl_count=$cl[0]->cl+1;
                    DB::table('leave_used')->where('faculty_id',$faculty_id)->update(['cl'=>$cl_count]);

                    $total_cl_avaliable=DB::table('leave_avaliable')->select('total_cl_avaliable')->where('faculty_id',$faculty_id)->get();
                    DB::table('leave_avaliable')->where('faculty_id',$faculty_id)->update(['cl'=>0,'total_cl_avaliable'=>$total_cl_avaliable[0]->total_cl_avaliable-1,'last_cl_used'=>$submitted_date]);
                }
                else if($leavetype[$key1]=="RH"){
                    $rh=DB::table('leave_used')->select('rh')->where('faculty_id',$faculty_id)->get();
                    $rh_count=$rh[0]->rh+1;
                    DB::table('leave_used')->where('faculty_id',$faculty_id)->update(['rh'=>$rh_count]);

                    $total_rh=DB::table('leave_avaliable')->select('rh')->where('faculty_id',$faculty_id)->get();
                    DB::table('leave_avaliable')->where('faculty_id',$faculty_id)->update(['rh'=>$total_rh[0]->rh-1]);

                }
                else if($leavetype[$key1]=="LWP"){
                    $lwp=DB::table('leave_used')->select('lwp')->where('faculty_id',$faculty_id)->get();
                    $lwp_count=$lwp[0]->lwp+1;
                    DB::table('leave_used')->where('faculty_id',$faculty_id)->update(['lwp'=>$lwp_count]);
                }
                else if($leavetype[$key1]=="OD"){
                    $od=DB::table('leave_used')->select('od')->where('faculty_id',$faculty_id)->get();
                    $od_count=$od[0]->od+1;
                    DB::table('leave_used')->where('faculty_id',$faculty_id)->update(['od'=>$od_count]);
                }



                //-------------_________________
               DB::table('faculty_applications')->insert($faculty_applications);

                $lecture_arrangement=array();
                $lecture_arrangement['lec_id']=$lec_id;
                foreach ($value1 as $key2 => $value2) {
                    $lecture_arrangement['lecture'.$key2]=$value2;
                    $lecture_arrangement['status'.$key2]="pending";
                    $lecture_arrangement['class'.$key2]=$allocated_class[$key1][$key2];
                }
                DB::table('lecture_arrangement')->insert($lecture_arrangement);
            }
        }

        #for Marriage Leave________________________________________

        if($type_of_leave=="ML")
        {
            DB::table('leave_avaliable')->where('faculty_id',$faculty_id)->update(['ml'=>0]);
            DB::table('leave_used')->where('faculty_id',$faculty_id)->update(['ml'=>$no_of_days]);

            foreach ($allocated_faculty as $key1 => $value1) {
                $lec_id=$f_sn.substr(str_shuffle($random), 0, 7);

                $file = file_get_contents($_FILES["proof"]["tmp_name"]);
                $lec_id=$f_sn.substr(str_shuffle($random), 0, 7);

                #data for leave applications table
                $faculty_applications=array();

                $faculty_applications['faculty_id']=$faculty_id;
                $faculty_applications['leave_id']=$leave_id;
                $faculty_applications['lec_id']=$lec_id;
                $faculty_applications['type_of_leave']=$leavetype[$key1];
                $faculty_applications['leave_date']=$dates[$key1];
                $faculty_applications['submitted_date']=$submitted_date;
                $faculty_applications['submitted_time']=$submited_time;
                $faculty_applications['hod_status']="pending";
                $faculty_applications['director_status']="pending";
                $faculty_applications['proof']=$file;

                DB::table('faculty_applications')->insert($faculty_applications);

                $lecture_arrangement=array();
                $lecture_arrangement['lec_id']=$lec_id;
                foreach ($value1 as $key2 => $value2) {
                    $lecture_arrangement['lecture'.$key2]=$value2;
                    $lecture_arrangement['status'.$key2]="pending";
                    $lecture_arrangement['class'.$key2]=$allocated_class[$key1][$key2];
                }
                DB::table('lecture_arrangement')->insert($lecture_arrangement);
            }
        }
        return redirect('leave')->with('success',"Leave application submitted successfully");
    }

    function acceptLeave(Request $request)
    {
        $lec_id=$request->get('lec_id');
        $class=$request->get('clss');

        DB::table('lecture_arrangement')->where('lec_id',$lec_id)->update(['status'.$class=>"confirm"]);

        return redirect('home');

    }

    function rejectLeave(Request $request)
    {
        $lec_id=$request->get('lec_id');
        $class=$request->get('clss');

        DB::table('lecture_arrangement')->where('lec_id',$lec_id)->update(['status'.$class=>"rejected"]);

        return redirect('home');
    }

    function LeaveDetails(Request $request)
    {
        $leave_id=$request->get('id');
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
                    $b=array('lecture'=>$i,'class'=>$class,'name'=>$full_name,"lec_id"=>$lec_id,"status"=>$lec_details[0]->$status);
                    $lecture_details[$i]=$b;
                }
            }
        }

        return view('faculty.LeaveSummary',compact('lecture_details','leave_details','leav_details'));
    }
}

