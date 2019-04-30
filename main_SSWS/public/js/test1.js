$(document).ready(function(){
    $('#from_date').attr("disabled",true);
    $('#to_date').attr("disabled",true);
    $('#nextBtn').attr("disabled",true);
    $('#reason').attr("disabled",true);
    $('#submitBtn').hide();
    $('#lectureDiv').hide();
    $('#prevBtn').hide();
    $('#ResultDiv').hide();
    function DisplayLeave()
    {
        if($('#nextBtn').is(':enabled') && $('#from_date').val()!="" & $('#no_of_days').val()!="" && $('#no_of_days').val()<"8"){
            od=null;
            if($('#od').prop("checked")==true)
            {
                od="od";
            }
            leave_type='';
            if($('input:radio[name=type_of_leave]:nth(0)').is(':checked')){
                leave_type='ml';
            }
            if ($('#type_of_leave3').is(':checked')){
                $('#ResultDiv').hide();
                $('tbody').html('');
            }
            else{
            $('#ResultDiv').show();
            $.ajax({
                url:"getmsg",
                method:'GET',
                data:{no_of_days:$('#no_of_days').val(),
                        to_date:$('#to_date').val(),
                        from_date:$('#from_date').val(),
                        leave:leave_type,
                        od:od},
                dataType:'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                    $('#second_div').html(data.second_data);
                }
            });
        }
        }
        else
        {
            $('#ResultDiv').hide();
            $('tbody').html('');
        }

    };
//Validating  Radio button start------------------------------------------------------------
    $('input:radio[name=type_of_leave]:nth(0)').click(function(){
        $('#proofDiv').show();
        $('#submitBtn').hide();
        $('#nextBtn').show();
        if($('#no_of_days').val()==7)
        {
            $('#tol_error').hide();
            $('#type_of_leave').removeClass("is-invalid");
            $('#tol_error').html("");
            $('#nextBtn').attr("disabled",false);
            DisplayLeave();
        }
        else{
            $('#type_of_leave').addClass("is-invalid");
            $('#tol_error').html("Marriage Leave should be of 7 days only");
            $('#tol_error').show();
            $('#nextBtn').attr("disabled",true);
            DisplayLeave();
        }
        var file = $('input[type="file"]').val();
        if (!file)
        {
            $('#nextBtn').attr("disabled",true);
        }
    });
    $('input:radio[name=type_of_leave]:nth(1)').click(function(){
        $('#submitBtn').hide();
        $('#nextBtn').show();
        if($('#no_of_days').val()>=90)
        {
            $('#tol_error').hide();
            $('#type_of_leave').removeClass("is-invalid");
            $('#tol_error').html("");
            $('#nextBtn').attr("disabled",false);
            DisplayLeave();
        }
        else{
            $('#type_of_leave').addClass("is-invalid");
            $('#tol_error').html("Days should be more than 90");
            $('#tol_error').show();
            $('#nextBtn').attr("disabled",true);
            DisplayLeave();
        }
    });
    $('input:radio[name=type_of_leave]:nth(2)').click(function(){
        $('#proofDiv').hide();
        $('#tol_error').html("");
        $('#submitBtn').show();
        $('#nextBtn').hide();
        if($('#no_of_days').val()==7 || $('#no_of_days').val()==8 || $('#no_of_days').val()==15 )
        {
            $('#tol_error').hide();
            $('#type_of_leave').removeClass("is-invalid");
            $('#tol_error').html("");

            $('#submitBtn').attr("disabled",false);
            DisplayLeave();
        }
        else{
            $('#type_of_leave').addClass("is-invalid");
            $('#tol_error').html("Number of daysn should be 7,8 or 15");
            $('#tol_error').show();

            $('#submitBtn').attr("disabled",true);
            DisplayLeave();
        }
        DisplayLeave();
    });

//Validating  Radio button end--------------------------------------------------------------
    //$('#type_of_leave').trigger("change");

    $('#no_of_days').change(function(){
        $("#no_of_days").trigger("keyup");
        //$('input:radio[name=type_of_leave]:nth(0)').trigger("click");
        //$('input:radio[name=type_of_leave]:nth(1)').trigger("click");
        //$('input:radio[name=type_of_leave]:nth(2)').trigger("click");

    });

    $("#no_of_days").keyup(function() {
        if($(this).val()=="" || $(this).val()<1)
        {
            $('#from_date').attr("disabled",true);
            $('#to_date').attr("disabled",true);
            $('#nextBtn').attr("disabled",true);
            $('#reason').attr("disabled",true);
            DisplayLeave();
        }
        else
        {
            if($(this).val()>=1)
            {
                $('#from_date').attr("disabled",false);
                $('#reason').attr("disabled",false);
                CheckBtn();
                if($('#from_date').val()!="")
                {
                    getToDate();
                }
                DisplayLeave();
            }
        }
        if ($(this).val() >= 7) {
            $('#GreatSeven').show();
            $('#testDiv').show();
            $('#proof').attr('required','');
            $('#proof').attr('data-error', 'This field is required.');
            $("#reasonDiv").hide();
            $('#odDiv').hide();
            DisplayLeave();
        } else {
            $('#GreatSeven').hide();
            $('#odDiv').show();
            $('#proof').removeAttr('required');
            $('#proof').removeAttr('data-error');
            $('#reasonDiv').show();
            DisplayLeave();
        }
    });

    $("#no_of_days").trigger("keyup");

    $('#from_date').blur(function(){
        if($(this).val()=="")
        {
            $('#from_date').addClass("is-invalid");
            $('#from_date_error').html("Filed must not be empty");
            $('#to_date').attr('value','');
            CheckBtn();
            DisplayLeave();
        }
        else
        {
            $('#from_date').removeClass("is-invalid");
            $('#from_date_error').html("");
            CheckBtn();
            var d=new Date();
            var month=d.getMonth()+1;
            var day=d.getDate();
            var year=d.getFullYear();
            if (day<=9)
            {
                day="0"+day;
            }
            if(month<=9)
            {
                month="0"+month;
            }
            current_date=year+"-"+month+"-"+day;
            from_date=$(this).val();
            day=new Date(from_date);
            if(Date.parse(from_date)<=Date.parse(current_date) || day.getDay()==0)
            {
                $('#from_date').addClass("is-invalid");
                $('#from_date_error').html("Enter date correctly");
                $('#nextBtn').attr("disabled",true);
                DisplayLeave();
            }
            else
            {
                $('#from_date').removeClass("is-invalid");
                $('#from_date_error').html("");
                getToDate();
                DisplayLeave();
            }
        }
    });

    function CheckBtn(){

        if($('#no_of_days').val()<7){
            if($('#from_date').val()=="" || $('#reason').val()=="")
            {
                $('#nextBtn').attr("disabled",true);
                DisplayLeave();
            }
            else
            {
                $('#nextBtn').attr("disabled",false);
                DisplayLeave();
            }
            DisplayLeave();
        }
        else
        {
            if($('#from_date').val()=="" || $('#proof').val()=="")
            {
                $('#nextBtn').attr("disabled",true);
                DisplayLeave();
            }
            else
            {
                $('#nextBtn').attr("disabled",false);
                DisplayLeave();
            }
        }
    }

    function getToDate()
    {
        from_date=$('#from_date').val();
        day=new Date(from_date);
        t=day.setDate(day.getDate()+parseInt($('#no_of_days').val())-1);
        t=new Date(t);
        month=t.getMonth()+1;
        day=t.getDate();
        year=t.getFullYear();
        if (day<=9)
        {
            day="0"+day;
        }
        if(month<=9)
        {
            month="0"+month;
        }
        to_date=year+"-"+month+"-"+day;
        $('#to_date').attr('value',to_date);
    }

    $('#resetBtn').click(function()
    {
        // $("#no_of_days").trigger("change");
        $('#prevBtn').trigger('click');
        DisplayLeave();
    });

    $('#od').change(function(){
        if($(this).prop("checked")==true){
            $('#GreatSeven').show()
            $('#testDiv').hide();
            DisplayLeave();
        }
        else{
            $('#testDiv').show();
            $('#GreatSeven').hide();
            DisplayLeave();
        }
    });

    $('#proof').change(function(){
        var file = $('input[type="file"]').val();
        var exts = ['doc','docx','pdf','jpeg','jpg','png'];
        if ( file ) {
            var get_ext = file.split('.');
            get_ext = get_ext.reverse();
            if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
                $('#proof').removeClass("is-invalid");
                $('#proof_error').html("");
                $('#nextBtn').attr("disabled",false);
                DisplayLeave();
            } else {
                $('#proof').addClass("is-invalid");
                $('#proof_error').html("Select valid file");
                $('#nextBtn').attr("disabled",true);
                DisplayLeave();
            }
        }
        else{
            $('#proof').addClass("is-invalid");
                $('#proof_error').html("Select valid file");
                $('#nextBtn').attr("disabled",true);
                DisplayLeave();
        }
    });

    $('#reason').keyup(function(){
        l=$(this).val().length;
        if(l==0 || l<15)
        {
            $('#reason').addClass("is-invalid");
            $('#reason_error').html("Should contain atleast 15 characters");
            $('#nextBtn').attr("disabled",true);
            DisplayLeave();
        }
        else
        {
            $('#reason').removeClass("is-invalid");
            $('#reason_error').html("");
            $('#nextBtn').attr("disabled",false);
            CheckBtn();
            DisplayLeave();
        }
    });

    $('#nextBtn').click(function()
    {
        a=$('#total_days').val()
        $('#lectureDiv').show();
        $('#leaveDiv').hide();
        $('#nextBtn').hide();
        $('#submitBtn').show();
        $('#submitBtn').attr("disabled",false);
        $('#prevBtn').show();
        DisplayLeave();
        data='';
        for(i=1;i<=$('#stotal_days').val();i++)
        {
            data += $('#sdate'+i).val()+',';
        }
        $.ajax({
            url:"adjustlec",
            method:'GET',
            data:{dates:data},
            dataType:'json',
            success:function(data)
            {
                $('#accordionExample').html(data.table_data);
            },
        });

    });

    $('#prevBtn').click(function(){
        $('#lectureDiv').hide();
        $('#leaveDiv').show();
        $('#nextBtn').show();
        $('#submitBtn').hide();
        $('#prevBtn').hide();
        DisplayLeave();
    });
});
