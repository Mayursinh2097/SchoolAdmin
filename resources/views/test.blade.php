@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li><a href="{{url('packnew')}}">Pack</a></li>
    <li class="active">Edit</li>
@endsection

@section('maincontent')
@php
    $user_priv = array();
    if (session()->has('user_priv')) {
        $user_priv = session()->get('user_priv');
    }
    $name = $pack->name;
   
    if($name == ''){
        $name = 1;
    }
@endphp

<style>
    .form-group{
        margin:10px; 
    }
    #loader {
        display: none;
        position: fixed;
        top: 0;      
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0,0,0,0.25) url("{{asset('img/loaders/default.gif')}}") no-repeat center center;
        z-index: 10000;
    }
</style>

<div class="row">
    <div class="col-md-12">
        @include('common/flash_message')
            <form class="form-horizontal" id="add_form" method="post"  action="/packnew/{{$pack->id}}">
                {{csrf_field()}}
                @method('PUT')
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Pack</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('packnew')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    
                    <div class="panel-body">
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Name</label>
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="name" id="name" value="{{$name}}">
                                        <input type="text" class="form-control nospecialcharater" name="name1" id="name1" value="{{$packconfig->name_prefix.sprintf('%04d', $name)}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Description <span class="mandatory">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="description" id="description" value="{{$pack->description}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Config Type <span class="mandatory">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control select" name="config_type" id="config_type" onchange="getKey(this.value);" readonly>
                                            <!--<option value="">Select</option>-->
                                            @foreach($packconfigs as $value)
                                            <option value="{{$value->id}}" @if($pack->pack_config_id == $value->id) selected @else disabled @endif >{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">CommunityGrp <span class="mandatory">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control select" name="community_group" id="community_group">
                                            <option value="">Select</option>
                                            @foreach($communitygrp as $community)
                                            <option value="{{$community->id}}" @if($pack->com_group == $community->id) selected @endif >{{$community->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                             
                        </div>
                        <div class="row col-md-12" id="dashboard_row"></div>
                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Collect Activity <span class="mandatory">*</span></label>
                                    <div class="col-md-12">
                                        <select multiple class="form-control select" name="collectactivityid" id="collectactivityid" >
                                            @foreach($collectactivitys as $value)
                                                <option value="{{$value->id}}" @if(in_array($value->id, explode(',', $packconfig->collect_activity_id))) selected @endif disabled>{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="collectactivityid_all" id="collectactivityid_all" value="{{$packconfig->collect_activity_id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="field_array" id="field_array" value="">
                        <input type="hidden" name="privilege_count" id="privilege_count" value="0">
                        <button1 class="btn btn-info" onClick="window.location.href='{{url('packnew')}}'">Back</button1>
                        <button1 class="btn btn-default" onClick="$('#add_form')[0].reset();">Clear Form</button1>
                
                        <button id="editTask" class="btn btn-primary pull-right">Submit</button>
                        <button  type="button" class="btn btn-second pull-right" data-toggle="modal" data-target="#graphModal">View Graph</button>
                        
                    </div>
                </div>
                
                
            </form>
            <div id="graphModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" >
            
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">View Graph and Chart</h4>
                            </div>
                            <div class="modal-body" style="max-height:500px; overflow-y:auto;">
                                <div class="row" >
                                    <div class="alert" id="alert_div" role="alert">
                                        <span id="alert_text"></span>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">Graph and Chart</label>
                                            <div class="col-md-12">
                                                <select class="form-control" name="graph_id" id="graph_id" onchange="viewGraph(this.value);">
                                                    <option value="">Select</option>
                                                    @foreach($graphcharts as $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="viewGraph">
                                        
                                    </div>
                                        
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>   
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Collect Data</strong></h3>
                    <ul class="panel-controls">
                        <li><a href="{{url('packnew')}}"><span class="fa fa-times"></span></a></li>
                    </ul>
                </div>
                    
                <div class="panel-body">
                    <ul class="nav nav-tabs" style="margin-top:0px;">
                        <li class="active"><a data-toggle="tab" href="#home">Pack Collect Data</a></li>
                        <li ><a data-toggle="tab" href="#menu1">Collect New Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade   in active">
                            <div class="col-md-12 table-responsive" id="collect_data_table" >
                                <table class="table datatable table-hover table-resplonsiv">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Value</th>
                                            <th>Value Units</th>
                                            <th>Collect Activity</th>
                                            <th>Result Name</th>
                                            <th>Sensors</th>
                                            <th>User Collecting</th>
                                            <th>Date Time Collected</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($collectDatas as $collectData)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <!--<td>{{$collectData->pack_id.'_'.$collectData->species.'_'.$collectData->creation_date}}</td>-->
                                            <td>{{$collectData->new_value}}</td>
                                            <td>{{$collectData->unit_name}}</td>
                                            <td>{{$collectData->collect_activity_name}}</td>
                                            <td>{{$collectData->result_name}}</td>
                                            <td>{{$collectData->sensor_name}}</td>
                                            <td>{{$collectData->user_name}}</td>
                                            <td>{{$collectData->collect_datetime}}</td>
                                            <td>{{$collectData->duration}}</td>
                                            <td>
                                                @if(in_array("EditCollectData", array_column(json_decode($user_priv, true), 'privilege')))
                                                <a href="{{route('collectdata.edit',$collectData->id)}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                                                @endif
                                                @if(in_array("DeleteCollectData", array_column(json_decode($user_priv, true), 'privilege')))
                                                 <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="ConfirmDelete({{$collectData->id}})"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
                                                @endif
                                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade" id="collect_data_new">
                            <form class="form-horizontal" id="add_form1" method="post" action="{{route('storecollectdata')}}">
                                {{csrf_field()}}
                                <div class="panel panel-default">
                        
                                    <div class="panel-body">
                                        <div class="row" id="row_div">
                                            <input type="hidden" name="pack_id" id="pack_id" value="{{$pack->id}}" >
                                            
                                            <div class="col-md-12" id="result_div0">
                                                <div class="col-md-11">
                                                    <div class="form-group">
                                                        <div class="col-md-2">
                                                            <div class="input-group">
                                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Activity <span class="mandatory">*</span></button></span>
                                                                <select class="form-control select" name="result_collectactivityid0" id="result_collectactivityid0" onchange="getPackResult(this.value,0)">
                                                                    <option value="">Select</option>
                                                                    @foreach($collectactivitys as $value)
                                                                     @if(in_array($value->id, explode(',', $packconfig->collect_activity_id)))
                                                                        <option value="{{$value->id}}"   >{{$value->name}}</option>
                                                                    @endif 
                                                                    @endforeach
                                                                </select>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="input-group">
                                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Result <span class="mandatory">*</span></button></span>
                                                                <select class="form-control result_id select" name="result_id0" id="result_id0" onchange="getvaluetype(0, this.value)">
                                                                    <option value="">select</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="input-group" id="input_group_value0">
                                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Value <span class="mandatory">*</span></button></span>
                                                                <input type="text" class="form-control" name="value0" id="value0" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="input-group">
                                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Units <span class="mandatory">*</span></button></span>
                                                                <select class="form-control select" name="unit_id0" id="unit_id0">
                                                                    <option value="">select</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="input-group">
                                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Sensor <span class="mandatory">*</span></button></span>
                                                                <select class="form-control select" name="sensor_id0" id="sensor_id0">
                                                                    <option value="">select</option>
                                                                    @foreach($sensor as $key=>$value)
                                                                        <option value="{{$key}}">{{$value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="input-group" >
                                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Duration</button></span>
                                                                <input type="number" class="form-control" name="duration0" id="duration0" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <input type="hidden" name="new_value0" id="new_value0" value="">
                                                    <input type="hidden" value="1" id="deleted0" name="deleted0">
                                                    <button class="btn btn-default" type="button" onclick="add_row()" style="margin-top:9px;"><i class="fa fa-pencil"></i> Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        
                                        <input type="hidden" name="result_count" id="result_count" value="1">
                                        <button1 class="btn btn-default" onClick="$('#add_form1')[0].reset();">Clear Form</button1>
                                        <button class="btn btn-primary pull-right">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>
<div id="loader"></div>  
<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var spinner = $('#loader');
     
    $(function () {
        $('#alert_div').hide();
        $('#alertpack').hide();
        getKey({{$pack->pack_config_id}});
    
        $(".nospecialcharater").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z0-9]+$/;
     
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        });
    });
    
    $.validator.addMethod("checkUserName", 
        function(value, element) {
            var token = $('#_token').val();
            var result = false;
            $.ajax({
                type:"POST",
                async: false,
                url: '/checkunique', // script to validate in server side
                data: {'name': value, _token:token,'page':'packnew','id':{{$pack->id}}},
                success: function(data) {
                   result = (data == false) ? true : false;
                }
            });
            // return true if username is exist in database
            return result; 
        }, 
        "This name is already taken! Try another."
    );
    
    var jvalidate = $("#add_form").validate({
        ignore: ':not(select:hidden, input:visible, textarea:visible)',
        rules: {
            description: {
                required: true,
            },
            config_type: {
                required: true,
            },
            community_group: {
                required: true,
            },
        },
        errorPlacement: function (error, element) {
            if ($(element).is('select')) {
                element.next().after(error);
                element.next().removeClass('valid').addClass('error');
            } else {
                error.insertAfter(element);
            }
        }
    });
    
    $('body').on('change', '.select', function(){
        $(this).valid();
        $(this).selectpicker('refresh');
    });
    
    $("#editTask").click(function(){
       
        var ItemArray = [];
        $(".fieldArray").each(function() {
            ItemArray.push({
                f_id : $(this).parent().siblings('input').val(), 
                f_value : $(this).val()
            });
        });
        $("#field_array").val(JSON.stringify(ItemArray));
        
    });
    
    function getKey(id){
        var token = $('#_token').val();
            $.ajax({
                url: '/getpackconfig',
                data: {'id':id, _token:token,'pack_id':{{$pack->id}} },
                type: 'POST',
                async: "false",
                success: function(data) {
                    var response = JSON.parse(data);
                    console.log(response);
                    var htmlData = '';
                    $.each(response.fields, function(k, v) {
                        if(v.field_name != null){
                            var field_name = (v.field_name).replace(" ","_");
                            var field_type = v.field_type;
                            var field_value = '';
                                if(v.field_value != null){
                                   field_value = v.field_value; 
                                }
                                type = 'text';
                                
                            if(field_type == 'Date'){ type = 'date';}
                            else if(field_type == 'DateTime'){ type = 'datetime';}
                            else if(field_type == 'Numeric'){ type = 'number'; }
                            else if(field_type == 'List'){ type = 'list'; }
                            else if(field_type == 'Multilist'){ type = 'multilist'; }
                            else if(field_type == 'Table'){ type = 'table'; }
                            var readonly = ''; 
                            var disabled = ''; 
                            if(v.editable == 0){
                                readonly = 'readonly';
                                disabled = 'disabled';
                            }   
                            
                                
                            htmlData += '<div class="col-md-6"><div class="form-group">';
                            htmlData += '<label class="col-md-12">'+v.field_description+'</label><input type="hidden" name="f_id[]" value="'+v.field_id+'">';
                            htmlData += '<div class="col-md-12">';
                            
                            if(type == 'multilist' || type == 'list'  || type == 'table'){
                                if(type == 'multilist'){
                                     htmlData += '<select class="form-control select fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" '+readonly+' multiple><option value="">Select</option>';
                                     $.each(v.field_list, function(k1, v1) {
                                         
                                             
                                            var selected = '';
                                            var collectids = field_value.split(',');
                                            for(var i = 0; i < collectids.length; i++){
                                                if(collectids[i] == v1.id){
                                                    selected = 'selected';
                                                }
                                            }
                                        
                                            htmlData += '<option value="'+v1.id+'" '+disabled+' '+selected+'>'+v1.name+'</option>'; 
                                        
                                        
                                    });
                                }else{
                                   
                                   htmlData += '<select class="form-control select fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" '+readonly+'><option value="">Select</option>';  
                                   $.each(v.field_list, function(k1, v1) {
                                        if(v1.id == field_value){
                                            htmlData += '<option value="'+v1.id+'" '+disabled+' selected>'+v1.name+'</option>'; 
                                        }else{
                                            htmlData += '<option value="'+v1.id+'" '+disabled+'>'+v1.name+'</option>'; 
                                        }
                                        
                                    });
                                }
                                // htmlData += '<select class="form-control" name="f_name[]" id="'+field_name+'" '+readonly+'><option value="">Select</option>';
                                    
                                htmlData += '</select>';
                                
                            }
                        
                            else if(type == 'datetime' || type == 'DateTime' || type == 'date'){
                                
                                 htmlData += '<input type="datetime-local" class="form-control fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" value="'+field_value+'" '+readonly+'>';
                            }
                            else{
                                 htmlData += '<input type="'+type+'" class="form-control fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" value="'+field_value+'" '+readonly+'>';
                            }
                            // htmlData += '<input type="text" class="form-control" name="f_name[]" id="'+field_name+'" value="'+field_value+'" '+readonly+'>';
                            htmlData += '</div>';
                            htmlData += '</div></div>';
                        }
                        
                                
                                    
                                    
                                        
                                    
                                
                            
                        // // if(v.name == 'task_status'){
                            
                        //     var htmlData = ''; name = (v.name).toLowerCase(); type = 'text';
                            
                        //     if(v.field_type == 'Date'){ type = 'date';}
                        //     else if(v.field_type == 'Numeric'){ type = 'number'; }
                        //     else if(v.field_type == 'List'){ type = 'list'; }
                        //     else if(v.field_type == 'Multilist'){ type = 'multilist'; }
                            
                        //     if(type == 'multilist' || type == 'list'){
                        //         htmlData += '<select class="form-control" name="'+name+'" id="'+name+'"><option value="">Select</option>';
                        //             $.each(v.field_list, function(k1, v1) {
                        //                 htmlData += '<option value="'+v1.id+'">'+v1.name+'</option>'; 
                        //             });
                        //         htmlData += '</select>';
                        //     }else{
                        //       htmlData += '<input type="'+type+'" class="form-control"name="'+name+'" id="'+name+'">';
                        //     }
                        //     $('#'+name+'_div').html(htmlData);
                        // // }
                       
                        
                    });
                    $('#dashboard_row').html(htmlData);
                    $('.select').selectpicker();
            
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
        }
        
   //collect Data
    
    var count = 1;
    var html_data = '<option value="">select</option>';
    
     var jvalidate = $("#add_form1").validate({
        ignore: ':not(select:hidden, input:visible, textarea:visible)',
        rules: {
            result_id0: {
                required: true,
            },
            value0: {
                required: true,
            },
            unit_id0: {
                required: true,
            },
            unit_id0: {
                required: true,
            },
            sensor_id0: {
                required: true,
            },
            result_collectactivityid0: {
                required: true,
            },
            
        },
        errorPlacement: function (error, element) {
            if ($(element).is('select')) {
                element.next().after(error);
                element.next().removeClass('valid').addClass('error');
            } else {
                error.insertAfter(element);
            }
        },submitHandler: function(form) {
            var count = $('#result_count').val();
            
            var a = 0;
            for ( var i = 0;  i <= parseInt(count); i++ ) {
                
                var val = '';
                var input_type = $('#value'+a);
                if( input_type.is('input') ) {
                    val = input_type.val();
                }else{
                    val = input_type.find(':selected').text(); 
                }
                
               $('#new_value'+a).val(val);
               a++;
            }
 
            // do other things for a valid form
            form.submit();
        }
    });
     var collectactivityid_all = $("#collectactivityid_all").val();
    $(function() {
       
        // getPackResult(collectactivityid_all,0);
    });
    
    function add_row() {
        
        var html_data1 = '';
        html_data1 += '<div class="col-md-12" id="result_div'+count+'"><div class="col-md-11"><div class="form-group">';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Activity <span class="mandatory">*</span></button></span><select class="form-control select" name="result_collectactivityid'+count+'" id="result_collectactivityid'+count+'" onchange="getPackResult(this.value,'+count+')"><option value="">Select</option>@foreach($collectactivitys as $value)@if(in_array($value->id, explode(',', $packconfig->collect_activity_id)))<option value="{{$value->id}}">{{$value->name}}</option>@endif @endforeach</select></div></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Result <span class="mandatory">*</span></button></span><select class="form-control result_id select" name="result_id'+count+'" id="result_id'+count+'" onchange="getvaluetype('+count+', this.value)">'+html_data+'</select></div></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group" id="input_group_value'+count+'"><span class="input-group-btn"><button class="btn btn-default" type="button">Value <span class="mandatory">*</span></button></span><input type="text" class="form-control" name="value'+count+'" id="value'+count+'" value=""></div></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Units <span class="mandatory">*</span></button></span><select class="form-control select" name="unit_id'+count+'" id="unit_id'+count+'"><option value="">select</option>@foreach($unit as $key=>$value)<option value="{{$key}}">{{$value}}</option>@endforeach</select></div></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Sensor <span class="mandatory">*</span></button></span><select class="form-control select" name="sensor_id'+count+'" id="sensor_id'+count+'"><option value="">select</option>@foreach($sensor as $key=>$value)<option value="{{$key}}">{{$value}}</option>@endforeach</select></div></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Duration</button></span><input type="number" class="form-control" name="duration'+count+'" id="duration'+count+'" value=""></div></div>';
        
        html_data1 += '</div></div><div class="col-md-1"><input type="hidden" name="new_value'+count+'" id="new_value'+count+'" value=""><input type="hidden" value="0" id="deleted'+count+'" name="deleted'+count+'"><button class="btn btn-default" type="button" onclick="delete_row('+count+')" style="margin-top:9px;"><i class="fa fa-times"></i> Remove</button></div></div>';
        $('#row_div').append(html_data1);
        $('#result_count').val(count);
        $('.select').selectpicker('refresh');
        
        // getPackResult(collectactivityid_all,count);
        $('#add_form1').validate();
        $('#result_id'+count).rules('add',  { required: true });
        $('#value'+count).rules('add',  { required: true });
        $('#unit_id'+count).rules('add',  { required: true });
        $('#sensor_id'+count).rules('add',  { required: true });
        $('#result_collectactivityid'+count).rules('add',  { required: true });
        count++;
    }
    
    function delete_row(count) {
        $('#result_div'+count).hide();
        $('#deleted'+count).val(1);
    }
    
    function getPackResult(collect_activity,id){
        
        var token = $('#_token').val();
        $.ajax({
            url: '/getpacknewresult',
            data: {'collect_activity':collect_activity, _token:token},
            type: 'POST',
            async: "false",
            success: function(data) {
                console.log(data);
              
               
                var response = JSON.parse(data);
                var html_data = '<option value="">Select</option>';
                for(var i = 0; i < response.length; i++){
                    html_data += '<option value="'+response[i].id+'">'+response[i].result_name+'</option>';
                }
                $('#result_id'+id).html(html_data);
                // $('.result_id').html(html_data);
                $('.select').selectpicker('refresh');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('error : '+xhr.responseText);
                alert('something bad happened');
            }
        });
    }
    
    function getvaluetype(count, result_id){
        // alert(count);
        // alert(result_id);
        var token = $('#_token').val();
        $.ajax({
            url: '/getvaluetype',
            data: {result_id:result_id, _token:token},
            type: 'POST',
            async: "false",
            success: function(data) {
                console.log(data);
               
                $('#value'+count).val('');
                var datatype = data.value_datatype[0].type_id;
                var html_data = '<option value="">Select</option>';
                if(datatype == 'text'){
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control" name="value'+count+'" id="value'+count+'" value="">');
                }
                else if(datatype == 'numeric'){
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control number" name="value'+count+'" id="value'+count+'" value="">');
                    $('.number').bind('keypress',function(e){
                        return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
                    });
                }
                else if(datatype == 'date'){
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control datepicker" name="value'+count+'" id="value'+count+'" value="">');
                    if($(".datepicker").length > 0){
                        $(".datepicker").datepicker({format: 'yyyy-mm-dd'});
                    }
                }
                else if(datatype == 'list'){
                    
                    var html_data = '<option value="">select</option>';
                    if(data.list != null){
                        for(var i = 0; i < data.list.choices.length; i++){
                            html_data += '<option value="'+data.list.choices[i].id+'">'+data.list.choices[i].name+'</option>';
                        }  
                    }
                    
                    
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><select class="form-control select" name="value'+count+'" id="value'+count+'" value="">'+html_data+'</select>');
                    
                }
                else{
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control" name="value'+count+'" id="value'+count+'" value="">');
                    alert('no data type is selected for this result value');
                }
                html_data = '';
                for(var i=0; i<data.unit_list.length; i++)
                {
                    html_data+= '<option value="'+data.unit_list[i].id+'">'+data.unit_list[i].name+'</option>';
                }
                $('#unit_id'+count).html(html_data);
                $("#add_form1").valid();
                $('select').selectpicker('refresh');
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('error : '+xhr.responseText);
                alert('something bad happened');
            }
        });
    }
    
    
    
    function viewGraph(id){
        var token = $('#_token').val();
            pack_id = {{$pack->id}};
            
            if(id == ''){
                $('#viewGraph').html('');
                return false;
            }
        $.ajax({
            url: '/getgraphdetail',
                data: {'pack_id':pack_id,'graph_id':id, _token:token },
                type: 'POST',
                success: function(data) {
                    console.log(data);
                    var res = JSON.parse(data);
                    var htmlData = '';
                    if(res.charts.length > 0){
                        $.each(res.charts, function(k, v){
                            
                            var  point_count = false; 
                            $.each(v.lines, function(k2, v2) {
                                var points = v2.points;
                                if(points.length > 0){
                                    $.each(points, function(k3, v3) {
                                        //alert(v3);
                                    });
                                    point_count = true;
                                }                                
                            });
                            
                            if(point_count == true){
                                // htmlData += '<div class="col-md-12">';
                                    // htmlData += '<div class="panel panel-default" >';
                                        // htmlData += '<div class="panel-heading">'+v.graph_name+'</div>';
                                        // htmlData += '<div class="panel-body">';
                                                if(v.graph_type == 'Radar chart'){
                                                    htmlData += '<canvas id="line_'+pack_id+'"></canvas>';
                                                }else{
                                                    htmlData += '<div id="line_'+pack_id+'" style="height: 300px;"></div>';
                                                }
                                            // htmlData += '<div id="line_'+pack_id+'" style="height: 300px;"></div>';
                                            htmlData += '<div id="legend_'+pack_id+'" class="bars-legend"></div>';
                                        // htmlData += '</div>';
                                    // htmlData += '</div>';
                                // htmlData += '</div>';
                            }
                            $('#viewGraph').html(htmlData);
                        });
                        
                        $.each(res.charts, function(k, v){
                            var graph_ordinate_title = v.graph_ordinate_title;
                            var graph_abcissa_title = v.graph_abcissa_title;
                            var data_arr = [];
                                linename_arr = [];
                                ykeys_arr = [];
                                
                                 data_arr_radar = [];
                                    
                            var point_count = false;
                            var loop = 1;
                            var line_count = v.lines.length;
                            $.each(v.lines, function(k2, v2) {
                                
                                var line_name = 'line '+loop;
                                    ykeys_arr.push(line_name);
                                    linename_arr.push(v2.name+' ('+graph_ordinate_title +')');
                                
                                var points = v2.points;
                                    if(points.length > 0){
                                       
                                        $.each(points, function(k3, v3) {
                                            var j = 1;
                                            var obj = {};
                                            if(v3.duration != null){
                                                
                                               obj['y'] = (v3.duration).toString();
                                            
                                                $.each(v.lines, function(k2, v2) {
                                                    if(loop == j){
                                                        obj['line '+j] = v3.value;
                                                    }else{
                                                        obj['line '+j] = null;
                                                    }
                                                    j++;
                                                });
                                                
                                                data_arr.push(obj); 
                                            }
                                            data_arr_radar.push(v3.value);
                                            
                                        });
                                        point_count = true;
                                    }
                                    loop++;
                                });
                            console.log(data_arr);

                            var new_arr = [];
                            $.each(data_arr, function(k, v) {
                                var index_value = -1;
                                var found = new_arr.some((el) => {
                                    index_value = new_arr.indexOf(el);// -1
                                    return el.y === v.y;
                                });
                                
                                // console.log(found);
                                // console.log(index_value);
                                if(found == false){
                                    var obj = {};
                                    $.each(v, function(k1, v1) {
                                        obj[k1] = v1;
                                    });
                                    new_arr.push(obj);
                                }else{
                                    // console.log(new_arr[index_value]);
                                    if(index_value != -1){
                                        
                                    //   myArray[objIndex].name = "Laila"
                                        $.each(new_arr[index_value], function(k1, v1) {
                                            // console.log(k1 +':'+v1);
                                            if(v1 == null){
                                                // console.log(new_arr[index_value].k1); 
                                               new_arr[index_value][k1] = v[k1]; 
                                            }
                                            // obj[k1] = v1;
                                        });
                                    }
                                   
                                }
                                
                            });
                                                           
                            data_arr1 = new_arr.sort(function(a, b){
                                var a1= parseFloat(a.y), b1= parseFloat(b.y);
                                if(a1== b1) return 0;
                                return a1> b1? 1: -1;
                            });
                            console.log(new_arr);





                                if(point_count == true){
                        
                                    var config = {
                                            data: data_arr1,
                                            xkey: 'y',
                                            ykeys: ykeys_arr,
                                            labels: linename_arr,
                                            resize: false,
                                            parseTime: false,
                                            hoverCallback: function(index, options, content, row) {
                                                var data = options.data[index]; 
                                                var htmlData = '<div class="morris-hover-row-label">'+graph_abcissa_title+' : '+data.y+'</div>';
                                                
                                                $.each(options.ykeys, function(k, v) {
                                                    if(data[v] != null){
                                                         htmlData += '<div class="morris-hover-point">'+options.labels[k]+': '+data[v]+'</div>';
                                                    }
                                                });
                                                return htmlData;
                                            },
                                            
                                        };
                                    if(v.graph_type == 'Line chart'){
                                        config.element = 'line_'+pack_id;
                                        
                                        var browsersChart = Morris.Line(config);
                                        browsersChart.options.labels.forEach(function(label, i) {
                                            var legendItem = $('<span></span>').text( label).prepend('<br><span>&nbsp;</span>');
                                                legendItem.find('span')
                                                  .css('backgroundColor', browsersChart.options.lineColors[i])
                                                  .css('width', '10px')
                                                  .css('height', '10px')
                                                  .css('vertical-align', 'bottom')
                                                  .css('display', 'inline-block')
                                                  .css('margin', '3px');
                                            $('#legend_'+pack_id).append(legendItem);
                                        });
                                       
                                    }else if(v.graph_type == 'Bar chart'){
                                        config.element = 'line_'+pack_id;
                                        config.stacked = true;
                                       
                                        var browsersChart =  Morris.Bar(config);
                                        browsersChart.options.labels.forEach(function(label, i) {
                                            var legendItem = $('<span></span>').text( label).prepend('<br><span>&nbsp;</span>');
                                                legendItem.find('span')
                                                  .css('backgroundColor', browsersChart.options.barColors[i])
                                                  .css('width', '10px')
                                                  .css('height', '10px')
                                                  .css('vertical-align', 'bottom')
                                                  .css('display', 'inline-block')
                                                  .css('margin', '3px');
                                            $('#legend_'+pack_id).append(legendItem);
                                        });
                                        // Morris.Donut(config);
                                        
                                    }
                                else if(v.graph_type == 'Radar chart'){
                                        console.log("data_arr1:"+data_arr_radar);
                                        console.log("line_arr1:"+linename_arr);
                                        var ctx = document.getElementById('line_'+pack_id);


const data = {
  labels: linename_arr,
  datasets: [{
    label: 'Value',
    data: data_arr_radar,
    fill: true,
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgb(255, 99, 132)',
    pointBackgroundColor: 'rgb(255, 99, 132)',
    pointBorderColor: '#fff',
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderColor: 'rgb(255, 99, 132)'
  }]
};
const config = {
  type: 'radar',
  data: data,
  options: {
    elements: {
      line: {
        borderWidth: 3
      }
    }
  },
};
var myChart = new Chart(ctx, config);
                                    }
                                    
                                }    
                            
                            
                    
                            
                        });
                    }else{
                       htmlData = '';
                       $('#viewGraph').html(htmlData);
                    }
                    return false;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
    }
    
    $('#graphModal').on('hidden.bs.modal', function () {
        
      $('#viewGraph').html('');
      $('#graph_id').val('');
    })
    
    function ConfirmDelete(id){
            var token = $('#_token').val();
            var x = confirm("Are you sure you want to delete?");
            if (x){
                $.ajax({
                    url: '/collectdata/'+id,
                    data: {_method:'DELETE', _token:token },
                    type: 'POST',
                    success: function(data) {
                        var response = JSON.parse(data);
                        alert(response.message);
                        location.reload();
                    },
                    error: function() {
                        alert('something bad happened');
                    }
                });
            }
        }
        

 </script>
@endsection