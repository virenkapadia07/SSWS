@extends('user.layout')

@section('content')

<div class="container"  style="margin-top:20px;margin-left:120px">
    <?php
        DB::table('student_applications')
        ->where('id','=',$details[0]->id)
        ->update(['notification'=>1]);
    ?>
        <div class="row" >
                <div class="col-lg-9 col-md-4 col-sm-5 mb-2">
                <div class="card">
                <div class="panel panel-info" style="margin-left:150px">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="padding:20px">{{$details[0]->type_of_leave}}</h3>
                    </div>
                    <div class="panel-body" style="margin-left:80px">
                        <div class="row">

                                <div class=" col-md-9 col-lg-8 ">
                                    <table class="table table-user-information">
                                    <tbody>
                                        <td>Reason</td>
                                        <td>{{$details[0]->reason}}</td>
                                    </tr>

                                    <tr>
                                    <tr>
                                        <td>Leave Time</td>
                                        <td>{{$details[0]->leave_time}}</td>
                                    </tr>
                                    <tr>
                                        <td>To Date</td>
                                        <td>{{$details[0]->leave_to_date}}</td>
                                    </tr>
                                    <tr>
                                        <tr>
                                        <td>From Date</td>
                                        <td>{{$details[0]->leave_to_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Submiited Time</td>
                                        <td>{{$details[0]->submitted_time}}</td>
                                    </tr>
                                        <td>Submiited Date</td>
                                        <td>{{$details[0]->submitted_date}}</td>
                                    </tr>
                                    <tr>
                                    @if ($details[0]->status=='confirmed')
                                        <td>Status:</td>
                                        <td class="text-success"><b>{{$details[0]->status}}</b></td>
                                    @else
                                        <td>Status:</td>
                                        <td class="text-danger"><b>{{$details[0]->status}}</b></td>
                                    @endif
                                    </tbody>
                                    </table>
                                    <span style="padding:20px"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
        </div>
    </div>

@endsection
