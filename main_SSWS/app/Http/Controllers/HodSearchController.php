<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HodSearchController extends Controller
{
    function index()
    {
     return view('hod.search');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      //Student Details Start___________________________________________________
      $output = '';
      $department=\Session::get('department');
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('student_info')
         ->where('name', 'like', '%'.$query.'%')
         ->where('branch',$department)
         ->orWhere('enrollment', 'like', '%'.$query.'%')
         ->orWhere('branch', 'like', '%'.$query.'%')
         ->orWhere('semester', 'like', '%'.$query.'%')
         ->get();

      }
      else
      {
       $data = DB::table('student_info')
         ->where('branch',$department)
         ->orderBy('name')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {

        $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->enrollment.'</td>
         <td>'.$row->branch.'</td>
         <td>'.$row->semester.'</td>
         <td>
            <span class="btn btn-primary" align=center onclick=getData("'.$row->enrollment.'")>show</span>
         </td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }

      //Student Details End______________________________________________________

      //Faculty Details Start_____________________________________________________

      $output2 = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('faculty_info')
         ->where('department',$department)
         ->where('f_name', 'like', '%'.$query.'%')
         ->orWhere('faculty_id', 'like', '%'.$query.'%')
         ->orWhere('department', 'like', '%'.$query.'%')
         ->orWhere('l_name', 'like', '%'.$query.'%')
         ->get();

      }
      else
      {
       $data = DB::table('faculty_info')
       ->where('department',$department)
         ->orderBy('f_name')
         ->get();
      }
      $total_row2 = $data->count();
      if($total_row2 > 0)
      {
       foreach($data as $row)
       {

        $output2 .= '
        <tr>
         <td>'.$row->f_name.' '.$row->l_name.'</td>
         <td>'.$row->faculty_id.'</td>
         <td>'.$row->department.'</td>
         <td>
         <form action="getfacultyinfo" method=post>
         <span class="btn btn-primary" onclick=getFacultyData("'.$row->faculty_id.'")>show</span>
         </td>
        </tr>
        ';
       }
      }
      else
      {
       $output2 = '
       <tr>
        <td align="center" colspan="4">No Data Found</td>
       </tr>
       ';
      }

      //Faculty Details End________________________________________________________
      $data = array(
       'stable_data'  => $output,
       'stotal_data'  => $total_row,
       'ftable_date' => $output2,
       'ftotal_data' => $total_row2
      );

      echo json_encode($data);
     }
    }

    public function getInfo(Request $request)
    {
        $enrollment=$request->input('enrollment');
        $details=DB::table('student_info')
        ->where('enrollment',$enrollment)
        ->get();

        $leaves=DB::table('student_applications')
        ->where('enrollment',$enrollment)
        ->orderBy('submitted_date')->paginate(5);

        $data=DB::table('student_applications')
        ->where('enrollment',$enrollment)
        ->where('status','confirmed')->get();

        $data1=DB::table('student_applications')
        ->where('enrollment',$enrollment)
        ->where('status','pending')->get();

        $approved=$data->count();
        $pending=$data1->count();

        $total=$leaves->count();
       return view('hod.student_info',compact('leaves','details','approved','pending','total'));

    }

    function getFacultyInfo(Request $request)
    {

        $faculty_id=$request->get('id');
        $faculty_info=DB::table('faculty_info')->where('faculty_id',$faculty_id)->get()->first();
        $faculty_name=$faculty_info->f_name." ".$faculty_info->l_name;

        $approved_leave=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->where('director_status','confirm')->get()->unique('leave_id');
        $approved=count($approved_leave);

        $rejected_leave=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->where('director_status','rejected')->get()->unique('leave_id');
        $rejected=count($rejected_leave);

        $pending_leave=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->where('director_status','pending')->get()->unique('leave_id');
        $pending=count($pending_leave);

        $leave_details=DB::table('faculty_applications')->where('faculty_id',$faculty_id)->get();

        return view('hod.faculty_info',compact('faculty_info','approved','rejected','pending','faculty_name','leave_details'));
    }



}
