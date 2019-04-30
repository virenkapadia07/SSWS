@extends('gatekeeper.layout')

@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Result</span>
        <h3 class="page-title">Student Can Go</h3>
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
    <div class="card card-small">
        <div class="card-header border-bottom">
        <h6 class="m-0">{{$student[0]->name}}</h6>
        </div>
        <div class="container bootstrap snippet">
            <div class="row">
  		        <div class="col-sm-3">
                    <div class="text-center">
                        <?php
                            echo '
                            <img src="data:image/jpeg;base64,'.base64_encode($student[0]->image).'" class="user-avatar" height="500" width="500" style="padding:20px" />
                            '
                        ?>
                    </div><br>
                </div>
                <div class="col-sm-5" style="margin-left:300px;margin-top:50px">
                    <div class="card card-small">
                        <div class="card-header border-bottom">
                            <h6 class="m-0">Details</h6>
                        </div>
                        <table class="table">
                            <tr>
                                <td>Enrollment:</td>
                                <td>{{$student[0]->enrollment}}</td>
                            </tr>
                            <tr>
                                <td>Branch:</td>
                                <td>{{$student[0]->branch}}</td>
                            </tr>
                            <tr>
                                <td>Semester:</td>
                                <td>{{$student[0]->semester}}</td>
                            </tr>
                            <tr>
                                <td class="text text-danger">Exit Time:</td>
                                <td class="text text-danger">{{$details[0]->leave_time}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
