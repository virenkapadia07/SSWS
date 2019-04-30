@extends('admin.admin_layout')

@section('content')

<input type="hidden" id="_token" value={{ csrf_token() }}>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<div class="row" style="margin-top:20px;margin-right:3px">
        <div class="col-lg-12 col-md-11 col-sm-11 mb-4">
                <div class="input-group input-group-seamless ml-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="material-icons">search</i>
                    </div>
                  </div>
                  <input  name="search" id="search" class="navbar-search form-control" type="text" placeholder="Search..." aria-label="Search">
                </div>
        </div>
</div>

<div class="row">
        <div class="col-lg-13 col-md-12 col-sm-12 mb-2">
                @if (\Session::has('success'))
                <div class="alert alert-success" align="center">
                    <p>{{\Session::get('success')}}
                </div>
            @endif
            <div class="card card-small">
                <div class="card-header border-bottom" >
                    <h6 class="m-0"  align="center">Total Data:
                        <span id="stotal_records"></span>
                    </h6>
                </div>
                <div class="card-body" style="overflow-y: scroll; height:250px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Enrollment</th>
                                <th>Department</th>
                                <th>Semester</th>
                                <th colspan="2" style="padding-left:80px">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="student">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-small" style="margin-top:10px">
                <div class="card-header border-bottom" >
                    <h6 class="m-0"  align="center">Total Data:
                        <span id="ftotal_records"></span>
                    </h6>
                </div>
                <div class="card-body" style="overflow-y: scroll; height:250px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Faculty ID</th>
                                <th>Department</th>
                                <th colspan="2" style="padding-left:80px">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="faculty">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

<script>
    $(document).ready(function(){

        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"search/action",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#student').html(data.stable_data);
                    $('#stotal_records').text(data.stotal_data);
                    $('#faculty').html(data.ftable_date);
                    $('#ftotal_records').text(data.ftotal_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_customer_data(query);
        });
    });



    function getData(enrollment)
    {

        var token=document.getElementById('_token').value;
        var url="getinfo";
        var form=document.createElement('form');
        document.body.appendChild(form);
        form.method='post';
        form.action=url;
        var input=document.createElement('input');
        input.type='hidden';
        input.name='_token';
        input.value=token;
        form.appendChild(input);
        var input=document.createElement('input');
        input.type='hidden';
        input.name='enrollment';
        input.value=enrollment;
        form.appendChild(input);
        form.submit();
    }

    function edit(enrollment)
    {
        var token=document.getElementById('_token').value;
        var url="edit";
        var form=document.createElement('form');
        document.body.appendChild(form);
        form.method='post';
        form.action=url;
        var input=document.createElement('input');
        input.type='hidden';
        input.name='_token';
        input.value=token;
        form.appendChild(input);
        var input=document.createElement('input');
        input.type='hidden';
        input.name='enrollment';
        input.value=enrollment;
        form.appendChild(input);
        form.submit();
    }

    function delete1(enrollment)
    {
        var token=document.getElementById('_token').value;
        var url="delete";
        var form=document.createElement('form');
        document.body.appendChild(form);
        form.method='post';
        form.action=url;
        var input=document.createElement('input');
        input.type='hidden';
        input.name='_token';
        input.value=token;
        form.appendChild(input);
        var input=document.createElement('input');
        input.type='hidden';
        input.name='enrollment';
        input.value=enrollment;
        form.appendChild(input);
        form.submit();
    }

    function getDataf(faculty_id)
    {
        var token=document.getElementById('_token').value;
        var url="#";
        var form=document.createElement('form');
        document.body.appendChild(form);
        form.method='post';
        form.action=url;
        var input=document.createElement('input');
        input.type='hidden';
        input.name='_token';
        input.value=token;
        form.appendChild(input);
        var input=document.createElement('input');
        input.type='hidden';
        input.name='faculty_id';
        input.value=faculty_id;
        form.appendChild(input);
        form.submit();
    }
</script>

@endsection
