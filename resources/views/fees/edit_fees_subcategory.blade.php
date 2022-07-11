@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Fees</li>
        <li class="active">Edit Fees SubCategory</li>
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
                            <h3 class="panel-title"><strong>Edit Fees SubCategory</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{url('subcategory')}}" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Fee Category</label>
                                        <div class="col-md-6 col-xs-12">
                                            <select class="form-control select"  id="fee_category_id" name="fee_category_id">
                                                <option value="">Select fee category</option>
                                                <?php   
                                                    foreach($categorys as $key => $cg){
                                                ?> 
                                                    <option value="<?php echo $cg->fee_category_id; ?>"<?php if($subcategory->fee_category_id == $cg->fee_category_id){ echo "selected"; } ?>> <?php echo $cg->fee_category_name; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <span class="help-block">Select box </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Amount</label>
                                        <div class="col-md-6 col-xs-12">                                   
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" id="amount" name="amount" value="{{$subcategory->amount}}"/>
                                                <input type="hidden" class="form-control" id="fee_subcategory_id" name="fee_subcategory_id" value="{{$subcategory->fee_subcategory_id}}"/>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Fee Sub Category Name</label>
                                        <div class="col-md-6 col-xs-12">           
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" class="form-control" id="fee_subcategory_name" name="fee_subcategory_name" value="{{$subcategory->fee_subcategory_name}}"/>
                                            </div>                                            
                                            <span class="help-block">Fill up the text field</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Fees Type</label>
                                        <div class="col-md-6 col-xs-12">          
                                            <select class="form-control select" id="fee_type" name="fee_type" >
                                                <option value="">Select</option>
                                                <option value="1" <?php if($subcategory->fee_type==1){ echo "selected"; }?> >Annual</option>
                                                <option value="2" <?php if($subcategory->fee_type==2){ echo "selected"; }?> >Bi-Annual</option>
                                                <option value="3" <?php if($subcategory->fee_type==3){ echo "selected"; }?> >Tri-Annual</option>
                                                <option value="4" <?php if($subcategory->fee_type==4){ echo "selected"; }?> >Quarterly</option>
                                                <option value="12" <?php if($subcategory->fee_type==12){ echo "selected"; }?> >Monthly</option>
                                               <!-- <option value="5">Monthly</option> -->
                                            </select>
                                            <span class="help-block">Select fees type</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="datelist" style="display:none">
                                    <!-- <div class="abc123 col-md-12" style="margin-top: 28px;"></div> -->
                                    <div class="abc123 col-md-12" style="margin-top: 28px;">
                                        <div id="Annual" style="display:none">
                                            <div class="col-md-4">
                                                <div class="form-group">                                 
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date1" name="start_date1" >
                                                        </div>
                                                        <span class="help-block"><!-- Select joining date --></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date1" name="due_date1" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date1" name="end_date1" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="Bi-Annual" style="display:none">
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date2" name="start_date2" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date2" name="due_date2" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date2" name="end_date2" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="Quarterly" style="display:none">
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date3" name="start_date3" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date3" name="due_date3" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date3" name="end_date3" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date4" name="start_date4" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date4" name="due_date4" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date4" name="end_date4" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="Monthly" style="display:none">
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date5" name="start_date5" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date5" name="due_date5" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date5" name="end_date5" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date6" name="start_date6" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date6" name="due_date6" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date6" name="end_date6" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date7" name="start_date7" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date7" name="due_date7" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date7" name="end_date7" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date8" name="start_date8" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date8" name="due_date8" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date8" name="end_date8" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date9" name="start_date9" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date9" name="due_date9" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date9" name="end_date9" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date10" name="start_date10" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date10" name="due_date10" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date10" name="end_date10" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date11" name="start_date11" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date11" name="due_date11" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date11" name="end_date11" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="start_date12" name="start_date12" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">Due Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="due_date12" name="due_date12" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">                                     
                                                    <label class="col-md-3 control-label">End Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            <input type="text" class="form-control datepicker" disabled id="end_date12" name="end_date12" >
                                                        </div>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
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
                </form>
            </div>
        </div>                    
    </div>

    <div class="message-box message-box-success animated fadeIn" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">SubCategory edited successfully.</p>
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
                    <p> SubCategory already exist.</p>
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
                fee_category_id: { required: true },
                fee_subcategory_name: { required: true },
                amount: { required: true }, 
                fee_type: { required: true },
            },
            submitHandler: function(form) 
            { 
                editSubCategory();
            }
        });
        function editSubCategory()
        {
            var fee_category_id = $('#fee_category_id').val();
                fee_subcategory_id = $('#fee_subcategory_id').val();
                fee_subcategory_name = $('#fee_subcategory_name').val();
                amount = $('#amount').val();
                fee_type = $('#fee_type').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("fee_category_id", fee_category_id);
                formData.append("fee_subcategory_id", fee_subcategory_id);
                formData.append("fee_subcategory_name", fee_subcategory_name);
                formData.append("amount", amount);
                formData.append("fee_type", fee_type);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('subcategory/updateSubCategory') }}",
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
                        location.href="{{ url('/subcategory') }}";
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