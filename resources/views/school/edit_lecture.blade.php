@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">Edit Lecture</li>
    </ul>
    <!-- END BREADCRUMB --   >           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Edit Lecture</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{ url('/lecture') }}" class="panel-remove" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Day</label>
                                    <div class="col-md-9 col-xs-3">
                                        <select class="form-control" name="day_id" id="day_id">
                                            <option value="">Select</option>
                                            <?php   
                                                foreach($days as $key => $dy){
                                            ?> 
                                                <option value="<?php echo $dy->day_id; ?>"><?php echo $dy->day; ?></option>
                                                <option value="<?php echo $dy->day_id; ?>"<?php if($lecture->day_id==$dy->day_id){ echo "selected"; } ?>> <?php echo $dy->day; ?></option>
                                            <?php   }   ?> 
                                        </select>
                                        <span class="help-block">Select Class </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Lecture Name</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="hidden" class="form-control" id="lecture_id" name="lecture_id" value="{{ $lecture->lecture_id }}"/>
                                            <input type="text" class="form-control" id="lecture_name" name="lecture_name" value="{{ $lecture->lecture_name }}"/>
                                        </div>
                                        <span class="help-block">Fill up name</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Start Time</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="text" class="form-control" id="start_time" name="start_time" value="{{ $lecture->start_time }}"/>
                                        </div>
                                        <span class="help-block">Fill up name</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">End Time</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="text" class="form-control" id="end_time" name="end_time" value="{{ $lecture->end_time }}"/>
                                        </div>
                                        <span class="help-block">Fill up name</span>
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

    <div class="message-box message-box-success animated fadeIn" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Lecture edited successfully.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger123">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                <div class="mb-content">
                    <p> Lecture already inserted.</p>
                </div>
                <div class="mb-footer">
                    <!-- <button class="btn btn-default btn-lg pull-right mb-control-close">Close</button> -->
                </div>
            </div>
        </div>
    </div> 

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger45">
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

    <!-- PAGE CONTENT WRAPPER -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>

    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
    <script type="text/javascript">

        $("#start_time").inputmask("hh:mm t", {"placeholder": "hh:mm t"});
        $("#end_time").inputmask("hh:mm t", {"placeholder": "hh:mm t"});

        var validator = $("#add_role_form").validate({
            rules: {
                day_id: { required: true, },
                lecture_name: { required: true, },
                start_time: { required: true, },
                end_time: { required: true, },
            },
            submitHandler: function(form) 
            { 
                editLecture();
            }
        });
        function editLecture()
        {
            var day_id = $('#day_id').val();
                lecture_name = $('#lecture_name').val();
                start_time = $('#start_time').val();
                end_time = $('#end_time').val();
                lecture_id = $('#lecture_id').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                // alert(school_id);

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("day_id", day_id);
                formData.append("lecture_name", lecture_name);
                formData.append("start_time", start_time);
                formData.append("end_time", end_time);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);
                formData.append("lecture_id", lecture_id);

            $.ajax({
                url: "{{ url('lecture/updateLecture') }}",
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
                    if(response.success==1)
                    {
                        $("#message-box-success").modal('show');
                        setTimeout(function(){ 
                            $("#message-box-success").modal('hide');
                        }, 1500);
                        location.href="{{ url('/lecture') }}";
                    }
                    else if(response.success==2)
                    {
                        $("#message-box-danger123").modal('show');
                        setTimeout(function(){ $("#message-box-danger123").modal('hide') }, 1500);
                    }
                    else
                    {
                        $("#message-box-danger45").modal('show');
                        setTimeout(function(){ $("#message-box-danger45").modal('hide') }, 1500);
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }
    </script>
@endsection