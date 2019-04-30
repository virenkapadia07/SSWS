@extends('director.layout')

@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Faculty</span>
        <h3 class="page-title">{{$faculty_name}}</h3>
    </div>
</div>

<div class="card card-small">
    @if ($leav_details[0]->director_status=='pending')

    <div class="card-header border-bottom">
        <h6 class="m-0">Request For Leave</h6>
    </div>

    @endif
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th align=CENTER>Details</th>
                    <th>Faculty Allocated</th>
                    <th>Lecture</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leav_details as $key2=>$value2)
                    <tr align=center>
                        <td rowspan={{count($lecture_details)+1}} align=center>
                            Leave Date: {{$value2->leave_date}} <br>
                            Type of leave: {{$value2->type_of_leave}} <br>
                            Submitted Date: {{$value2->submitted_date}}
                        </td>
                    </tr>
                    @foreach ($lecture_details as $key=>$value)
                        <tr>
                            <td>{{$value['name']}}</td>
                            <td>{{$value['lecture']}}</td>
                            <td>{{$value['class']}}</td>
                        </tr>
                    @endforeach
                @endforeach
                @if ($value2->reason)
                <tr>
                    <td align=center>Reason</td>
                    <td colspan="3" align=center>{{$value2->reason}}</td>
                </tr>
                @endif
                @if ($value2->proof)
                <tr>
                    <td align=center>Proof</td>
                    <td colspan="3" align=center><a href="proof?id={{$value2->id}}" target='_blank'>View</a></td>
                </tr>
                @endif
            </tbody>
        </table>
        @if ($leav_details[0]->director_status=='pending')

        <div class="blog-comments__actions" style="justify-content:center">
                <div class="btn-group btn-group-sm">
                    <form action="accpetFacultyLeave" method="post" style="margin-left:250%">
                        <input type="hidden" name="leave_id" value={{$leave_details[0]->leave_id}}>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-white" style="height:40px">
                            <span class="text-success">
                                <i class="material-icons">check</i>
                            </span> Approve
                        </button>
                    </form>

                    <form action="rejectFacultyLeave" method="post" style="margin-left: 5px">
                        {{ csrf_field() }}
                        <input type="hidden" name="leave_id" value={{$leave_details[0]->leave_id}}>
                        <button type="submit" class="btn btn-white" style="height:40px;width:80px">
                            <span class="text-danger">
                                <i class="material-icons">clear</i>
                            </span> Reject
                        </button>
                    </form>
                </div>
            </div>
            @endif
    </div>
</div>

@endsection
