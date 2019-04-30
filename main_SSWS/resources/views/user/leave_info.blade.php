@extends('user.layout')


@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h3 class="page-title">Leave Details</h3>
    </div>
</div>

<div class="row" style="display: flex;justify-content: center;">
    <div class="col-lg-6 col-md-5 col-sm-5 mb-5">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{\Session::get('success')}}
        </div>
        @endif
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Leave Details</h6>
            </div>
            <table class="table table-striped" style="margin-top:20px;">
                <tr >
                    <th>Type of Leave</th>
                    <td >{{$detail[0]->type_of_leave}}</td>
                </tr>
                <tr>
                    <th>Reason</th>
                    <td>{{$detail[0]->reason}}</td>
                </tr>
                @if ($detail[0]->type_of_leave=="Half Leave")
                    <tr>
                        <th>Leave Time</th>
                        <td>{{$detail[0]->leave_time}}</td>
                    </tr>
                @else
                    <tr>
                        <th>To Date</th>
                        <td>{{$detail[0]->leave_to_date}}</td>
                    </tr>
                    <tr>
                        <th>From Date</th>
                        <td>{{$detail[0]->leave_from_date}}</td>
                    </tr>
                @endif
                <tr>
                    <th>Submitted Time</th>
                    <td>{{$detail[0]->submitted_time}}</td>
                </tr>
                <tr>
                    <th>Submitted Date</th>
                    <td>{{$detail[0]->submitted_date}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    @if ($detail[0]->status=='confirmed')
                        <td class="text-success"><b>{{$detail[0]->status}}</b></td>
                    @endif
                    @if($detail[0]->status=='rejected')
                        <td class="text-danger"><b>{{$detail[0]->status}}</b></td>
                    @endif
                    @if($detail[0]->status=='pending')
                        <td class="text-warning"><b>{{$detail[0]->status}}</b></td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
