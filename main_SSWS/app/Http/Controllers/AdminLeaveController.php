<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminLeaveController extends Controller
{
    public function DisplayPendingLeave()
    {
        $details=DB::table('student_info')
        ->join('student_applications','student_info.enrollment','=','.student_applications.enrollment')
        ->where('status','pending')->paginate(5);

        return view('admin.home', ['details' => $details]);
    }

    public function Show(Request $request)
    {
        $id=$request->input('id');
        $details=DB::table('student_info')
        ->join('student_applications','student_applications.enrollment','=','.student_info.enrollment')
        ->where('student_applications.id','=',$id)->get();
        return view('admin.view_application',compact('details','id'));

    }

    public function Approve(Request $request)
    {
        $id=$request->input('id');
        DB::table('student_applications')
        ->where('id','=',$id)
        ->update(['status'=>'confirmed','notification'=>0]);

        return redirect('display')->with('success','Leave has been approved :)');
    }

    public function Reject(Request $request)
    {
        $id=$request->input('id');
        DB::table('student_applications')
        ->where('id','=',$id)
        ->update(['status'=>'rejected','notification'=>0]);

        return redirect('display')->with('success','Leave has been rejected :(');
    }
}
