@extends('master.master')

@section('content')

    <link rel="stylesheet" href="{{asset('crop/croppie1.css')}}">
    <!-- <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .cl{
            color: #000 !important;
        }
    </style>
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Fees</li>
        <li class="active">Fees Collection</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                    {{csrf_field()}}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Fees Collection</strong> </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Class</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control"  id="class_id" name="class_id" onchange="get_div(this.value)" required>
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($classes as $key => $cl){
                                                    ?> 
                                                        <option value="<?php echo $cl->ClassId; ?>"><?php echo $cl->ClassName; ?></option>
                                                    <?php   }   ?> 
                                                </select>
                                                <span class="help-block">Select Class </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Division</label>
                                             <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="div_id" onchange="get_student()" name="div_id" required>
                                                    <option value="">Select Division</option>
                                                </select>
                                                <span class="help-block">Select Division</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Student</label>
                                             <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="student_id" name="student_id" required>
                                                    <option value="">Select Student</option>
                                                </select>
                                                <span class="help-block">Select Student</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: 35px;">
                                    <div id="student_data"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary pull-right" name="save" id="save">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-12 pre_stu_detail" style="display: none;">
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title">Previous Payment Window</h3>
                    </div>
                    <div class="panel-body">
                        <form id="previous_fees_table" enctype="multipart/form-data" role="form" >
                            <div class="abc" id="previousstudentdata"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title">Payment Window</h3>
                        <ul class="panel-controls">
                            <li>
                                <div class="pending_amount" style="display: none;">
                                    <h5>All Previous Year Pending Fees : <label class="pending"></label></h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <form id="fees_table" name="MyForm" enctype="multipart/form-data" role="form" >
                            <div class="abc" id="studentdata"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> View Payment Window</h3>
                    </div>
                    <div class="panel-body">
                        <form id="fees_table" enctype="multipart/form-data" role="form" >
                            <div class="abc" id="studentdata1">
                                <table class="table" id="studentfee" style="table-layout: fixed;">
                                    <thead></thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>                    
    </div>

    <div id="modal_div"></div>

    <div class="message-box message-box-success animated fadeIn" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Payment has been done Successfully.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Error to update Student data.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger456">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Student number already exist.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

@section('scripts')

