@extends('admin.admin_layout')

@section('content')
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Pending Leave Overview</h3>
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
                    <h6 class="m-0">Pending Leaves</h6>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
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
                    <div style="display: flex;justify-content: center;">
                        {{$details->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
