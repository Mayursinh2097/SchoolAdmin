@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">Edit Class</li>
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
                            <h3 class="panel-title"><strong>Edit Class</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{url('class')}}" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Class Type</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" class="form-control" id="class_type" name="class_type" value="{{ $classes->class_type }}">
                                        <input type="hidden" class="form-control" id="ClassId" name="ClassId" value="{{ $classes->ClassId }}" />
                                    </div>                                            
                                    <span class="help-block">Fill up the text field</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Class Name</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" class="form-control" id="ClassName" name="ClassName" value="{{ $classes->ClassName }}">
                                    </div>                                            
                                    <span class="help-block">Fill up the text field</span>
                                </div>
                            </div>
                            <div class="form-group" id="stream_div" style="display: none;">
                                <label class="col-md-3 col-xs-12 control-label">Stream</label>
                                <div class="col-md-6 col-xs-12">
                                    <select class="form-control" name="stream" id="stream">
                                        <option value="">Select</option>   
                                        <option value="Science">Science</option>   
                                        <option value="Commerce">Commerce</option>   
                                        <option value="Arts">Arts</option>   
                                    </select>
                                    <span class="help-block">Select stream</span>
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
                    <p style="font-size: 15px;">Class edited successfully.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger12">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                <div class="mb-content">
                    <p> Class already exist.</p>
                </div>
                <div class="mb-footer">
                    <!-- <button class="btn btn-default btn-lg pull-right mb-control-close">Close</button> -->
                </div>
            </div>
        </div>
    </div>  

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger123">
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
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript">

        $( "#ClassName" ).keyup(function() {
            // alert( "Handler for .keyup() called." );
            var class_name = $('#ClassName').val();
            if (class_name == '11' || class_name == '12') {
                $('#stream_div').show();
            }
            else{
                $('#stream_div').hide();
            }
        });

        var validator = $("#add_role_form").validate({
            rules: {
                ClassName: { required: true },
                class_type: { required: true },
            },
            submitHandler: function(form) 
            { 
                editClass();
            }
        });
        function editClass()
        {
            var class_type = $('#class_type').val();
                ClassName = $('#ClassName').val();
                stream = $('#stream').val();
                ClassId = $('#ClassId').val();

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("class_type", class_type);
                formData.append("ClassName", ClassName);
                formData.append("stream", stream);
                formData.append("ClassId", ClassId);

            $.ajax({
                url: "{{ url('class/updateclass') }}",
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
                        location.href="{{ url('/class') }}";
                    }
                    else if(response.success==2)
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