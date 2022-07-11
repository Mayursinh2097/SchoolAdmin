@extends('master.master')

@section('content')
    <style type="text/css">
        .cl{
            color: #000 !important;
        }
    </style>
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Fees</li>
        <li class="active">Add SubCategory</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">     
            <div class="row">
                <div class="col-md-12">
                    <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Add Fees SubCategory</strong> </h3>
                                <ul class="panel-controls">
                                    <li><a href="{{url('/subcategory')}}" title="Cancel"><span class="fa fa-times"></span></a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Fee Category</label>
                                            <div class="col-md-9 col-xs-12">
                                                <select class="form-control"  id="fee_category_id" name="fee_category_id" required>
                                                    <option value="">Select</option>
                                                    <?php   
                                                        foreach($categorys as $key => $cg){
                                                    ?> 
                                                        <option value="<?php echo $cg->fee_category_id; ?>"><?php echo $cg->fee_category_name; ?></option>
                                                    <?php   }   ?> 
                                                </select>
                                            <span class="help-block">Select box </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Amount</label>
                                            <div class="col-md-9 col-xs-12">           
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="amount" name="amount" required/>
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Fee Sub Category Name</label>
                                            <div class="col-md-9 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input type="text" class="form-control" id="fee_subcategory_name" name="fee_subcategory_name" required/>
                                                </div>                                            
                                                <span class="help-block">Fill up the text field</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Fees Type</label>
                                             <div class="col-md-9 col-xs-12">
                                                <select class="form-control" id="fee_type" name="fee_type" required>
                                                    <option value="">Select</option>
                                                    <option value="1">Annual</option>
                                                    <option value="2">Bi-Annual</option>
                                                    <option value="3">Tri-Annual</option>
                                                    <option value="4">Quarterly</option>
                                                    <option value="12">Monthly</option>
                                                </select>
                                                <span class="help-block">Select fees type</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="datelist" style="display:none">
                                        <div class="abc123 col-md-12" style="margin-top: 28px;">
                                            <div class="col-md-4">
                                                <div class="form-group">                                 
                                                    <label class="col-md-3 control-label">Start Date</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-calendar"></span>
                                                            </span>
                                                            <input type="date" class="form-control" id="starting_date" name="starting_date">
                                                        </div>
                                                        <span class="help-block">Click on input field to select date</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="abc123 col-md-12" style="margin-top: 28px;">
                                            <div id="Annual" style="display:none;">
                                                <div class="col-md-4">
                                                    <div class="form-group">                                 
                                                        <label class="col-md-3 control-label">Start Date</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control datepicker cl" id="start_date1" name="start_date1" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control datepicker cl" id="due_date1" name="due_date1" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date1" name="end_date1" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date2" name="start_date2" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date2" name="due_date2" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date2" name="end_date2" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date3" name="start_date3" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date3" name="due_date3" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date3" name="end_date3" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date4" name="start_date4" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date4" name="due_date4" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date4" name="end_date4" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date5" name="start_date5" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date5" name="due_date5" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date5" name="end_date5" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date6" name="start_date6" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date6" name="due_date6" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date6" name="end_date6" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date7" name="start_date7" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date7" name="due_date7" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date7" name="end_date7" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date8" name="start_date8" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date8" name="due_date8" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date8" name="end_date8" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date9" name="start_date9" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date9" name="due_date9" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date9" name="end_date9" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date10" name="start_date10" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date10" name="due_date10" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date10" name="end_date10" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date11" name="start_date11" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date11" name="due_date11" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date11" name="end_date11" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="start_date12" name="start_date12" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="due_date12" name="due_date12" disabled>
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
                                                                <span class="input-group-addon">
                                                                    <span class="fa fa-calendar"></span>
                                                                </span>
                                                                <input type="text" class="form-control cl datepicker" id="end_date12" name="end_date12" disabled>
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
    <!-- PAGE CONTENT WRAPPER -->

    <!-- ALERT BOX -->
         <div class="message-box message-box-success animated fadeIn" id="message-box-success">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                    <div class="mb-content">
                        <p style="font-size: 15px;">SubCategory added successfully.</p>
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
                        <p style="font-size: 15px;"> Error has to be added.</p>
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
        $('#amount').bind('keypress',function(e)
        {
            return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
        });

        $( "#starting_date" ).change(function() {
            // alert( "Handler for .change() called." );
            var start_term = $(this).val();
                fee_type = $('#fee_type').val();

            if (fee_type == 1) 
            {
                $("#start_date1").val(start_term);

                var newdate = new Date(start_term);
                newdate.setDate(newdate.getDate() + 60);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date1").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 20);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date1").val(someFormattedDate);
            }

            if (fee_type == 2) 
            {
                $("#start_date1").val(start_term);
                        
                var newdate = new Date(start_term);
                newdate.setDate(newdate.getDate() + 60);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date1").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 20);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date1").val(someFormattedDate);

                // ...................................................

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 90);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#start_date2").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 60);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date2").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 20);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date2").val(someFormattedDate);
            }

            if (fee_type == 3) 
            {
                $("#start_date1").val(start_term);
                
                var newdate = new Date(start_term);
                newdate.setDate(newdate.getDate() + 52);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date1").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 15);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date1").val(someFormattedDate);

                // ...................................................

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 60);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#start_date3").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 52);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date3").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 15);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date3").val(someFormattedDate);

                // ...................................................

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 20);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#start_date4").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 60);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date4").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 20);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date4").val(someFormattedDate);
            }

            if (fee_type == 4)
            {
                $("#start_date1").val(start_term);
                        
                var newdate = new Date(start_term);
                newdate.setDate(newdate.getDate() + 45);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date1").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 15);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date1").val(someFormattedDate);

                // ...................................................

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 10);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#start_date2").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 45);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date2").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 15);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date2").val(someFormattedDate);

                // ...................................................

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 20);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#start_date3").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 45);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date3").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 15);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date3").val(someFormattedDate);

                // ...................................................

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 10);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#start_date4").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 45);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#due_date4").val(someFormattedDate);

                var newdate = new Date(someFormattedDate);
                newdate.setDate(newdate.getDate() + 15);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd;
                $("#end_date4").val(someFormattedDate);
            }

            if (fee_type == 12) 
            {
                var newdate = new Date(start_term);
                    dd1 = newdate.getDate();

                if (dd1 > 20) {
                    $('#starting_date').parent().siblings('.help-block').css( "color", "#E04B4A" ).html("please select date before 21");
                    // $('#starting_date').addClass("error");
                    return false;
                }
                else if (dd1 < 20 || dd1 == 20){
                    $(this).parent().siblings('.help-block').css( "color", "#AAB2BD" ).html("Click on input field to select date");
                    $('#starting_date').removeClass("error");
                }

                var start_date1 = date_count(start_term, 0, 0, '');
                    due_date1 = date_count(start_date1, 15, 0, 'duedate');
                    start_date2 = date_count(start_date1, 0, 1, 'startdate');

                    end_date1 = date_count(start_date2, -1, 0, '');
                    due_date2 = date_count(due_date1, 0, 0, 'duedate');
                    start_date3 = date_count(start_date2, 0, 1, 'startdate');

                    end_date2 = date_count(start_date3, -1, 0, '');
                    due_date3 = date_count(due_date2, 0, 0, 'duedate');
                    start_date4 = date_count(start_date3, 0, 1, 'startdate');

                    end_date3 = date_count(start_date4, -1, 0, '');
                    due_date4 = date_count(due_date3, 0, 0, 'duedate');
                    start_date5 = date_count(start_date4, 0, 1, 'startdate');

                    end_date4 = date_count(start_date5, -1, 0, '');
                    due_date5 = date_count(due_date4, 0, 0, 'duedate');
                    start_date6 = date_count(start_date5, 0, 1, 'startdate');

                    end_date5 = date_count(start_date6, -1, 0, '');
                    due_date6 = date_count(due_date5, 0, 0, 'duedate');
                    start_date7 = date_count(start_date6, 0, 1, 'startdate');

                    end_date6 = date_count(start_date7, -1, 0, '');
                    due_date7 = date_count(due_date6, 0, 0, 'duedate');
                    start_date8 = date_count(start_date7, 0, 1, 'startdate');

                    end_date7 = date_count(start_date8, -1, 0, '');
                    due_date8 = date_count(due_date7, 0, 0, 'duedate');
                    start_date9 = date_count(start_date8, 0, 1, 'startdate');

                    end_date8 = date_count(start_date9, -1, 0, '');
                    due_date9 = date_count(due_date8, 0, 0, 'duedate');
                    start_date10 = date_count(start_date9, 0, 1, 'startdate');

                    end_date9 = date_count(start_date10, -1, 0, '');
                    due_date10 = date_count(due_date9, 0, 0, 'duedate');
                    start_date11 = date_count(start_date10, 0, 1, 'startdate');

                    end_date10 = date_count(start_date11, -1, 0, '');
                    due_date11 = date_count(due_date10, 0, 0, 'duedate');
                    start_date12 = date_count(start_date11, 0, 1, 'startdate');

                    end_date11 = date_count(start_date12, -1, 0, '');
                    due_date12 = date_count(due_date11, 0, 0, 'duedate');

                    start_date13 = date_count(start_date12, 0, 1, 'startdate');

                    end_date12 = date_count(start_date13, -1, 0, '');

                // alert(convert(start_date1));   
                $("#start_date1").val(start_date1);
                $("#due_date1").val(due_date1);
                $("#end_date1").val(end_date1);

                $("#start_date2").val(start_date2);
                $("#due_date2").val(due_date2);
                $("#end_date2").val(end_date2);

                $("#start_date3").val(start_date3);
                $("#due_date3").val(due_date3);
                $("#end_date3").val(end_date3);

                $("#start_date4").val(start_date4);
                $("#due_date4").val(due_date4);
                $("#end_date4").val(end_date4);

                $("#start_date5").val(start_date5);
                $("#due_date5").val(due_date5);
                $("#end_date5").val(end_date5);

                $("#start_date6").val(start_date6);
                $("#due_date6").val(due_date6);
                $("#end_date6").val(end_date6);

                $("#start_date7").val(start_date7);
                $("#due_date7").val(due_date7);
                $("#end_date7").val(end_date7);

                $("#start_date8").val(start_date8);
                $("#due_date8").val(due_date8);
                $("#end_date8").val(end_date8);

                $("#start_date9").val(start_date9);
                $("#due_date9").val(due_date9);
                $("#end_date9").val(end_date9);

                $("#start_date10").val(start_date10);
                $("#due_date10").val(due_date10);
                $("#end_date10").val(end_date10);

                $("#start_date11").val(start_date11);
                $("#due_date11").val(due_date11);
                $("#end_date11").val(end_date11);

                $("#start_date12").val(start_date12);
                $("#due_date12").val(due_date12);
                $("#end_date12").val(end_date12);
            }
        });

        function date_count(date, day_count, month_count, is_startdate)
        {

            var newdate = new Date(date);

            var mm1 = newdate.getMonth() + 1;
            var dd2 = newdate.getDate();

            newdate.setDate(newdate.getDate() + day_count);

            var mm = newdate.getMonth() + 1;
            var dd = newdate.getDate();

            if(is_startdate == 'startdate')
            {
                var dd = dd1;
                if(mm == mm1)
                {
                    newdate.setMonth(newdate.getMonth() + 1);
                }
            }
            else if(is_startdate == 'duedate')
            {
                if(mm == mm1)
                {
                    if(dd2 < dd){}
                    else
                    {
                        newdate.setMonth(newdate.getMonth() + 1);
                    }
                }
                else{}
            }
            var mm2 = newdate.getMonth() + 1;
            var y = newdate.getFullYear();
            var someFormattedDate = y + '-' + mm2 + '-' + dd;
            // var someFormattedDate = mm2 + '/' + dd + '/' + y;
            return someFormattedDate;
        }

        function convert(date)
        {
            var datearray = date.split("-");
            var newdate = datearray[1] + '/' + datearray[2] + '/' + datearray[0];
            return newdate;
        }

        function date_count1(date, day_count, month_count, is_startdate) 
        {
            var newdate = new Date(date);
            var newdate_old = new Date(date);
            var mm_old = newdate_old.getMonth() + 1;

            newdate.setDate(newdate.getDate() + day_count);
            // newdate.setMonth(newdate.getMonth() + month_count);

            var dd = newdate.getDate();
                mm = newdate.getMonth() + 1;
                y = newdate.getFullYear();
                // someFormattedDate = y + '-' + mm + '-' + dd;

            if (is_startdate == 'startdate') 
            {
                if (mm == mm_old)
                {
                    // alert('mm: '+mm+'  mm_old: '+mm_old+'  dd: '+dd);
                    newdate.setMonth(newdate.getMonth() + month_count);
                }

                var dd = newdate.getDate();
                    mm = newdate.getMonth() + 1;
                    y = newdate.getFullYear();
                var someFormattedDate = y + '-' + mm + '-' + dd1;
            }
            else
            {
                var someFormattedDate = y + '-' + mm + '-' + dd;
            }
            return someFormattedDate;
        }

        var start_term = '<?php echo date('Y-m-d'); ?>';

        var droplist = $('#fee_type');

        droplist.change(function () 
        {
            $('#starting_date').val('');

            $("#start_date1").val('');
            $("#due_date1").val('');
            $("#end_date1").val('');

            $("#start_date2").val('');
            $("#due_date2").val('');
            $("#end_date2").val('');

            $("#start_date3").val('');
            $("#due_date3").val('');
            $("#end_date3").val('');

            $("#start_date4").val('');
            $("#due_date4").val('');
            $("#end_date4").val('');

            $("#start_date5").val('');
            $("#due_date5").val('');
            $("#end_date5").val('');

            $("#start_date6").val('');
            $("#due_date6").val('');
            $("#end_date6").val('');

            $("#start_date7").val('');
            $("#due_date7").val('');
            $("#end_date7").val('');

            $("#start_date8").val('');
            $("#due_date8").val('');
            $("#end_date8").val('');

            $("#start_date9").val('');
            $("#due_date9").val('');
            $("#end_date9").val('');

            $("#start_date10").val('');
            $("#due_date10").val('');
            $("#end_date10").val('');

            $("#start_date11").val('');
            $("#due_date11").val('');
            $("#end_date11").val('');

            $("#start_date12").val('');
            $("#due_date12").val('');
            $("#end_date12").val('');
  
            if (droplist.val() === '1') { //annual

                // alert("11111111111111111");
                $("#Monthly").hide();
                $("#Quarterly").hide();
                $("#Bi-Annual").hide();
                $("#Annual").show();
                 $("#datelist").show();
            }
            if (droplist.val() === '2') {   //bi-annual

                // alert("222222222222222222");
                $("#Monthly").hide();
                $("#Quarterly").hide();
                $("#Annual").show();
                $("#Bi-Annual").show();
                 $("#datelist").show();
            }
            if (droplist.val() === '3') {  //tri annual

                // alert("33333333333333333333");
                $("#Monthly").hide();
                $("#Annual").show();
                $("#Quarterly").show();
                $("#Bi-Annual").hide();
                 $("#datelist").show();
            }
            if (droplist.val() === '4') {  //quarterly

                // alert("44444444444444444444");
                $("#Monthly").hide();
                $("#Quarterly").show();
                $("#Annual").show();
                $("#Bi-Annual").show();
                 $("#datelist").show();
            }
            if (droplist.val() === '12') {  //monthly

                // alert("555555555555555555555");
                $("#Monthly").show();
                $("#Quarterly").show();
                $("#Annual").show();
                $("#Bi-Annual").show();
                 $("#datelist").show();
            }
        });

        window.onload = function() 
        {
            // var start_term = '2018-05-1';
            // var now = new Date(start_term);
            // var month = now.getMonth()+1+2;  
            // var day = now.getDate();  
            // var year = now.getFullYear();  
            // $("#f_name").val(year + '-' + month + '-' + day);
        }

    </script>
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
                addSubCategory();
            }
        });
        function addSubCategory()
        {
            var fee_category_id = $('#fee_category_id').val();
                fee_subcategory_name = $('#fee_subcategory_name').val();
                amount = $('#amount').val();
                fee_type = $('#fee_type').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';

            var start_date1 = $("#start_date1").val();
            var due_date1 = $("#due_date1").val();
            var end_date1 = $("#end_date1").val();

            if(fee_type==2 || fee_type==4)//2&4
            {
                var start_date2 = $("#start_date2").val();
                var due_date2 = $("#due_date2").val();
                var end_date2 = $("#end_date2").val();
            }

            if(fee_type==3 || fee_type==4 || fee_type==12)//3&4
            {
                var start_date3 = $("#start_date3").val();
                var due_date3 = $("#due_date3").val();
                var end_date3 = $("#end_date3").val();

                var start_date4 = $("#start_date4").val();
                var due_date4 = $("#due_date4").val();
                var end_date4 = $("#end_date4").val();

                var start_date5 = $("#start_date5").val();
                var due_date5 = $("#due_date5").val();
                var end_date5 = $("#end_date5").val();
            }

            if(fee_type==12)//5
            {
                var start_date5 = $("#start_date5").val();
                var due_date5 = $("#due_date5").val();
                var end_date5 = $("#end_date5").val();

                var start_date6 = $("#start_date6").val();
                var due_date6 = $("#due_date6").val();
                var end_date6 = $("#end_date6").val();

                var start_date7 = $("#start_date7").val();
                var due_date7 = $("#due_date7").val();
                var end_date7 = $("#end_date7").val();

                var start_date8 = $("#start_date8").val();
                var due_date8 = $("#due_date8").val();
                var end_date8 = $("#end_date8").val();

                var start_date9 = $("#start_date9").val();
                var due_date9 = $("#due_date9").val();
                var end_date9 = $("#end_date9").val();

                var start_date10 = $("#start_date10").val();
                var due_date10 = $("#due_date10").val();
                var end_date10 = $("#end_date10").val();

                var start_date11 = $("#start_date11").val();
                var due_date11 = $("#due_date11").val();
                var end_date11 = $("#end_date11").val();

                var start_date12 = $("#start_date12").val();
                var due_date12 = $("#due_date12").val();
                var end_date12 = $("#end_date12").val();
            }

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("fee_category_id", fee_category_id);
                formData.append("fee_subcategory_name", fee_subcategory_name);
                formData.append("amount", amount);
                formData.append("fee_type", fee_type);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);

                formData.append("start_date1", start_date1);         
                formData.append("due_date1", due_date1);         
                formData.append("end_date1", end_date1);

                formData.append("start_date2", start_date2);         
                formData.append("due_date2", due_date2);         
                formData.append("end_date2", end_date2);

                formData.append("start_date3", start_date3);         
                formData.append("due_date3", due_date3);         
                formData.append("end_date3", end_date3);

                formData.append("start_date4", start_date4);         
                formData.append("due_date4", due_date4);         
                formData.append("end_date4", end_date4);

                formData.append("start_date5", start_date5);         
                formData.append("due_date5", due_date5);         
                formData.append("end_date5", end_date5);

                formData.append("start_date6", start_date6);         
                formData.append("due_date6", due_date6);         
                formData.append("end_date6", end_date6);

                formData.append("start_date7", start_date7);         
                formData.append("due_date7", due_date7);         
                formData.append("end_date7", end_date7);

                formData.append("start_date8", start_date8);         
                formData.append("due_date8", due_date8);         
                formData.append("end_date8", end_date8);

                formData.append("start_date9", start_date9);         
                formData.append("due_date9", due_date9);         
                formData.append("end_date9", end_date9);

                formData.append("start_date10", start_date10);         
                formData.append("due_date10", due_date10);         
                formData.append("end_date10", end_date10);

                formData.append("start_date11", start_date11);         
                formData.append("due_date11", due_date11);         
                formData.append("end_date11", end_date11);

                formData.append("start_date12", start_date12);         
                formData.append("due_date12", due_date12);         
                formData.append("end_date12", end_date12);

            $.ajax({
                url: "{{ url('subcategory/addSubCategory') }}",
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