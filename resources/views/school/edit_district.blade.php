@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">Edit District</li>
    </ul>
    <!-- END BREADCRUMB --   >           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Edit District</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{ url('/district') }}" class="panel-remove" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">State</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <select class="form-control" name="state_id" id="state_id">
                                        <option value="">Select</option>
                                        <?php   
                                            foreach($states as $key => $st){
                                        ?> 
                                            <option value="<?php echo $st->state_id; ?>"<?php if($district->state_id==$st->state_id){ echo "selected"; } ?>> <?php echo $st->state_name; ?></option>
                                        <?php } ?> 
                                    </select>
                                    <span class="help-block">Fill up the text field</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">District</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" class="form-control" id="district_name" name="district_name" value="{{ $district->district_name }}">
                                        <input type="hidden" class="form-control" id="district_id" name="district_id" value="{{ $district->district_id }}" />
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
                    <p style="font-size: 15px;">District edited successfully.</p>
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
                    <p> District already inserted.</p>
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
                state_id: { required: true },
                district_name: { required: true } 
            },
            submitHandler: function(form) 
            { 
                editDistrict();
            }
        });
        function editDistrict()
        {
            var state_id = $('#state_id').val();
                district_name = $('#district_name').val();
                district_id = $('#district_id').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                // alert(school_id);

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("state_id", state_id);
                formData.append("district_name", district_name);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);
                formData.append("district_id", district_id);

            $.ajax({
                url: "{{ url('district/updatedistrict') }}",
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
                        location.href="{{ url('/district') }}";
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