@extends('faculty.layout')

@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        {{-- <span class="text-uppercase page-subtitle">Leave</span> --}}
        <h3 class="page-title">Leave Summary</h3>
    </div>
</div>

<div class="card card-small">
    <div class="card-header border-bottom">
        <h6 class="m-0">Leave Application</h6>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th align=CENTER>Details</th>
                    <th>Faculty Allocated</th>
                    <th>Lecture</th>
                    <th>Class</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leav_details as $key2=>$value2)
                    <tr align=center>
                        <td rowspan={{count($lecture_details)+1}} align=center>
                            <?php
                                $date=$value2->leave_date;
                                $d=explode('-',$date);
                            ?>
                            Leave Date: {{$d[2].'-'.$d[1].'-'.$d[0]}} <br>
                            Type of leave: {{$value2->type_of_leave}} <br>
                            <?php
                                $date=$value2->submitted_date;
                                $d=explode('-',$date);
                            ?>
                            Submitted Date: {{$d[2].'-'.$d[1].'-'.$d[0]}} <br>
                            Hod Status:
                            @if ($leav_details[0]->hod_status=='confirm')
                                <label class="text-success"><b>{{$leav_details[0]->hod_status}}</b></label>
                            @endif
                            @if($leav_details[0]->hod_status=='rejected')
                                <label class="text-danger"><b>{{$leav_details[0]->hod_status}}</b></label>
                            @endif
                            @if($leav_details[0]->hod_status=='pending')
                                <label class="text-warning"><b>{{$leav_details[0]->hod_status}}</b></label>
                            @endif
                            <br>

                            Director Status:
                            @if ($leav_details[0]->director_status=='confirm')
                                <label class="text-success"><b>{{$leav_details[0]->director_status}}</b></label>
                            @endif
                            @if($leav_details[0]->director_status=='rejected')
                                <label class="text-danger"><b>{{$leav_details[0]->director_status}}</b></label>
                            @endif
                            @if($leav_details[0]->director_status=='pending')
                                <label class="text-warning"><b>{{$leav_details[0]->director_status}}</b></label>
                            @endif
                        </td>
                    </tr>
                    @foreach ($lecture_details as $key=>$value)
                        <tr>
                            <td>{{$value['name']}}</td>
                            <td>{{$value['lecture']}}</td>
                            <td>{{$value['class']}}</td>
                            @if ($value['status']=='confirm')
                                <td class="text-success"><b>{{$value['status']}}</b></td>
                            @endif
                            @if($value['status']=='rejected')
                                <td class="text-danger"><b>{{$value['status']}}</b></td>
                            @endif
                            @if($value['status']=='pending')
                                <td class="text-warning"><b>{{$value['status']}}</b></td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
                @if ($value2->reason)
                <tr>
                    <td align=center>Reason</td>
                    <td colspan="4" align=center>{{$value2->reason}}</td>
                </tr>
                @endif
                @if ($value2->proof)
                <tr>
                    <td align=center>Proof</td>
                    <td colspan="4" align=center><a href="proof?id={{$value2->id}}" target='_blank'>View</a></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
