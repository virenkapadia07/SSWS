<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    function index()
    {
     return view('admin.search');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
         //Student Details Start___________________________________________________
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('student_info')
         ->where('name', 'like', '%'.$query.'%')
         ->orWhere('enrollment', 'like', '%'.$query.'%')
         ->orWhere('branch', 'like', '%'.$query.'%')
         ->orWhere('semester', 'like', '%'.$query.'%')
         ->get();

      }
      else
      {
       $data = DB::table('student_info')
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
            <span class="btn btn-primary" onclick="getData('.$row->enrollment.')">show</span>
            <span class="btn btn-warning" onclick="edit('.$row->enrollment.')">edit</span>
            <span class="btn btn-danger" onclick="delete1('.$row->enrollment.')">delete</span>
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
         ->where('f_name', 'like', '%'.$query.'%')
         ->orWhere('faculty_id', 'like', '%'.$query.'%')
         ->orWhere('department', 'like', '%'.$query.'%')
         ->orWhere('l_name', 'like', '%'.$query.'%')
         ->get();

      }
      else
      {
       $data = DB::table('faculty_info')
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
            <span class="btn btn-primary" onclick=getDataf("'.$row->faculty_id.'")>show</span>
            <span class="btn btn-warning" onclick=editf("'.$row->faculty_id.'")>edit</span>
            <span class="btn btn-danger" onclick=deletef("'.$row->faculty_id.'")>delete</span>
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
        return view('admin.student_info',compact('leaves','details','approved','pending','total'));
    }

    public function edit(Request $request)
    {
        $enrollment=$request->input('enrollment');
        $details=DB::table('student_info')
        ->where('enrollment',$enrollment)->get();

        return view('admin.student_form',compact('details'));
    }

    public function update(Request $request)
    {
        $id=$request->input('id');
        $name=$request->input('name');
        $enrollment=$request->input('enrollment');
        $email=$request->input('email');
        $branch=$request->input('branch');
        $semester=$request->input('semester');
        $mobileNo=$request->input('mobileNo');
        $f=$_FILES['photo'];
        if($f['size']==0)
        {
            DB::table('student_info')
            ->where('id',$id)
            ->update(['name'=>$name,'enrollment'=>$enrollment,'email'=>$email,'branch'=>$branch,
                'semester'=>$semester,'mobileNo'=>$mobileNo]);

            return redirect('search')->with('success','Student details has been updated');
        }
        else
        {
            $file = file_get_contents($_FILES["photo"]["tmp_name"]);

            DB::table('student_info')
            ->where('id',$id)
            ->update(['name'=>$name,'enrollment'=>$enrollment,'email'=>$email,'branch'=>$branch,
                'semester'=>$semester,'mobileNo'=>$mobileNo,'image'=>$file]);

            return redirect('search')->with('success','Student details has been updated');
        }
    }

    public function delete(Request $request){
        $enrollment=$request->input('enrollment');

        DB::table('student_info')
        ->where('enrollment',$enrollment)
        ->delete();

        return redirect('search')->with('success','Student record deleted');
    }
}
