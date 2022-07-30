@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Fees</li>
        <li class="active">Edit Category</li>
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
                            <h3 class="panel-title"><strong>Edit Category</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{url('/category')}}" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Fee Category</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" class="form-control" id="fee_category" name="fee_category" value="{{ $categorys->fee_category_name }}">
                                        <input type="hidden" class="form-control" id="fee_category_id" name="fee_category_id" value="{{ $categorys->fee_category_id }}" />
                                    </div>                                            
                                    <span class="help-block">Fill up the text field</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Receipt No. Prefix</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <input type="text" class="form-control" id="receipt_no" name="receipt_no" value="{{ $categorys->receipt_prefix }}">
                                    </div>                                            
                                    <span class="help-block">Fill up the text field</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Description</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon" style="vertical-align: middle;"><span class="fa fa-pencil"></span></span>
                                        <textarea class="form-control" rows="2" id="description" name="description">{{ $categorys->description }}</textarea>
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
                    <p style="font-size: 15px;">Category edited successfully.</p>
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
                    <p> Category already inserted.</p>
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

        var validator = $("#add_role_form").validate({
            rules: {
                fee_category: { required: true },
                receipt_no: { required: true },
                description: { required: true },
            },
            submitHandler: function(form) 
            { 
                editCategory();
            }
        });

        function editCategory()
        {
            var fee_category = $('#fee_category').val();
                receipt_no = $('#receipt_no').val();
                description = $('#description').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                fee_category_id = $('#fee_category_id').val();

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("fee_category", fee_category);
                formData.append("receipt_no", receipt_no);
                formData.append("description", description);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);
                formData.append("fee_category_id", fee_category_id);

            $.ajax({
                url: "{{ url('category/updateCategory') }}",
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
                        location.href="{{ url('/category') }}";
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