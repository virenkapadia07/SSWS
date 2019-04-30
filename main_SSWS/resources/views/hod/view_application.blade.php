@extends('hod.hod_layout')

@section('content')
<div class="container" style="margin-left:180px" >
    <?php
        DB::table('student_applications')
        ->where('id','=',$details[0]->id)
        ->update(['notification'=>2]);
    ?>
        <div class="row" style="margin-top:10px">
                <div class="col-lg-8 col-md-5 col-sm-10 mb-3">
                <div class="card">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="padding:20px">{{$details[0]->name}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " style="padding-left:30px">
                                <?php
                                    $query=DB::table('student_info')->select('image')->where('enrollment',$details[0]->enrollment)->first();
                                echo '
                                <img src="data:image/jpeg;base64,'.base64_encode($query->image).'" class="rounded-circle" height="150" width="150" />
                                ';

                                ?>
                            </div>

                                <div class=" col-md-9 col-lg-8 ">
                                    <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>Enrollment Number:</td>
                                        <td>{{$details[0]->enrollment}}</td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td>Semester:</td>
                                        <td>{{$details[0]->semester}}</td>
                                    </tr>
                                    <tr>
                                        <td>Type Of Leave</td>
                                        <td>{{$details[0]->type_of_leave}}</td>
                                    </tr>
                                    <tr>
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
                                    <tr>
                                        <td>Mobile Number:</td>
                                        <td>{{$details[0]->mobileNo}}</td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    <span style="padding:40px"></span>
                                    <form action="approve" method="post" align="center">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value={{$id}}>
                                        <button type="submit" class="btn btn-success" style="font-size:20px;padding:10px">Approve</button>
                                    </form>
                                    <span style="padding:1px"></span>
                                    <form action="reject" method="post" align="center">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value={{$id}}>
                                        <button type="submit" class="btn btn-danger" style="font-size:20px;">Reject</button>
                                    </form>
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
