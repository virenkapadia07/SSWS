@extends('hod.hod_layout')

@section('content')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Report</span>
        <h3 class="page-title">Generate Report</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
        @if (\Session::has('wrong'))
        <div class="alert alert-danger">
            <p>{{\Session::get('wrong')}}
        </div>
        @endif
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Report Details</h6>
            </div>

            <div class="table-responsive" style="padding:20px">
                <table>
                    <form action="getReport" method="post">
                        @csrf
                    <tr>
                        <td width=16%>
                            Select Semester
                        </td>
                        <td width=7%>
                            <select class="form-control" name="sem" id="sem">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </td>
                        <td width=10%></td>
                        <td width=15%>
                            <button type="submit" class="btn btn-primary">
                                            Get Details
                            </button>
                        </td>
                        <td width=50%></td>
                        <td width=20%>
                            <a href="pdf" class="btn btn-danger">Convert into PDF</a>
                        </td>
                    </tr>
                </form>
                </table>
                <div style="padding:5px"></div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Enrollment</th>
                            <th>Semester</th>
                            <th>Branch</th>
                            <th>Total Leave</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($details as $detail)
                        <tr>
                            <td>{{ $detail->name }}</td>
                            <td>{{ $detail->enrollment }}</td>
                            <td>{{ $detail->semester }}</td>
                            <td>{{ $detail->branch }}</td>
                            <td>
                                <?php
                                    $leave=DB::table('student_applications')
                                    ->where('enrollment',$detail->enrollment)
                                    ->where('status','confirmed')->count();
                                ?>
                                {{$leave}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
