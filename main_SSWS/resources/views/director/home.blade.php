@extends('director.layout')

@section('content')

<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Dashboard</span>
        <h3 class="page-title">Pending Request Overview</h3>
    </div>
</div>

@if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">x</span>
        </button>
        {{-- <i class="fa fa-info mx-2"></i> --}}
        <strong>{{\Session::get('success')}}</strong>
    </div>
@endif
@if ($leave_details!=null)
<div class="card card-small" style="width:50%;margin-left:25%">
    <div class="card-header border-bottom">
        <h6 class="m-0">Request For Lecture</h6>
    </div>
    <div class="card-body" >

        <table class="table table-striped" >
            <thead>
                <tr>
                    <th>Faculty Name</th>
                    <th>Deparment</th>
                    <th align="center">Actions</th>
                    </tr>
            </thead>
            <tbody>
                @foreach ($leave_details as $key=>$value)
                    <?php
                        $faculty_name=DB::table('faculty_info')->where('faculty_id',$value->faculty_id)->select('f_name','l_name')->get();
                        $faculty_name=$faculty_name[0]->f_name." ".$faculty_name[0]->l_name;
                    ?>
                    <tr>
                        <td>{{$faculty_name}}</td>
                        <td>{{$value->department}}</td>
                        <td>
                            <form action="show" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value={{$value->leave_id}}>
                                <input type="hidden" name="name" value="{{$faculty_name}}">
                                <button type="submit" class="btn btn-warning">Show</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@else
    <h1>No New Request</h1>
@endif
@endsection
