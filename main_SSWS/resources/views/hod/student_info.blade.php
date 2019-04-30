{{-- UPDATE `student_info` SET `image`= LOAD_FILE('j:\\raja.jpg') WHERE enrollment='150860116031' --}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
@extends('hod.hod_layout')

@section('content')

<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
    <div class="card card-small">
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10" style="margin-left:20px;margin-top:10px"><h1>{{$details[0]->name}}</h1></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->

      <div class="text-center">
          <?php
            $query=DB::table('student_info')->select('image')->where('enrollment',$details[0]->enrollment)->first();
            echo '
                <img src="data:image/jpeg;base64,'.base64_encode($query->image).'" class="user-avatar rounded-circle mr-2" height="150" width="150" />
                ';

            ?>
        {{-- <img src="admin/images/avatars/0.jpg" class="user-avatar rounded-circle mr-2" alt="avatar"> --}}
      </div></hr><br>


          <div class="panel panel-default">
            <div class="panel-heading">Leave Overview</div>
            <div class="panel-body">
                <b>Pending Leave:</b>
                {{$pending}}
            </div>
            <div class="panel-body">
                <b>Approved Leave:</b>
                {{$approved}}
            </div>
            <div class="panel-body">
                <b>Rejected Leave:</b>
                {{$total-$approved-$pending}}
            </div>
            <div class="panel-body">
                <b>Total Leave Submitted:</b>
                {{$total}}
            </div>
          </div>

        </div><!--/col-3-->
    	<div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                <li><a data-toggle="tab" href="#messages">Leave</a></li>
              </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <div style="margin-top:20px">
                    <table class="table table-striped">
                        <tr>
                            <td><b>Name:</b> </td>
                            <td>{{$details[0]->name}}</td>
                        </tr>
                        <tr>
                            <td><b>Enrollment:</b> </td>
                            <td>{{$details[0]->enrollment}}</td>
                        </tr>
                        <tr>
                            <td><b>Email:</b> </td>
                            <td>{{$details[0]->email}}</td>
                        </tr>
                        <tr>
                            <td><b>Branch:</b> </td>
                            <td>{{$details[0]->branch}}</td>
                        </tr>
                        <tr>
                            <td><b>Semester:</b> </td>
                            <td>{{$details[0]->semester}}</td>
                        </tr>
                        <tr>
                            <td><b>Mobile No:</b> </td>
                            <td>{{$details[0]->mobileNo}}</td>
                        </tr>
                        <tr></tr>
                    </table>
                    </div>
                </div><!--/tab-pane-->
			 <!--Leave Management.................................................   -->
                <div class="tab-pane" id="messages">

                    <table class="table table-striped" style="margin-top:20px">
                        <thead>
                            <tr>
                                <th>Type of Leave</th>
                                <th>Reason</th>
                                <th>Leave Time</th>
                                <th>To Date</th>
                                <th>From Date</th>
                                <th>Submitted Time</th>
                                <th>Submitted Date</th>
                                <th>Status</th>
                            </tr>
                        <thead>
                        <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                                <td>{{$leave->type_of_leave}}</td>
                                <td>{{$leave->reason}}</td>
                                <td>{{$leave->leave_time}}</td>
                                <td>{{$leave->leave_to_date}}</td>
                                <td>{{$leave->leave_from_date}}</td>
                                <td>{{$leave->submitted_time}}</td>
                                <td>{{$leave->submitted_date}}</td>
                                <td>{{$leave->status}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="display: flex;justify-content: center;">
                    {{$leaves->links()}}
                </div>
                </div>
          </div>

        </div>
    </div>
</div>
</div>
</div>
@endsection
