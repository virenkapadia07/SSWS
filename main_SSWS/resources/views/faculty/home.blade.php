@extends('faculty.layout')

@section('content')
@if ($pending_details==null && $details==null)
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Home</span>
            <h6 class="page-title">No New Request/Pending Applications</h6>
        </div>
    </div>
@endif

<div class="row" style="display: flex;justify-content: center;">
    <div class="col-lg-9 col-md-7 col-sm-7 mb-5">
        {{--Request for lecture Start-____________________________________________________ --}}
        @if ($details!=null)


        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Request For Lecture</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Faculty Name</th>
                            <th>Lecture</th>
                            <th>Class</th>
                            <th align="center">Actions</th>
                            </tr>
                    <thead>
                    <tbody>
                        @foreach ($details as $key=>$detail)
                            <tr>
                                <?php
                                    $dt=$detail['date'];
                                    $dte=explode('-',$dt);
                                ?>
                                <td>{{$dte[2].'-'.$dte[1].'-'.$dte[0]}}</td>
                                <td>{{$detail['name']}}</td>
                                <td>{{$detail['lecture']}}</td>
                                <td>{{$detail['class']}}</td>
                                <td>
                                    <div class="blog-comments__actions">
                                        <div class="btn-group btn-group-sm">
                                            <?php
                                            $lec=$detail['lec_id'];
                                            $cl=$detail['lecture'];

                                            ?>
                                            <button type="button" class="btn btn-white" onclick="acceptLeave('{{$lec}}','{{$cl}}')">
                                            <span class="text-success">
                                                <i class="material-icons">check</i>
                                            </span> Approve </button>
                                            <button type="button" class="btn btn-white" onclick="rejectLeave('{{$lec}}','{{$cl}}')">
                                            <span class="text-danger">
                                                <i class="material-icons">clear</i>
                                            </span> Reject </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        {{--Request for lecture End_________________________________________________________ --}}

        {{-- Leave Application Start_________________________________________________________ --}}
        @if ($pending_details!=null)

        <div class="card card-small" style="margin-top:10px">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Leave Application</h6>
                </div>
        <div class="row">
            <div class="col" style="overflow-y: scroll; height:350px;">
                {{-- _____________________________________________ --}}
                @foreach ($pending_details as $key=>$detail)

                <div class="card card-small overflow-hidden ">
                    <div class="card-header border-bottom bg-dark">
                    <h6 class="m-0 text-white">{{$key}}</h6>
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                            <th scope="col" class="border-0">Lecture</th>
                            <th scope="col" class="border-0">Faculty</th>
                            <th scope="col" class="border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail as $item)
                                <tr>
                                    <td>{{$item['lec_id']}}</td>
                                    <td>{{$item['faculty_name']}}</td>
                                    @if ($item['status']=='confirm')
                                        <td class="text-success"><b>{{$item['status']}}</b></td>
                                    @endif
                                    @if($item['status']=='rejected')
                                        <td class="text-danger"><b>{{$item['status']}}</b></td>
                                    @endif
                                    @if($item['status']=='pending')
                                        <td class="text-warning"><b>{{$item['status']}}</b></td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">Hod Status</td>
                                @if ($get_status[$key]['hod_status']=='confirm')
                                    <td class="text-success"><b>{{$get_status[$key]['hod_status']}}</b></td>
                                @endif
                                @if($get_status[$key]['hod_status']=='rejected')
                                    <td class="text-danger"><b>{{$get_status[$key]['hod_status']}}</b></td>
                                @endif
                                @if($get_status[$key]['hod_status']=='pending')
                                    <td class="text-warning"><b>{{$get_status[$key]['hod_status']}}</b></td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="2">Director Status</td>
                                 @if ($get_status[$key]['director_status']=='confirm')
                                    <td class="text-success"><b>{{$get_status[$key]['director_status']}}</b></td>
                                @endif
                                @if($get_status[$key]['director_status']=='rejected')
                                    <td class="text-danger"><b>{{$get_status[$key]['director_status']}}</b></td>
                                @endif
                                @if($get_status[$key]['director_status']=='pending')
                                    <td class="text-warning"><b>{{$get_status[$key]['director_status']}}</b></td>
                                @endif
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
                {{-- _____________________________________________ --}}
            </div>
        </div>
        </div>
        @endif
        {{--Leave Application End_________________________________________________________ --}}
    </div>

</div>

<script>
    function acceptLeave(lec_id,clss)
    {
        var token=document.getElementById('_token').value;
        var url="acceptLeave";
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
        input.name='lec_id';
        input.value=lec_id;
        form.appendChild(input);

        var input=document.createElement('input');
        input.type='hidden';
        input.name='clss';
        input.value=clss;
        form.appendChild(input);

        form.submit();
    }

    function rejectLeave(lec_id,clss)
    {
        var token=document.getElementById('_token').value;
        var url="rejectLeave";
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
        input.name='lec_id';
        input.value=lec_id;
        form.appendChild(input);

        var input=document.createElement('input');
        input.type='hidden';
        input.name='clss';
        input.value=clss;
        form.appendChild(input);

        form.submit();
    }
</script>
@endsection

