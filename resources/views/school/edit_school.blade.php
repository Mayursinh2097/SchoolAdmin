@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>                    
        <li>School</li>
        <li class="active">Edit School Detail</li>
    </ul>
    <!-- END BREADCRUMB -->                       

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <form id="add_form" class="form-horizontal" enctype="multipart/form-data"> 
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Edit School Detail</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{url('school')}}" class="panel-remove" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">School Name</label>
                                            <div class="col-md-9">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="schoolname" name="schoolname" value="{{ $school->schoolname }}" />
                                                    <input type="hidden" class="form-control" id="school_id" name="school_id" value="{{ $school->school_id }}" />
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control email" id="email" name="email" value="{{ $school->email }}"/>
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Contact Number 1</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="contact_no1" name="contact_no1" maxlength="10" value="{{ $school->contact_no1 }}">
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Contact Number 2</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="contact_no2" name="contact_no2" maxlength="10" value="{{ $school->contact_no2 }}">
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3  control-label">Address</label>
                                            <div class="col-md-9 col-xs-12">
                                                <textarea class="form-control" rows="1" id="address" name="address" >{{ $school->address }}</textarea>
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">State</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control" name="state_id" id="state_id">
                                                    <option value="">Select</option>
                                                    <?php
                                                        foreach($states as $key => $st){
                                                    ?> 
                                                        <option value="<?php echo $st->state_id; ?>" <?php if($school->state_id == $st->state_id){ echo "selected"; }?> ><?php echo $st->state_name; ?></option>
                                                    <?php } ?> 
                                                </select>
                                                <span class="help-block">Select box </span>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">District</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control" name="district_id" id="district_id" value="<?php echo $school->district_id;?>">
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($districts as $key => $ds){
                                                    ?> 
                                                        <option value="<?php echo $ds->district_id; ?>" <?php if($school->district_id == $ds->district_id){ echo "selected"; }?> ><?php echo $ds->district_name; ?></option>
                                                    <?php } ?> 
                                                </select>
                                                <span class="help-block">Select box </span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">DISE Code</label>
                                            <div class="col-md-9">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="diseccode" name="diseccode" value="{{ $school->diseccode }}"/>
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Registration Number</label>
                                            <div class="col-md-9">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control"  id="registration_no" name="registration_no" value="{{ $school->registration_no }}"/>
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">School Number</label>
                                            <div class="col-md-9">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="school_no" name="school_no" value="{{ $school->school_no }}"/>
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Device ID</label>
                                            <div class="col-md-9">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="device_id" name="device_id" value="{{ $school->device_id }}" />
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Year of Establishment</label>
                                            <div class="col-md-9">                                            
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="year_establishment" name="year_establishment" value="{{ $school->year_establishment }}" />
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Language</label>
                                            <div class="col-md-6 col-xs-12">
                                                <select class="form-control select" name="MediumId" id="MediumId" value="{{ $school->MediumId }}">
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($mediums as $key => $md){
                                                    ?> 
                                                        <option value="<?php echo $md->MediumId; ?>" <?php if($school->MediumId == $md->MediumId){ echo "selected"; }?> ><?php echo $md->MediumName; ?></option>
                                                    <?php } ?> 
                                                </select>
                                                <span class="help-block">Select box </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Kindergarten Class</label>
                                            <div class="col-md-9">
                                                <?php 
                                                    foreach ($classes as $clk) {
                                                    if ($clk->class_type == 'KG') {
                                                ?>
                                                    <label class="check" style="margin-right: 15px;"><input type="checkbox" name="standard[]" class="icheckbox" value="<?php echo $clk->ClassName; ?>" <?php if ($clk->IsDelete == 0) { echo "checked"; } ?> > <?php echo $clk->ClassName; ?></label>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Primary Class</label>
                                            <div class="col-md-9">
                                                <?php foreach ($classes as $key => $clp) {
                                                if ($clp->class_type == 'Primary') {
                                                ?>
                                                <label class="check" style="margin-right: 15px;"><input type="checkbox" name="standard[]" class="icheckbox" value="<?php echo $clp->ClassName; ?>" <?php if ($clp->IsDelete == 0) { echo "checked"; } ?> > <?php echo $clp->ClassName; ?></label>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Seconday Class</label>
                                            <div class="col-md-9">
                                                <?php 
                                                    foreach ($classes as $key => $cls) {
                                                    if ($cls->class_type == 'Secondary') {
                                                ?>
                                                <label class="check" style="margin-right: 15px;"><input type="checkbox" name="standard[]" class="icheckbox" value="<?php echo $cls->ClassName; ?>" <?php if ($cls->IsDelete == 0) { echo "checked"; } ?> > <?php echo $cls->ClassName; ?></label>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Heigher Seconday Class</label>
                                            <div class="col-md-9">
                                                <?php 
                                                    foreach ($classes as $key => $clh) {
                                                    if ($clh->class_type == 'Heigher Secondary') {
                                                ?>
                                                <label class="check" style="margin-right: 15px;"><input type="checkbox" name="standard[]" class="icheckbox" value="<?php echo $clh->ClassName; ?>" <?php if ($clh->IsDelete == 0) { echo "checked"; } ?> > <?php echo $clh->ClassName; ?></label>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary pull-right" name="save" id="save">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->                                
            
    <!-- THIS PAGE PLUGINS -->    
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>  
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript">

        $('#diseccode').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        }); 
        $('#registration_no').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });
        $('#contact_no1').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });
        $('#school_no').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });
        $('#device_id').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });
        $('#year_establishment').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });
        $('#contact_no2').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });
        $('#MediumId').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });

        var validator = $("#add_form").validate({
            rules: {
                diseccode: { required: true, minlength: 9, maxlength: 10 },
                address: { required: true },
                schoolname: { required: true },
                state_id: { required: function () { return $(this).find('[name="state_id"]').val() != ''; } },
                district_id: { required: true },
                registration_no: { required: true, minlength: 1, maxlength: 10 },
                contact_no1: { required: true, minlength: 10, maxlength: 12 },
                email: { required: true, email: true },
                school_no: { required: true, minlength: 8, maxlength: 11 },
                device_id: { required: true, minlength: 1, maxlength: 10 },
                // year_establishment: { required: true, minlength: 4 maxlength: 4},
                contact_no2: { required: true, minlength: 10, maxlength: 12},
                MediumId: { required: true },
            },
            submitHandler: function(form) 
            { 
                editSchool();
            }
        });
        function editSchool()
        {
            // if($("#add_form").valid() == true)
            // {
                var class_array = [];
                var classes = [];

                var diseccode = $('#diseccode').val();
                    address = $('#address').val();
                    schoolname = $('#schoolname').val();
                    state_id = $('#state_id').val();
                    district_id = $('#district_id').val();
                    // taluka_id = $('#taluka_id').val();
                    registration_no = $('#registration_no').val();
                    contact_no1 = $('#contact_no1').val();
                    // contact_no2 = $('#contact_no2').val();
                    email = $('#email').val();
                    school_no = $('#school_no').val();
                    device_id = $('#device_id').val();
                    year_establishment = $('#year_establishment').val();
                    MediumId = $('#MediumId').val();
                    standard = $('#standard').val();
                    school_id = $('#school_id').val();
                    taluka_id = '0';

                var allVals = [];
                $('#mydiv :checked').each(function () {
                    allVals.push($(this).val());
                });
                var Standard = allVals;

                $('input[type=checkbox]').each(function () {
                    var class_name = $(this).val();
                    var test_check = this.checked ? "checked" : "not checked";
                    var is_delete = '';
                    if (test_check == 'checked') { is_delete = 0; }
                    else if (test_check == 'not checked') { is_delete = 1; }
                    class_array = {
                        'class_name' : class_name,
                        'is_delete' : is_delete,
                    }
                    classes.push(class_array);
                });
                class_array = JSON.stringify(classes);

                var formData = new FormData($('form#add_form')[0]);
                    formData.append("diseccode", diseccode);
                    formData.append("address", address);
                    formData.append("schoolname", schoolname);
                    formData.append("state_id", state_id);
                    formData.append("district_id", district_id);
                    // formData.append("taluka_id", taluka_id);
                    formData.append("registration_no", registration_no);
                    formData.append("contact_no1", contact_no1);
                    formData.append("contact_no2", contact_no2);
                    formData.append("email", email);
                    formData.append("school_no", school_no);
                    formData.append("device_id", device_id);
                    formData.append("year_establishment", year_establishment);
                    formData.append("MediumId", MediumId);
                    // formData.append("standard", Standard);
                    formData.append("class_array", class_array);
                    formData.append("school_id", school_id);

                $.ajax({
                    url: "{{ url('school/update') }}",
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
                        if(response.success == 1){
                            // alert(data.msg);
                            $("#message-box-success").modal('show');
                            setTimeout(function(){ $("#message-box-success").modal('hide'); }, 1500);
                            location.href="{{ url('/school') }}";
                        }else{
                            // alert(data.msg);
                            $("#message-box-danger").modal('show');
                            setTimeout(function(){ $("#message-box-danger").modal('hide'); }, 1500);
                            return false;
                        }
                    },error: function(xhr, status, error) {
                        alert('error : '+xhr.responseText);
                    }
                });
            }
        // }
    </script>
@endsection