@endsection

    <!-- PAGE CONTENT WRAPPER -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/jquery/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap.min.js')}}"></script>
    <script type="text/javascript">
        var imagename = '';
    </script>
    <script src="{{asset('crop/croppie1.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/icheck/icheck.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script> 

    <script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>                
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap-select.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>

    <script type='text/javascript' src="{{asset('js/plugins/validationengine/languages/jquery.validationEngine-en.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/validationengine/jquery.validationEngine.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/maskedinput/jquery.maskedinput.min.js')}}"></script> 

    <script type="text/javascript">

        $('.datepicker').bind('keypress',function(e){
            if (e.which) { return false; }
        });

    </script>
    <script type="text/javascript">

        function get_div(class_id)
        {
            var class_id = class_id;
            $.ajax({
                url: "{{ url('student/selectDiv') }}",
                type: 'get',
                dataType: 'json',
                data: {'class_id':class_id},
                success: function(response){
                    
                    var html_data = '';
                    var len = 0;
                    $("#div_id").empty();
                      
                    if(response.data != null){
                        len = response.data.length;
                    }
                    if(len > 0)
                    {
                        html_data += '<option value="">Select Division</option>';
                        // $("#div_id").append(html_data);
                        for(var i=0; i<len; i++)
                        {
                            /*var id = response.data[i].DivisionId;
                            var name = response.data[i].DivisionName;*/
                            html_data += "<option value='"+response.data[i].DivisionId+"'>"+response.data[i].DivisionName+"</option>"; 
                            $("#div_id").html(html_data); 
                        } 
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }

        function get_student()
        {
            var class_id = $('#class_id').val();
                div_id = $('#div_id').val();
                year_id = '<?php echo $year_id; ?>';
            $.ajax({
                url: "{{ url('selectStudent') }}",
                type: 'get',
                dataType: 'json',
                data: {'class_id':class_id, 'div_id': div_id, 'year_id': year_id},
                success: function(response){
                    
                    var html_data = '';
                    var len = 0;
                    $("#student_id").empty();
                      
                    if(response.data != null){
                        len = response.data.length;
                    }
                    if(len > 0)
                    {
                        html_data += '<option value="">Select Student</option>';
                        for(var i=0; i<len; i++)
                        {
                            html_data += "<option value='"+response.data[i].StudentId+"'>"+response.data[i].StudentName+"</option>"; 
                            $("#student_id").html(html_data); 
                        } 
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }

        $("#student_id").change(function()
        {
            var student_id = $('#student_id').val();
                year_id = '<?php echo $year_id; ?>';
            $.ajax({
                url: "{{ url('getStudentDetail') }}",
                type: 'get',
                dataType: 'json',
                data: {'student_id':student_id, 'year_id': year_id},
                success: function(data){

                    var response = data.data;
                    var html_data = '';

                    html_data += '<div class="col-md-4"><div class="form-group"><label class="col-md-4 control-label">Roll No. :</label><div class="col-md-8"><label class="control-label"><p id="totalamount">'+response.Roll_Number+'</p></label></div></div><div class="form-group"><label class="col-md-4 control-label">Guardian Name :</label><div class="col-md-8"><label class="control-label"><p id="totalamount">'+response.FatherName+'</p></label></div></div></div>';
                    html_data += '<div class="col-md-4"><div class="form-group"><label class="col-md-4 control-label">Student Name :</label><div class="col-md-8"><label class="control-label"><p id="totalamount">'+response.StudentName+'</p></label></div></div><div class="form-group"><label class="col-md-4 control-label">Contact No. :</label><div class="col-md-8"><label class="control-label"><p id="totalamount">'+response.ContactNumber1+'</p></label></div></div></div>';
                    html_data += '<div class="col-md-4"><div class="form-group"><label class="col-md-4 control-label">Class-Division :</label><div class="col-md-8"><label class="control-label"><p id="totalamount">'+response.ClassName+'-'+response.DivisionName+'</p></label></div></div><div class="form-group"><label class="col-md-4 control-label">Address :</label><div class="col-md-8"><label class="control-label"><p id="totalamount">'+response.CurrentAddress+'</p></label></div></div></div>';
                    html_data += '<div class="col-md-4" style="float: right;"><div class="form-group"><label class="col-md-4 control-label">Scholarship :</label><div class="col-md-4" style="margin-top: 6px;"><label style="padding: inherit;"><input type="radio" id="yes" name="scholarshi" value="yes" onclick="ShowHideDiv(0)"> Yes</label><label><input type="radio" id="no" name="scholarshi" checked value="no" onclick="ShowHideDiv(1)"> No</label></div></div></div>';
                    html_data += '<form id="student_fees_form"><div class="col-md-4" style="float: right;"><div class="form-group"><label class="col-md-4 control-label">Discount :</label><div class="col-md-4" style="margin-top: 6px;"><label style="padding: inherit;"><input type="radio" id="yesdiscount" name="discoun" value="yes" onclick="DiscountShowHideDiv('+response.StudentId+')"> Yes</label><label><input type="radio" id="nodiscount" name="discoun" checked value="no" onclick="DiscountShowHideDiv(0)"> No</label></div></div></div></form>';

                    $('#student_data').html(html_data);

                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        });

    </script>
    <script type="text/javascript">

        var jvalidate = $("#add_role_form").validate(
        {
            ignore: [],
            rules: {
                // student_id: { required: true }, 
            } ,    
            submitHandler: function(form)
            {
                preaviousData();
                currentData();
                viewPrint();
            }
        });

        function preaviousData()
        {
            var student_id = $('#student_id').val();
                year_id = '<?php echo $year_id; ?>';

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("student_id", student_id);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('select_pre_year_student_fees') }}",
                method: 'post',
                contentType: false,
                processData: false,
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                data: formData,
                success: function(data){

                    var response = JSON.parse(data);
                    if($.isEmptyObject(response))
                    {
                        $("#previousstudentdata").html('');
                        $("#previousstudentdata").append('<div class="col-sm-12">No Data Available.</div>');
                    }else
                    {
                        $("#previousstudentdata").html('');
                        var htmldata1 = '';
                            htmldata2 = '';
                            htmldata3 = '';
                            htmldata4 = '';
                            totalActual= 0;
                            total_actual_amt= 0;
                            totalDue = 0;
                            date = "";
                        for(var i = 0; i<response.length; i++)
                        {
                            if(response[i].due_amount != 0)
                            {
                                var mID = i+'_'+response[i].student_id+'_'+response[i].class_id;
                                if(date == ""){
                                    date = response[i].Year;
                                }

                                if(date == response[i].Year){
                                    total_actual_amt += total_actual_amt + parseInt(response[i].actual_amount);
                                
                                }else{
                                    htmldata2 += '<tr class="odd gradeX" style="font-size: 11px;"><td></td><td></td><td style="text-align:right;"><b>'+date +' Total : </b></td><td class="center"><label style="font-weight: bolder;">'+total_actual_amt+' /</label> <label style="font-weight: bolder;" id="ttldue'+mID+'"> '+totalDue+'</label></td><td></td><td></td><td></td><td></td></tr>'
                                    htmldata4 =  htmldata2 ;
                                    total_actual_amt = 0
                                    totalDue = 0
                                    date = response[i].Year
                                }

                                 htmldata3 = '<tr class="odd gradeX" style="font-size: 11px;"><td class="center">'+response[i].Year+'<input type="hidden" id="pre_year_id'+mID+'" value="'+response[i].Year+'"></td>'
                                htmldata3 += '<td class="center">'+response[i].fee_subcategory_name+'<input type="hidden" id="fee_subcategory_id'+mID+'" value="'+response[i].fee_subcategory_id+'"><input type="hidden" id="fee_type'+mID+'" value="'+response[i].fee_type+'"><input type="hidden" id="t2" value="'+response.length+'"></td>'
                                htmldata3 += '<td class="center"><div class="form-group" style="margin-left: -10px;"><div class="col-md-12"><input type="hidden" id="fee_collection_id'+mID+'" name="fee_collection_id" value="'+response[i].fee_collection_id+'"><select class="form-control select" id="installment'+mID+'" name="installment"><option value="">Select</option>'
                                for (var j = 0; j < response[i].inst_array.length; j++) 
                                {
                                    var option = '';
                                    if (response[i].fee_type == '12') {
                                        option = months[response[i].inst_array[j].fee_type_inst_name];
                                    }
                                    else{
                                        option = response[i].inst_array[j].fee_type_inst_name;
                                    }
                                    htmldata3 += '<option value="'+response[i].inst_array[j].fee_type_inst_id+'-'+response[i].inst_array[j].fee_type_inst_name+'">'+option+'</option>';
                                }
                                htmldata3 += '</select></div></div></td>'
                                htmldata3 += '<td class="center">'+response[i].actual_amount+' / <label id="dm'+mID+'">'+response[i].due_amount+'</label></td>'
                                htmldata3 += '<td class="center"><div class="form-group" style="margin-left: -10px;"><div class="col-md-9"><input type="text" class="form-control dua" id="duetobepaid'+mID+'" name="duetobepaid" value="0" onkeyup="maxValueSet('+i+','+ response[i].student_id +','+ response[i].class_id+')"/><input type="hidden" id="due_amount'+mID+'" value="'+response[i].due_amount+'"></div></div></td><input type="hidden" id="due'+mID+'" value="'+response[i].duetobepaid+'"></div></div></td>'
                                if(response[i].fine == null){ var fine = 0; }
                                else{ var fine = response[i].fine; }
                                // htmldata3 += '<td class="center"><div class="form-group" style="margin-left: -10px;"><div class="col-md-9"><input type="text" class="form-control" id="fine'+i+'" name="fine" value="'+fine+'" /></div></div></td>'

                                htmldata3 += '<td class="center dis" style="display:none;"><div class="form-group" style="margin-left: -10px;"><div class="col-md-9"><input type="text" class="form-control " id="discount'+mID+'" name="discount" value="0" onkeyup="maxValueSet('+i+','+ response[i].student_id +','+ response[i].class_id+')" /><input type="hidden" class="form-control" id="dis'+mID+'" value="'+response[i].discount+'" /></div></div></td>'
                                htmldata3 += '<td class="center scholar" style="display:none;"><div class="form-group" style="margin-left: -10px;"><div class="col-md-9"><input type="text" class="form-control " id="scholarship'+mID+'" name="scholarship" value="0" onkeyup="maxValueSet('+i+','+ response[i].student_id +','+ response[i].class_id+')" /><input type="hidden" class="form-control" id="scholar'+mID+'" value="'+response[i].scholarship+'" /></div></div></td>'
                                var category = "'"+response[i].fee_category_name+"'";
                                htmldata3 += '<td class="center"><button1 class="btn btn-default" onclick="add_fee_list('+i+', '+ response[i].student_id +','+ response[i].class_id+', '+category+', '+response[i].actual_amount+', '+response[i].due_amount+', '+response[i].duetobepaid+', '+response[i].fee_collection_id+', '+response[i].fee_type+')"><i class="fa fa-plus" aria-hidden="true"></i> Add</button1></td></tr>';                        
                                htmldata2 +=  htmldata3;
                                totalDue = totalDue + parseInt(response[i].due_amount);
                                if(date == response[i].Year)
                                {
                                    total_actual_amt = total_actual_amt + parseInt(response[i].actual_amount);
                                    // console.log(i+"DAte same => "+response.length)
                                    if(i == response.length - 1) {
                                        htmldata2 += '<tr class="odd gradeX" style="font-size: 11px;"><td></td><td></td><td style="text-align:right;"><b>'+response[i].Year +' Total :</b></td><td class="center"><label style="font-weight: bolder;">'+total_actual_amt+' /</label> <label style="font-weight: bolder;" id="ttldue'+mID+'"> '+totalDue+'</label></td><td></td><td></td><td></td><td></td></tr>'
                                        htmldata4 =  htmldata2 ;
                                    }
                                }
                            }
                        }
                        var htmldata = '<table class="table datatable" id="studentview" style="table-layout: fixed;"><thead><tr><th>Year</th><th>Fees Category</th><th>Fees Type</th><th>Actual / Due Amount</th><th>Amount due to be paid</th><th class="dis" style="display: none;">Discount</th><th class="scholar" style="display: none;">Scholarship</th><th>Select</th></tr></thead><tbody>'+htmldata2+'</tbody></table>';

                        $("#previousstudentdata").append(htmldata);
                        $('.datepicker').bind('keypress',function(e){
                            if (e.which) { return false; }
                        });
                        $('.datepicker').datepicker();
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
            return false;
        }
    </script>
    <script type="text/javascript">

        var validator = $("#add_role_form").validate({
            rules: {
                institution_name: { required: true, }, 
                institution_address: { required: true, },
                phone_number: { required: true, },
            },
            submitHandler: function(form) 
            { 
                editTemplate();
            }
        });
        function editTemplate()
        {
            var institution_name = $('#institution_name').val();
                institution_address = $('#institution_address').val();
                phone_number = $('#phone_number').val();
                photo = $('#setval').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("institution_name", institution_name);
                formData.append("institution_address", institution_address);
                formData.append("phone_number", phone_number);
                formData.append("photo", photo);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('feeTemplate/updateFeeTemplate') }}",
                method: 'post',
                contentType: false,
                processData: false,
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                data: formData,
                success: function(data) {

                    var response = JSON.parse(data);
                    if(response.success == 1)
                    {
                        $("#message-box-success").modal('show');    
                        setTimeout(function(){ 
                            $("#message-box-success").modal('hide');
                        }, 1500);
                        location.href="{{ url('/feeAllocation') }}";
                    }
                    else if(response.success == 2)
                    {
                        $("#message-box-danger12").modal('show');
                        setTimeout(function(){ $("#message-box-danger12").modal('hide') }, 1500);
                    }
                    else
                    {
                        $("#message-box-danger123").modal('show');
                        setTimeout(function(){ 
                            $("#message-box-danger123").modal('hide');
                        }, 1500);
                        return false;
                    }

                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }
    </script>
@endsection