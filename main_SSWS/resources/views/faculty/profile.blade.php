{{-- UPDATE `student_info` SET `image`= LOAD_FILE('j:\\raja.jpg') WHERE enrollment='150860116031' --}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
@extends('faculty.layout')

@section('content')

<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
    <div class="card card-small">
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10" style="margin-left:20px;margin-top:10px"><h1>{{$faculty_name}}</h1></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->


      <div class="text-center">
          <?php
            // $query=DB::table('student_info')->select('image')->where('enrollment',$details[0]->enrollment)->first();
            // echo '
            //     <img src="data:image/jpeg;base64,'.base64_encode($query->image).'" class="user-avatar rounded-circle mr-2" height="150" width="150" />
            //     ';

            ?>
        <img src="admin/images/avatars/0.jpg" class="user-avatar rounded-circle mr-2" alt="avatar">
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
                {{$rejected}}
            </div>
            <div class="panel-body">
                <b>Total Leave Submitted:</b>
                {{$pending+$rejected+$approved}}
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
                            <td><b>First Name:</b> </td>
                            <td>{{$faculty_info->f_name}}</td>
                        </tr>
                        <tr>
                            <td><b>Middle Name:</b> </td>
                            <td>{{$faculty_info->m_name}}</td>
                        </tr>
                        <tr>
                            <td><b>Last Name:</b> </td>
                            <td>{{$faculty_info->l_name}}</td>
                        </tr>
                        <tr>
                            <td><b>Faculty ID:</b> </td>
                            <td>{{$faculty_info->faculty_id}}</td>
                        </tr>
                        <tr>
                            <td><b>Email:</b> </td>
                            <td>{{$faculty_info->email}}</td>
                        </tr>
                        <tr>
                            <td><b>Department:</b> </td>
                            <td>{{$faculty_info->department}}</td>
                        </tr>
                        <tr>
                            <td><b>Mobile No:</b> </td>
                            <td>{{$faculty_info->mobile_no}}</td>
                        </tr>
                        <tr></tr>
                    </table>
                    </div>
                </div><!--/tab-pane-->

                <div class="tab-pane" id="messages">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Leave Date</th>
                                    <th>Type of Leave</th>
                                    <th>Submmited Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leave_details as $key=>$item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <?php
                                            $date=$item->leave_date;
                                            $d=explode('-',$date);
                                        ?>
                                        <td>{{$d[2].'-'.$d[1].'-'.$d[0]}}</td>
                                        <td>{{$item->type_of_leave}}</td>
                                        <?php
                                            $date=$item->submitted_date;
                                            $d=explode('-',$date);
                                        ?>
                                        <td>{{$d[2].'-'.$d[1].'-'.$d[0]}}</td>
                                        @if ($item->director_status=='confirm')
                                            <td class="text-success"><b>{{$item->director_status}}</b></td>
                                        @endif
                                        @if($item->director_status=='rejected')
                                            <td class="text-danger"><b>{{$item->director_status}}</b></td>
                                        @endif
                                        @if($item->director_status=='pending')
                                            <td class="text-warning"><b>{{$item->director_status}}</b></td>
                                        @endif
                                        <td>
                                            <form action="leavedetails" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value={{$item->leave_id}}>
                                                <button type="submit" class="btn btn-primary">View More</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
          </div>

        </div>
    </div>
</div>
</div>
</div>
@endsection
