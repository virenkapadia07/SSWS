@extends('faculty.layout')

@section('content')
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Pending Request Overview</h3>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div><br/>
            @endif
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Request For Lecture</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Faculty Name</th>
                                <th>Lecture</th>
                                <th>Class</th>
                                <th align="center">Actions</th>
                                </tr>
                        <thead>
                        <tbody>
                            <tr>
                                    <td>Kavita Joshi</td>
                                    <td>1</td>
                                    <td>6-IT</td>
                                    <td>
                                        <div class="blog-comments__actions">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-white">
                                                <span class="text-success">
                                                    <i class="material-icons">check</i>
                                                </span> Approve </button>
                                                <button type="button" class="btn btn-white">
                                                <span class="text-danger">
                                                    <i class="material-icons">clear</i>
                                                </span> Reject </button>
                                            </div>
                                        </div>
                                    </td>
                            </tr>
                        </tbody>
                        </table>
                </div>
            </div>
        </div>


    <div class="row" style="width:50%;float: left">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4" style="padding-right: 40px;padding-left: 30px">
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div><br/>
            @endif
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Pending Leaves of Students</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped" scroll="true">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Enrollment</th>

                                <th>Action</th>
                            </tr>
                        <thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr>
                                    <td>{{$detail->name}}</td>
                                    <td>{{$detail->enrollment}}</td>

                                    <td>
                                    <form action="show" method="POST">
                                        @csrf
                                        <input type="hidden" id="id" name ="id" value={{$detail->id}}>
                                        <button type="submit" class="btn btn-warning">Show</button>
                                    </form>
                                    </td>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="width:50%;float: right">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4" style="padding-right:0px;pedding-left:70px">
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div><br/>
            @endif
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Pending Leaves of Faculties</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped" scroll="true">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        <thead>
                        <tbody>

                                <tr>
                                    <td>Manthan Surti</td>
                                    <td>
                                    <form action="show" method="POST">
                                        @csrf
                                        <input type="hidden" id="id" name ="id" >
                                        <button type="submit" class="btn btn-warning">Show</button>
                                    </form>
                                    </td>
                                    </td>
                                </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


