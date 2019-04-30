@extends('admin.admin_layout')

@section('content')
<div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">Manage User</h3>
        </div>
    </div>

    <div class="row" style="margin-left:250px">
        <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Add New Student</h6>
                </div>
                    <div class="row mb-3" style="margin-top:10px;margin-left:20px" >
                    <a href="manageStudent" class="bg-info rounded text-white text-center p-3" >Student</a>
                    </div>

                    <div class="row mb-3" style="margin-top:10px;margin-left:20px">
                        <a href="manageFaculty" class="bg-info rounded text-white text-center p-3">Faculty</a>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
