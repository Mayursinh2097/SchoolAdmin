@extends('master.master')

@section('content')

    <link rel="stylesheet" href="{{asset('crop/croppie1.css')}}">
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">Edit Class</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <form id="add_form"  class="form-horizontal" enctype="multipart/form-data" role="form">
            {{csrf_field()}}
            <div class="row">
                <!-- ..............................PERSONAL DETAIL............................................ -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><!-- <strong> -->Personal Details<!-- </strong> --> </h3>
                                <ul class="panel-controls">
                                    <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                </ul>
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Admission Year</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="admission_year_id" name="admission_year_id" disabled>
                                                    <option value="">Select</option>
                                                    <option value="3" <?php if ($students->admission_year_id == 3) { echo "selected"; } ?> >2019-2020</option>
                                                    <option value="4" <?php if ($students->admission_year_id == 4) { echo "selected"; } ?> >2020-2021</option>
                                                    <option value="5" <?php if ($students->admission_year_id == 5) { echo "selected"; } ?> >2021-2022</option>
                                                    <option value="6" <?php if ($students->admission_year_id == 6) { echo "selected"; } ?> >2022-2023</option>
                                                </select>
                                                <span class="help-block">Select admission year</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Name</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{$students->StudentName}}" />
                                                    <input type="hidden" class="form-control" id="StudentId" name="StudentId" value="{{ $students->StudentId }}" />
                                                </div>
                                                <span class="help-block">Fill up name</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date of Birth</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    <input type="date" class="form-control" id="dob" name="dob" value="{{$students->dob}}" >
                                                </div>
                                                <span class="help-block">Click on input field to select your date of birth</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!-- <label class="col-md-3 control-label">Age on 2020-06-01</label> -->
                                            <label class="col-md-3 control-label">Age</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="age" name="age" disabled value="{{$students->age}}">
                                                </div>
                                                <span class="help-block">This field is required</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Admission Type</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="type_admission" name="type_admission">
                                                    <option value="">Select</option>
                                                    <option value="1" <?php if ($students->type_admission == 1) { echo "selected"; } ?> >RTE</option>
                                                    <option value="2" <?php if ($students->type_admission == 2) { echo "selected"; } ?> >NON - RTE</option>
                                                </select>
                                                <span class="help-block">Select admission type</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Admission Hostel Type</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="hostel_type" name="hostel_type">
                                                    <option value="">Select</option>
                                                    <option value="1" <?php if ($students->hostel_type == 1) { echo "selected"; } ?> >Hostel</option>
                                                    <option value="2" <?php if ($students->hostel_type == 2) { echo "selected"; } ?> >NON - Hostel</option>
                                                </select>
                                                <span class="help-block">Select admission hostel type</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Gender</label>
                                            <div class="col-md-9">
                                                <label class="check"><input type="radio" class="iradio" value="1" name="gender" id="gender" <?php if(isset($students->Gender)) { if($students->Gender=='1'){?> checked="checked" <?php } } ?> /> Male </label>
                                                <label class="check"><input type="radio" class="iradio" value="2" name="gender" id="gender" <?php if(isset($students->Gender)) { if($students->Gender=='2'){?> checked="checked" <?php } } ?> /> Female</label>
                                                <span class="help-block">Select Gender</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                            <label class="col-md-3 control-label">Birth Place</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="birth_place" name="birth_place" value="{{$students->BirthPlace}}" />
                                                </div>
                                                <span class="help-block">Fill up birth place</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Religion</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="religious" id="religious">
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($religions as $key => $rg){
                                                    ?> 
                                                        <option value="<?php echo $rg->ReligionId; ?>"<?php if($students->ReligionId==$rg->ReligionId){ echo "selected"; } ?>> <?php echo $rg->ReligionName; ?></option>
                                                    <?php } ?> 
                                                </select>
                                                <span class="help-block">Select religion</span>
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Cast</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="cast" name="cast" maxlength="12" value="{{$students->cast}}">
                                                </div>
                                                <span class="help-block">Fill up cast number</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Subcast</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="subcast" name="subcast" maxlength="12" value="{{$students->subcast}}">
                                                </div>
                                                <span class="help-block">Fill up subcast number</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Photo</label>
                                            <div class="col-md-3">  
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Upload photo</button>
                                                <span class="help-block">Upload photo</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-6 crop_preview">
                                                    <div id="upload-image-i">
                                                        <img <?php if(empty($students->Photo)){ if($students->Gender == 1){ ?> src="{{asset('file_upload')}}/boy.png" <?php }elseif($students->Gender == 2){ ?> src="{{asset('file_upload')}}/girl.png" <?php } }else{ ?> src="{{asset('file_upload/student/')}}/<?php echo $students->Photo; ?>" <?php } ?> alt="<?php echo $students->StudentName; ?>" hieght="150" width="150" id="pic" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- ..............................END PERSONAL DETAIL............................................ -->

                <!-- ..............................FAMILY  DETAIL............................................ -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Family Details</h3>
                                <ul class="panel-controls">
                                    <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="abc123 col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Father Name</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="father_name" name="father_name" value="{{$students->FatherName}}" />
                                                    </div>                                     
                                                    <span class="help-block">Fill up father name</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Father Education</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <select class="form-control" name="father_edu" id="father_edu">
                                                        <option value="">Select</option>
                                                        <?php   
                                                            foreach($education as $key => $ed){
                                                        ?> 
                                                            <option value="<?php echo $ed->EducationId; ?>"<?php if($students->FatherEducation==$ed->EducationId){ echo "selected"; } ?>> <?php echo $ed->EducationName; ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                    <span class="help-block">Select father education </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Father Occupation</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="father_occupation" name="father_occupation" value="{{$students->FatherOccupation}}" />
                                                    </div>
                                                    <span class="help-block">Fill up father occupation</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Category</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="category" id="category">
                                                        <option value="">Select</option>
                                                        <?php   
                                                            foreach($category as $key => $ct){
                                                        ?> 
                                                            <option value="<?php echo $ct->CategoryId; ?>"<?php if($students->CategoryId==$ct->CategoryId){ echo "selected"; } ?>> <?php echo $ct->CategoryName; ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                    <span class="help-block">Select category</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Contact Number1 (Mobile Number)</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="contact1" name="contact1" maxlength="10" value="{{$students->ContactNumber1}}" />
                                                    </div>
                                                    <span class="help-block">Fill up contact number1</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Permenant Address</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <textarea class="form-control" rows="3" id="p_address" name="p_address">{{$students->PermenantAddress}}</textarea>
                                                    <span class="help-block">Fill up permenant address</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Mother Name</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{$students->MotherName}}" />
                                                    </div>
                                                    <span class="help-block">Fill up mother name</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Mother Education</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <select class="form-control" name="mother_edu" id="mother_edu">
                                                        <option value="">Select</option>
                                                        <?php   
                                                            foreach($education as $key => $ed){
                                                        ?> 
                                                            <option value="<?php echo $ed->EducationId; ?>"<?php if($students->MothersEucation==$ed->EducationId){ echo "selected"; } ?>> <?php echo $ed->EducationName; ?></option>
                                                        <?php } ?> 
                                                    </select>
                                                    <span class="help-block">Select mother education </span>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Mother Occupation</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="mother_occupation" name="mother_occupation" value="{{$students->MotherOccupation}}" />
                                                    </div>
                                                    <span class="help-block">Fill up mother occupation</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Contact Number2 (Mobile Number)</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="contact2" name="contact2" maxlength="10" value="{{$students->ContactNumber2}}" />
                                                    </div>
                                                    <span class="help-block">Fill up contact number2</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Current Address</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <textarea class="form-control" rows="3" id="c_address" name="c_address">{{$students->CurrentAddress}}</textarea>
                                                    <span class="help-block">Fill up Current address</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: none;">
                                                <label class="col-md-3 col-xs-12 control-label">lblCaste</label>
                                                <div class="col-md-6 col-xs-12">
                                                    <select class="form-control select" id="lbl_caste" name="lbl_caste">
                                                        <option value="">Select</option>
                                                        <option value="123" selected >lblCaste</option>
                                                    </select>
                                                    <span class="help-block">Select lblcaste </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- abc123 col-md-12 complete -->
                                    <div class="xyz123 col-md-12" style="margin-top: 15px;">
                                        <div class="col-md-6">
                                            
                                            
                                        </div>
                                        <div class="col-md-6">
                                            
                                            
                                        </div>
                                    </div><!-- xyz123 col-md-12 complete -->
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- ........................................END FAMILY  DETAIL............................ -->

                <!-- ........................................BANK DETAILS............................ -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Bank Details</h3>
                                <ul class="panel-controls">
                                    <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                </ul>
                            </div>
                            <div class="panel-body">       
                                <div class="row">
                                    <div class="abc123 col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Bank Account Number</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="acc_number" name="acc_number" value="{{$students->acc_number}}">
                                                    </div>
                                                    <span class="help-block">Fill up Bank Account Number</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Bank Name</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{$students->bank_name}}">
                                                    </div>
                                                    <span class="help-block">Fill up Bank name</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Name on Passbook</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="passbook_name" name="passbook_name" value="{{$students->passbook_name}}">
                                                    </div>
                                                    <span class="help-block">Fill up Passbook name</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Bank Branch</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="bank_branch" name="bank_branch" value="{{$students->bank_branch}}">
                                                    </div>
                                                    <span class="help-block">Fill up Branch name</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">IFSC Code</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{$students->ifsc_code}}">
                                                    </div>
                                                    <span class="help-block">Fill up IFSC Code</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- ........................................END BANK DETAILS............................ -->

                <!-- .............................. ADMISSION DETAIL........................................ -->
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Admission Details</h3>
                                <ul class="panel-controls">
                                    <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Admission Date</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    <input type="date" class="form-control" id="admission_date" name="admission_date" value="{{$students->AdmissionDate}}">
                                                </div>
                                                <span class="help-block">Select your admission date</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Enter Previous School Name</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="prev_school" value="{{$students->PreviousSchoolId}}" name="prev_school"/>
                                                </div>
                                                <span class="help-block">Fill up or enter previous school name</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Previous G.R. Number</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="prev_gr" name="prev_gr" value="{{$students->PreGRNumber}}" />
                                                </div>
                                                <span class="help-block">Fill up previous G.R. number</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Previous Result</label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="prev_result" name="prev_result" disabled>
                                                    <option value="">Select</option>
                                                    <option value="1" <?php if ($students->prev_result == 1) { echo "selected"; } ?> >Pass</option>
                                                    <option value="0" <?php if ($students->prev_result == 0) { echo "selected"; } ?> >Fail</option>
                                                </select>
                                                <span class="help-block">Fill up previous result</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Admission Class</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="admission_class" name="admission_class" onchange="get_div(this.value)" disabled>      
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($classes as $key => $cl){
                                                    ?> 
                                                        <option value="<?php echo $cl->ClassId; ?>"<?php if($students->ClassId==$cl->ClassId){ echo "selected"; } ?>> <?php echo $cl->ClassName; ?></option>
                                                    <?php } ?> 
                                                </select>
                                                <span class="help-block">Select admission class </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Language Medium</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control select" id="lenguage_medium" name="lenguage_medium">
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($mediums as $key => $md){
                                                    ?> 
                                                        <option value="<?php echo $md->MediumId; ?>"<?php if($students->MediumId==$md->MediumId){ echo "selected"; } ?>> <?php echo $md->MediumName; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="help-block">Select language medium</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">G.R.Number</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control number" id="gr_number" name="gr_number" value="{{$students->GRNumber}}" />
                                                </div>
                                                <span class="help-block">Fill up G.R.number</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">BPL Card Number</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control number" id="bpl_card_num" name="bpl_card_num" value="{{$students->bpl_card_num}}">
                                                </div>
                                                <span class="help-block">Fill up bpl card number</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">First Admission</label>
                                            <div class="col-md-9"> 
                                                    <label class="check">
                                                        <input type="checkbox" id="first_admission" name="first_admission" value="1" onclick="checkFluency()" <?php if($students->FirstAdmission=='1'){ ?> checked="checked" <?php } else { ?> <?php } ?> >
                                                     </label>
                                                <span class="help-block">First admission</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Aadhar Number</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="aadhar_num" name="aadhar_num" value="{{$students->AadharNumber}}" maxlength="12">
                                                </div>
                                                <span class="help-block">Fill up aadhar number</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Previous Attended Class</label>
                                            <div class="col-md-9 col-xs-12">
                                            <!-- <div class="input-group">   -->
                                                <select class="form-control select" id="prev_class" name="prev_class">
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($classes as $key => $cl){
                                                    ?> 
                                                        <option value="<?php echo $cl->ClassId; ?>"<?php if($students->PreviousAttendedClassId==$cl->ClassId){ echo "selected"; } ?>> <?php echo $cl->ClassName; ?></option>
                                                    <?php } ?>
                                                </select>
                                            <!-- </div> -->
                                                <span class="help-block">Select previous attended class </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Previous Result Grade</label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <!-- <input type="text" class="form-control" id="aadhar_num" name="aadhar_num" maxlength="12"> -->
                                                    <input type="text" class="form-control" id="prev_grade" name="prev_grade" maxlength="12" value="{{$students->prev_grade}}">
                                                </div>
                                                <span class="help-block">Fill up previous grade or percentage</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Division</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="admission_div" name="admission_div" disabled>
                                                    <option value="">Select division</option>
                                                    
                                                </select>
                                            <span class="help-block">Select division </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">DeviceID </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="device_id" name="device_id" value="0" />
                                                </div>
                                                <span class="help-block">Fill up deviceID </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">UID Number </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="uid_number" name="uid_number" value="{{$students->uid_number}}">
                                                </div>
                                                <span class="help-block">Fill up UID Number </span>
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
                    </div>
                <!-- ........................................END ADMISSION DETAIL................. -->
            </div>
        </form>             
    </div>

    <!-- Modal Image Crop-->
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
                                <div id="upload-image" style="margin-top: -10px; "></div>
                            </div>   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary cropped_image" data-dismiss="modal">Upload Image</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- modal Image Crop close -->

    <div class="message-box message-box-success animated fadeIn" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Student data is updated Successfully.</p>
                </div>
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <!-- PAGE CONTENT WRAPPER -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
    <!-- <script type="text/javascript" src="{{ asset('crop/upload1.js')}}"></script> -->
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
                width: 200,
                height: 200,
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
                    url: "{{route('uploadImage')}}",
                    type: "POST",
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
    </script>
    <script type="text/javascript">

        $('#dob').change(function(){
            // alert('hii');
            // var today = new Date('2020-06-01'); //alert(today);
            var today = new Date(); //alert(today);
            var birthDate = new Date(this.value); //alert(birthDate);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            //alert(age);
            $('#age').val(age);
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

        function checkFluency()
        {
            var checkbox = document.getElementById('first_admission');
            if (checkbox.checked == true)   //tick
            {
                // document.getElementById('p_class').style.display = "none";

                document.getElementById('prev_school').disabled = true;
                // document.getElementById('prev_school1').disabled = true;
                document.getElementById('prev_gr').disabled = true;
                document.getElementById('prev_class').disabled = true;
                document.getElementById('prev_grade').disabled = true;
                // alert("disable previous");
            }
            else if (checkbox.checked == false) //not tick
            {
                // document.getElementById('p_class').style.display = "block";

                document.getElementById('prev_school').disabled = false;
                // document.getElementById('prev_school1').disabled = false;
                document.getElementById('prev_gr').disabled = false;
                document.getElementById('prev_class').disabled = false;
                document.getElementById('prev_grade').disabled = false;
                // alert("show previous");
            }
        }

        window.onload = function() 
        {
            var checkbox = document.getElementById('first_admission');
            if (checkbox.checked == true)
            {
                document.getElementById('prev_school').disabled = true;
                // document.getElementById('prev_school1').disabled = true;
                document.getElementById('prev_gr').disabled = true;
                document.getElementById('prev_class').disabled = true;
                document.getElementById('prev_grade').disabled = true;
            }
            else if (checkbox.checked == false)
            {
                document.getElementById('prev_school').disabled = false;
                // document.getElementById('prev_school1').disabled = false;
                document.getElementById('prev_gr').disabled = false;
                document.getElementById('prev_class').disabled = false;
                document.getElementById('prev_grade').disabled = false;
            }
        }

        $('#aadhar_num').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });

        $('#contact1').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });

        $('#contact2').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });

        $('#device_id').bind('keypress',function(e){
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });

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
                    $("#admission_div").empty();
                      
                    if(response.data != null){
                        len = response.data.length;
                    }
                    if(len > 0)
                    {
                        html_data += '<option value="">Select</option>';
                        // $("#div_id").append(html_data);
                        for(var i=0; i<len; i++)
                        {
                            /*var id = response.data[i].DivisionId;
                            var name = response.data[i].DivisionName;*/
                            html_data += "<option value='"+response.data[i].DivisionId+"'>"+response.data[i].DivisionName+"</option>"; 
                            $("#admission_div").html(html_data); 
                        } 
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }

        $( document ).ready(function() {
            get_div('<?php echo $students->ClassId; ?>');
            // document.getElementById('admission_div').value='<?php echo $students->DivisionId; ?>';
            // $('#admission_div').val('1');
            setTimeout(function(){ 
                $('#admission_div').val('<?php echo $students->DivisionId; ?>');
                // alert("Hello");
            }, 1000);
        });

        var validator = $("#add_form").validate({
            ignore: [],
            rules: {

            },
            submitHandler: function(form) 
            { 
                editStudent();
            }
        });

        function editStudent()
        {
            var name = $('#name').val();
                gender = $('#gender:checked').val();
                dob = $('#dob').val();
                birth_place = $('#birth_place').val();
                aadhar_num = $('#aadhar_num').val();
                photo = $('#setval').val();

                category = $('#category').val();
                religious = $('#religious').val();
                father_name = $('#father_name').val();
                father_edu = $('#father_edu').val();
                mother_name = $('#mother_name').val();
                mother_edu = $('#mother_edu').val();
                father_occupation = $('#father_occupation').val();
                mother_occupation = $('#mother_occupation').val();
                lbl_caste = $('#lbl_caste').val();
                p_address = $('#p_address').val();
                c_address = $('#c_address').val();
                contact1 = $('#contact1').val();
                contact2 = $('#contact2').val();

                acc_number = $('#acc_number').val();
                bank_name = $('#bank_name').val();
                bank_branch = $('#bank_branch').val();

                admission_date = $('#admission_date').val();
                first_admission = $('#first_admission:checked').val();
                prev_school = $('#prev_school').val();
                prev_gr = $('#prev_gr').val();
                prev_class = $('#prev_class').val();
                admission_class = $('#admission_class').val();
                admission_div = $('#admission_div').val();
                lenguage_medium = $('#lenguage_medium').val();
                gr_number = $('#gr_number').val();
                device_id = $('#device_id').val();
                uid_number = $('#uid_number').val();

                age = $('#age').val();
                admission_year_id = $('#admission_year_id').val();
                type_admission = $('#type_admission').val();
                hostel_type = $('#hostel_type').val();
                cast = $('#cast').val();
                subcast = $('#subcast').val();
                ifsc_code = $('#ifsc_code').val();
                passbook_name = $('#passbook_name').val();
                prev_result = $('#prev_result').val();
                prev_grade = $('#prev_grade').val();
                bpl_card_num = $('#bpl_card_num').val();

                id =  $('#StudentId').val();
                year_id = '<?php echo $year_id; ?>';

            if($("#first_admission").prop('checked') == true)
            {
                var first_admission = $('#first_admission:checked').val();
            }
            else
            {
                var first_admission = '0';
            }

            var formData = new FormData($('#add_form')[0]);

                formData.append("name", name);
                formData.append("gender", gender);
                formData.append("dob", dob);
                formData.append("birth_place", birth_place);
                formData.append("aadhar_num", aadhar_num);
                formData.append("photo", photo);

                formData.append("category", category);
                formData.append("religious", religious);
                formData.append("father_name", father_name);
                formData.append("father_edu", father_edu);
                formData.append("mother_name", mother_name);
                formData.append("mother_edu", mother_edu);
                formData.append("father_occupation", father_occupation);
                formData.append("mother_occupation", mother_occupation);
                formData.append("lbl_caste", lbl_caste);
                formData.append("p_address", p_address);
                formData.append("c_address", c_address);
                formData.append("contact1", contact1);
                formData.append("contact2", contact2);

                formData.append("acc_number", acc_number);
                formData.append("bank_name", bank_name);
                formData.append("bank_branch", bank_branch);

                formData.append("admission_date", admission_date);
                formData.append("first_admission", first_admission);
                formData.append("prev_school", prev_school);
                formData.append("prev_gr", prev_gr);
                formData.append("prev_class", prev_class);
                formData.append("admission_div", admission_div);
                formData.append("lenguage_medium", lenguage_medium);
                formData.append("gr_number", gr_number);
                formData.append("device_id", device_id);
                formData.append("uid_number", uid_number);

                formData.append("age", age);
                formData.append("admission_year_id", admission_year_id);
                formData.append("type_admission", type_admission);
                formData.append("hostel_type", hostel_type);
                formData.append("cast", cast);
                formData.append("subcast", subcast);
                formData.append("ifsc_code", ifsc_code);
                formData.append("passbook_name", passbook_name);
                formData.append("prev_result", prev_result);
                formData.append("prev_grade", prev_grade);
                formData.append("bpl_card_num", bpl_card_num);

                formData.append("id", id);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('students/update') }}",
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
                        location.href="{{ url('/students') }}";
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