@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">Edit Division</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Edit Division</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{ url('/division') }}" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Class Name</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <select class="form-control" name="ClassId" id="ClassId">
                                        <option value="">Select</option>
                                        <?php   
                                            foreach($classes as $key => $cl){
                                        ?> 
                                            <option value="<?php echo $cl->ClassId; ?>"<?php if($division->ClassId==$cl->ClassId){ echo "selected"; } ?>> <?php echo $cl->ClassName; ?></option>
                                        <?php } ?> 
                                    </select>
                                    <span class="help-block">Fill up the text field</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Division Name</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" class="form-control" id="DivisionName" name="DivisionName" value="{{ $division->DivisionName }}">
                                        <input type="hidden" class="form-control" id="DivisionId" name="DivisionId" value="{{ $division->DivisionId }}" />
                                    </div>                                            
                                    <span class="help-block">Fill up the text field</span>
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
                    <p style="font-size: 15px;">Division edited successfully.</p>
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
                    <p> Division already inserted.</p>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>  
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript">

        var validator = $("#add_role_form").validate({
            rules: {
                ClassId: { required: true },
                DivisionName: { required: true } 
            },
            submitHandler: function(form) 
            { 
                editDivision();
            }
        });
        function editDivision()
        {
            var ClassId = $('#ClassId').val();
                DivisionName = $('#DivisionName').val();
                DivisionId = $('#DivisionId').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                // alert(school_id);

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("ClassId", ClassId);
                formData.append("DivisionName", DivisionName);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);
                formData.append("DivisionId", DivisionId);

            $.ajax({
                url: "{{ url('division/updatedivision') }}",
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
                        location.href="{{ url('/division') }}";
                    }
                    else if(response.success==2)
                    {
                        $("#message-box-danger123").modal('show');
                        setTimeout(function(){ $("#message-box-danger123").modal('hide') }, 1500);
                    }
                    else
                    {
                        $("#message-box-danger45").modal('show');
                        return false;
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }
    </script>
@endsection