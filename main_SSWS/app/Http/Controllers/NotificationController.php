<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NotificationController extends Controller
{
    public function studentNotification(Request $request)
    {
        $id=$request->input('id');

        $details=DB::table('student_info')
        ->join('student_applications','student_applications.enrollment','=','.student_info.enrollment')
        ->where('student_applications.id','=',$id)->get();

        return view('user.notification',compact('details','id'));
    }
}
