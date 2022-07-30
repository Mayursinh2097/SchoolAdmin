@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Student</li>
        <li class="active">Board Form</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">     
            <div class="row">
                <div class="col-md-12">
                    <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Board Student</strong> {{$studentName}} </h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">LC Number</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="hidden" class="form-control" id="student_id" name="student_id" value="{{$student_id}}">
                                                <input type="text" class="form-control" id="lc_number" name="lc_number" required>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Date of Leaving the School</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                 <input type="date" class="form-control" name="date_of_leaving" id="date_of_leaving" required>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Remarks</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name="remark" id="remark" required>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Standard in which studying and Since when</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name="class_at_leaving" id="class_at_leaving" required>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Reason of Leaving the School</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" name="reason_of_leaving" id="reason_of_leaving" required>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">                                    
                                <button class="btn btn-primary pull-right" name="save" id="save">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                    
        </div>
    <!-- PAGE CONTENT WRAPPER -->

    <!-- ALERT BOX -->
         <div class="message-box message-box-success animated fadeIn" id="message-box-success">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                    <div class="mb-content">
                        <p style="font-size: 15px;">LC Allocate successfully.</p>
                    </div>
                    <div class="mb-footer"></div>
                </div>
            </div>
        </div>

        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                    <div class="mb-content">
                        <p style="font-size: 15px;"> Error has to be edited.</p>
                    </div>
                    <div class="mb-footer"></div>
                </div>
            </div>
        </div>
    <!-- END ALERT BOX -->
    @section('scripts')
    
    @endsection
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript">

       var validator = $("#add_role_form").validate({
            rules: {
                lc_number: { required: true },
                date_of_leaving: { required: true },
                remark: { required: true },
                class_at_leaving: { required: true },
                reason_of_leaving: { required: true },
            },
            submitHandler: function(form) 
            { 
                addStudentLc();
            }
        });
        function addStudentLc()
        {
            var lc_number = $('#lc_number').val();
                date_of_leaving = $('#date_of_leaving').val();
                remark = $('#remark').val();
                class_at_leaving = $('#class_at_leaving').val();
                reason_of_leaving = $('#reason_of_leaving').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                id = '<?php echo $student_id; ?>';
                // alert(school_id);

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("lc_number", lc_number);
                formData.append("date_of_leaving", date_of_leaving);
                formData.append("remark", remark);
                formData.append("class_at_leaving", class_at_leaving);
                formData.append("reason_of_leaving", reason_of_leaving);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);
                formData.append("id", id);

            $.ajax({
                url: "{{ url('student/addStudLC') }}",
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
                        location.href="{{ url('/student/LC') }}";
                    }
                    else
                    {
                        $("#message-box-danger").modal('show');
                        setTimeout(function(){ 
                            $("#message-box-danger").modal('hide');
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