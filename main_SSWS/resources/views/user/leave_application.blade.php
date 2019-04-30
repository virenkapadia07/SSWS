@extends('user.layout')

@section('content')

<div class="row" style="margin-top:20px;margin-left:210px">
    <?php
            // $name=Session::get('logged_in');
            $enroll=Session::get('enrollment');
        ?>
    <div class="col-lg-9 col-md-12 col-sm-12 mb-4">
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">Apply For Leave</h6>
            </div>

            <div class="card-body">

                <form method="POST" action="SubmitLeave">
                                {{ csrf_field() }}

                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                        <p>{{ \Session::get('success') }}</p>
                                    </div><br />
                                @endif

                                <div class="form-group row">
                                    <label for="typeOfLeave" class="col-sm-4 col-form-label text-md-right">Type of Leave</label>

                                    <div class="col-md-6">
                                            <select class="form-control" name="typeOfLeave" id="typeOfLeave" onchange="ChangeForm()">
                                                    <option value="Half_Leave">Half Leave</option>
                                                    <option value="Full_Leave">Full Leave</option>
                                            </select>
                                    </div>
                                </div>

                                <p id="display"></p>

                                <div id="FullLeave">
                                    <div class="form-group row">
                                    <label for="date" class="col-md-4 col-form-label text-md-right">From Date</label>

                                    <div class="col-md-6">
                                        <input id="FtoDate" type="date" class="form-control" name="FtoDate" onblur="FCheckToDate()">
                                        <b>
                                            <span id="FerrorToDate" style="color: red"></span>
                                        </b>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="date" class="col-md-4 col-form-label text-md-right">To Date</label>

                                    <div class="col-md-6">
                                        <input id="FfromDate" type="date" class="form-control" name="FfromDate" onblur="FCheckFromDate()">
                                        <b>
                                            <span id="FerrorFromDate" style="color: red"></span>
                                        </b>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="reason" class="col-md-4 col-form-label text-md-right">Reason</label>

                                    <div class="col-md-6">
                                        <textarea rows="2" cols="20" name="Freason" class="form-control" id="Freason" onkeyup="FCheckReason()"></textarea>
                                        <b>
                                            <span id="FerrorReason" style="color: red"></span><br>
                                            <span id="FerrorReasonCount"style="color: red"></span>
                                        </b>
                                    </div>
                                </div>
                                </div>
                                <!--........................Half Leave............................................  -->
                                <div id="HalfLeave">
                                    <div class="form-group row">
                                    <label for="time" class="col-md-4 col-form-label text-md-right">Leaving Time</label>

                                    <div class="col-md-6">
                                        <input id="Htime" type="time" class="form-control" name="Htime" onblur="HCheckTime()">
                                        <b>
                                            <span id="HerrorTime" style="color: red"></span>
                                        </b>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="reason" class="col-md-4 col-form-label text-md-right">Reason</label>

                                    <div class="col-md-6">
                                        <textarea rows="2" cols="20" name="Hreason" class="form-control" id="Hreason" onkeyup="HCheckReason()"></textarea>
                                        <b>
                                            <span id="HerrorReason" style="color: red"></span><br>
                                            <span id="HerrorReasonCount"style="color: red"></span>
                                        </b>
                                    </div>
                                </div>
                                </div>

                                <input type="hidden" name="enrollment" id="enrollment" value={{$enroll}}>
                                <input type="hidden" name="CurrentTime" id="CurrentTime">
                                <input type="hidden" name="CurrentDate" id="CurrentDate">
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary" id="applyBtn" onclick="Check()">
                                            Apply for Leave
                                        </button>
                                    </div>
                                </div>
                                @if (\Session::has('wrong'))
                                <div class="alert alert-danger">
                                    <p>{{\Session::get('wrong')}}
                                </div>
                                @endif
                            </form>

            </div>
        </div>
    </div>
</div>

