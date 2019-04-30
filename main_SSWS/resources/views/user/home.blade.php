@extends('user.layout')


@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <h3 class="page-title">Leave Overview</h3>
    </div>
</div>

<div class="row" style="display: flex;justify-content: center;">
    <div class="col-lg-7 col-md-7 col-sm-7 mb-5">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{\Session::get('success')}}
        </div>
        @endif
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Leave Overview</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr align=center>
                            <th>Submitted Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    <thead>
                    <tbody>
                        @foreach ($details as $detail)
                            <tr align=center>
                                <td>{{$detail->submitted_date}}</td>
                                @if ($detail->status=='confirmed')
                                    <td class="text-success"><b>{{$detail->status}}</b></td>
                                @endif
                                @if($detail->status=='rejected')
                                    <td class="text-danger"><b>{{$detail->status}}</b></td>
                                @endif
                                @if($detail->status=='pending')
                                    <td class="text-warning"><b>{{$detail->status}}</b></td>
                                @endif
                                <td>
                                <form action="leaveinfo" method="POST">
                                    @csrf
                                    <input type="hidden" id="id" name ="id" value={{$detail->id}}>
                                    <button type="submit" class="btn btn-primary">View More </button>
                                </form>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="display: flex;justify-content: center;">
                    {{$details->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
