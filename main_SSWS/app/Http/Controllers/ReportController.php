<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Session;


class ReportController extends Controller
{
    function index(Request $request)
    {

        $details=DB::table('student_info')->orderBy('semester')
        ->get(['enrollment','name','semester','branch']);



        return view('admin.report',compact('details'));
    }

    function get_customer_data()
    {
     $customer_data = DB::table('student_applications')
         ->limit(10)
         ->get();
     return $customer_data;
    }

    function pdf(Request $request)
    {
        $date=date('Y-m-d_H:i:s');
        $pdf = \App::make('dompdf.wrapper');

        $sem=Session::get('sem');
        $branch=Session::get('branch');
        $customer_data =$details=DB::table('student_info')
                    ->where('semester',$sem)
                    ->where('branch',$branch)
                    ->orderBy('name')
                    ->get(['enrollment','name','semester','branch']);
        if($customer_data->count()==0)
        {
            return redirect('report')->with('wrong','No Data Found');
        }
        $output = '
        <style>
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;

                /** Extra personal styles **/
                text-align: center;
            }
            header {
                position: fixed;
                top:-30px;
                font-size:9px;

                /** Extra personal styles **/

            }
            .pagenum:before {
                content: counter(page);
            }
        </style>
        <h1 align="center">SSWS -Student Leave Report Generation For Semester '. $sem .' </h1>
        <table width="100%" style="border-collapse: collapse; border: 0px;padding-top:50px">
        <tr>
            <th style="border: 1px solid; padding:12px;" width="20%">Name</th>
            <th style="border: 1px solid; padding:12px;" width="30%">Enrollment</th>
            <th style="border: 1px solid; padding:12px;" width="15%">Semester</th>
            <th style="border: 1px solid; padding:12px;" width="15%">Branch</th>
            <th style="border: 1px solid; padding:12px;" width="20%">Total Leave</th>
        </tr>
        ';
        foreach($customer_data as $customer)
        {
            $leave=DB::table('student_applications')
            ->where('enrollment',$customer->enrollment)
            ->where('status','confirmed')->count();
            $date=date('Y-m-d_H:i:s');
            $output .= '
            <tr>
                <td style="border: 1px solid; padding:12px;">'.$customer->name.'</td>
                <td style="border: 1px solid; padding:12px;">'.$customer->enrollment.'</td>
                <td style="border: 1px solid; padding:12px;">'.$customer->semester.'</td>
                <td style="border: 1px solid; padding:12px;">'.$customer->branch.'</td>
                <td style="border: 1px solid; padding:12px;">'.$leave.'</td>
            </tr>
                ';
        }
        $output .= '</table>';

        $output.=
        '<footer>
            Page <span class="pagenum"></span>
        </footer>

        <header>
            <span style="text-align:right">generated: '.$date.'</span>
        </header>';
        $pdf->loadHTML($output);
        return $pdf->download($date.'.pdf');
    }

    public function report(Request $request)
    {
        $sem=$request->input('sem');
        $branch=$request->input('branch');

        $details=DB::table('student_info')
        ->where('semester',$sem)
        ->where('branch',$branch)
        ->orderBy('name')
        ->get(['enrollment','name','semester','branch']);

        $request->session()->put('sem', $sem);
        $request->session()->put('branch', $branch);

        return view('admin.report',compact('details'));
    }
}
