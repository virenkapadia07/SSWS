@extends('hod.hod_layout')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


    <div class="row" style="margin-top:20px;margin-left:210px">
        <?php
                // $name=Session::get('logged_in');
                $enroll=Session::get('enrollment');
            ?>
        <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Apply For Leave</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="submitleave" enctype="multipart/form-data">
                        <div id="second_div">
                        </div>
                        {{ csrf_field() }}
                        @if (\Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                                {{-- <i class="fa fa-info mx-2"></i> --}}
                                <strong>{{\Session::get('success')}}</strong>
                            </div>
                        @endif
                        <div id="leaveDiv">
                        <div class="form-group row" style="align:center">
                            <label for="noofdays" class="col-sm-3 col-form-label"><b>Number of Days</b></label>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="no_of_days" id="no_of_days" min=1 max=15>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="FromDate" class="col-md-3 col-form-label"><b>From Date</b></label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="from_date" id="from_date">
                                <span class="invalid-feedback" id="from_date_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ToDate" class="col-md-3 col-form-label"><b>To Date</b></label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="to_date" id="to_date">
                            </div>
                        </div>
                        <div id="reasonDiv">
                        <div class="form-group row">
                            <label for="reason" class="col-md-3 col-form-label"><b>Reason</b></label>
                            <div class="col-md-6">
                                <textarea rows="3" cols="15" name="reason" class="form-control" id="reason"></textarea>
                                <span class="invalid-feedback" id="reason_error"></span>
                            </div>
                        </div>
                        </div>
                        <div id="GreatSeven">
                            <div class="form-group row" id="testDiv">
                                <label class="col-sm-3 col-form-label"><b>Type of Leave</b></label>
                                <div style="margin-left: 1%">
                                    <input type="radio" id="type_of_leave1" name="type_of_leave" value="ML">
                                    <label >Marriage Leave</label>
                                </div>
                                <div style="margin-left: 1%">
                                    <input type="radio" id="type_of_leave2" name="type_of_leave" value="MetL">
                                    <label >Maternity Leave</label>
                                </div>
                                <div style="margin-left: 1%">
                                    <input type="radio" id="type_of_leave3" name="type_of_leave" value="VL">
                                    <label >Vacation Leave</label>
                                </div>
                                <div class="col-md-8">
                                    <span style="font-size: 10px;color:red;margin-left: 150px" id="tol_error"></span>
                                </div>
                            </div>

                            <div class="form-group row" id="proofDiv">
                                <label for="proof" class="col-sm-3 col-form-label"><b>Proof</b></label>
                                <div class="col-md-5">
                                    <input type="file" class="form-control" name="proof" id="proof">
                                    <span style="font-size: 10px;color:red">*File must be pdf/doc/jpeg/png</span>
                                    <span class="invalid-feedback" id="proof_error"></span>
                                </div>
                            </div>
                        </div>
                        {{-- This is for testing--------------------------------------------------------- --}}
                        <div class="card-body" id="ResultDiv">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type_of_leave</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        {{-- This is for testing--------------------------------------------------------- --}}
                        </div>
                        <div id="lectureDiv">
                            <div class="accordion" id="accordionExample">

                            </div>
                        </div>
                        <div class="form-group row mb-0" style="padding-top: 5%">
                            <div class="col-md-8 offset-md-4">
                                <button type="button" class="btn btn-primary" id="prevBtn">
                                    Prev
                                </button>
                                <button type="button" class="btn btn-primary" id="nextBtn">
                                    Next
                                </button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    Submit
                                </button>
                                <button type="reset" class="btn btn-outline-primary" id="resetBtn">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/test1.js"></script>

@endsection