<script>
    function ChangeForm()
    {
        var x = document.getElementById("typeOfLeave").value;
        if(x=="Half_Leave")
        {
            document.getElementById("FullLeave").style.display="none";
            document.getElementById("HalfLeave").style.display="block";
            document.getElementById("applyBtn").disabled = false;
        }
        else{
            document.getElementById("HalfLeave").style.display="none";
            document.getElementById("FullLeave").style.display="block";
            document.getElementById("applyBtn").disabled = false;
        }
    }

    window.onload=function() {
        document.getElementById("FullLeave").style.display="none";
        document.getElementById("HalfLeave").style.display="block";
        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        document.getElementById('CurrentTime').value=time;
        document.getElementById('CurrentDate').value=date;
    }

    function FCheckToDate()
    {
        var toDate=document.getElementById('FtoDate').value;
        var today = new Date();
        date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        if(toDate=='')
        {
            document.getElementById("FerrorToDate").innerHTML="Should Not Be Empty";
            document.getElementById("applyBtn").disabled = true;
        }
        else if(Date.parse(toDate)<Date.parse(today))
        {
            document.getElementById("FerrorToDate").innerHTML="Please Enter Valid Date";
            document.getElementById("applyBtn").disabled = true;
        }
        else
        {
            document.getElementById("FerrorToDate").innerHTML="";
            document.getElementById("applyBtn").disabled = false;
            FCheckReason();
        }
    }
    function FCheckFromDate()
    {
        var toDate=document.getElementById('FtoDate').value;
        var fromDate=document.getElementById('FfromDate').value;
        var today = new Date();
        var ComparingDate=(today.getFullYear())+'-'+(today.getMonth()+2)+'-'+today.getDate();
        if(fromDate=='')
        {
            document.getElementById("FerrorFromDate").innerHTML="Should Not Be Empty";
            document.getElementById("applyBtn").disabled = true;
        }
        else if(Date.parse(fromDate)<Date.parse(toDate))
        {
            document.getElementById("FerrorFromDate").innerHTML="Please Enter Valid Date";
            document.getElementById("applyBtn").disabled = true;
        }
        else if(Date.parse(fromDate)>Date.parse(ComparingDate))
        {
            document.getElementById("FerrorFromDate").innerHTML="You Cannot Get More Than One Month Leave";
            document.getElementById("applyBtn").disabled = true;
        }
        else
        {
            document.getElementById("FerrorFromDate").innerHTML="";
            document.getElementById("applyBtn").disabled = false;
            FCheckToDate();
        }
    }

    function FCheckReason()
    {
        var reason=document.getElementById('Freason').value;
        if(reason.length<15 || reason.length==0)
        {
            document.getElementById('FerrorReason').innerHTML="Should Contain Atleast 15 Characters";
            document.getElementById('FerrorReasonCount').innerHTML=15-reason.length+" Characters Left";
            document.getElementById("applyBtn").disabled = true;
        }
        else{
            document.getElementById('FerrorReason').innerHTML="";
            document.getElementById('FerrorReasonCount').innerHTML="";
            document.getElementById("applyBtn").disabled = false;
            FCheckFromDate();
        }
    }

    function HCheckReason()
    {
        var reason=document.getElementById('Hreason').value;
        if(reason.length<15)
        {
            document.getElementById('HerrorReason').innerHTML="Should Contain Atleast 15 Characters";
            document.getElementById('HerrorReasonCount').innerHTML=15-reason.length+" Characters Left";
            document.getElementById("applyBtn").disabled = true;
        }
        else{
            document.getElementById('HerrorReason').innerHTML="";
            document.getElementById('HerrorReasonCount').innerHTML="";
            document.getElementById("applyBtn").disabled = false;
            HCheckTime();
        }
    }

    function HCheckTime()
    {
        var t=document.getElementById('Htime').value;
        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes();
        if(today.getHours()==9)
        {
            time=0+time;
        }
        if(t=="")
        {
            document.getElementById('HerrorTime').innerHTML="Should Not Be Empty";
            document.getElementById("applyBtn").disabled = true;
        }
        else if(!(t>="09:00" && t<="13:30"))
        {
            document.getElementById('HerrorTime').innerHTML="This Time Is Not Valid";
            document.getElementById("applyBtn").disabled = true;
        }
        else if(t<=time)
        {
            document.getElementById('HerrorTime').innerHTML="Please Enter Valid Time";
            document.getElementById("applyBtn").disabled = true;
        }
        else
        {
            document.getElementById('HerrorTime').innerHTML="";
            document.getElementById("applyBtn").disabled = false;
            HCheckReason();
        }
    }

    function Check()
    {
        var typeOfLeave=document.getElementById('typeOfLeave').value;
        var a=document.getElementById('HerrorReason').value;
        var b=document.getElementById('HerrorTime').value;
        var c=document.getElementById('FerrorFromDate').value;
        var d=document.getElementById('FerrorReason').value;
        var e=document.getElementById('FerrorToDate').value;
        if(typeOfLeave=="Half_Leave")
        {
            HCheckReason();
            HCheckTime();
        }
        else
        {
            FCheckFromDate();
            FCheckToDate();
            FCheckReason();
        }
    }

</script>
@endsection
