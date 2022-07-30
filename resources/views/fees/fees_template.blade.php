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
        <li class="active">Fees Template</li>
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
                            <h3 class="panel-title"><strong>Fees Template</strong> </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Institution Name</label>
                                        <div class="col-md-9 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" id="institution_name" name="institution_name" value="{{$feetemplate->institution_name}}" required/>
                                            </div> 
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Institution Address</label>
                                        <div class="col-md-9 col-xs-12">           
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" id="institution_address" name="institution_address" value="{{$feetemplate->institution_address}}" required/>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Ph No.</label>
                                        <div class="col-md-9 col-xs-12">           
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{$feetemplate->phone_number}}" required/>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Logo</label>
                                        <div class="col-md-3">  
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="pic_btn">
                                                Upload logo
                                            </button>                    
                                            <span class="help-block">Upload logo</span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-6 crop_preview">
                                                <div id="upload-image-i">
                                                    <img hieght="150" width="150" id="pic" src="{{asset('file_upload/template/')}}/{{$feetemplate->photo}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input type='hidden' value='' id='setval'>
                            <button class="btn btn-primary pull-right" name="save" id="save">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                    
    </div>

    <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <div class="modal-dialog" role="document" style="width: 600px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Crop Image</b>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </h5>
                        <input type="file" id="images">
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <div id="upload-image"></div>
                            </div>   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary cropped_image" data-dismiss="modal">Upload Image</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- modal close -->

    <div class="message-box message-box-success animated fadeIn" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p>Template added successfully.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-success animated fadeIn" id="message-box-success1">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Template edited successfully.</p>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var resize = $('#upload-image').croppie({
            enableExif: true,
            enableOrientation: true,    
            viewport: { // Default { width: 100, height: 100, type: 'square' } 
                width: 150,
                height: 150,
                // type: 'circle' //square
                type: 'square'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });
        $('#images').on('change', function () { 
          var reader = new FileReader();
            reader.onload = function (e) {
                resize.croppie('bind',{
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('.cropped_image').on('click', function (ev) {
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (img) {
                $.ajax({
                    url: "{{route('templateuploadImage')}}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {"image":img},
                    success: function (data) {
                        var response = JSON.parse(data);
                        // alert(response.image);

                        html = '<img src="' + img + '" />';
                        $("#upload-image-i").html(html);

                        $("#setval").val(response.image);
                    }
                });
            });
        });

        function readURL(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
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
                        location.reload();
                    }
                    else if(response.success == 2)
                    {
                        $("#message-box-success1").modal('show');
                        setTimeout(function(){ $("#message-box-success1").modal('hide') }, 1500);
                        location.reload();
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