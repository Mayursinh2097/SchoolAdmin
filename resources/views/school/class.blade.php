@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">View Class</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Add Class</strong> </h3>
                            <ul class="panel-controls">
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Class Type</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <!-- <input type="text" class="form-control" id="class_type" name="class_type" maxlength="2"> -->
                                        <input type="text" class="form-control" id="class_type" name="class_type">
                                    </div>                                            
                                    <span class="help-block">Fill up the text field</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Class Name</label>
                                <div class="col-md-6 col-xs-12">                                            
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                        <!-- <input type="text" class="form-control" id="ClassName" name="ClassName" maxlength="2"> -->
                                        <input type="text" class="form-control" id="ClassName" name="ClassName">
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
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title"><strong>View Class</strong> </h3>
                        <ul class="panel-controls"></ul>                                
                    </div>
                    <div class="panel-body">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Class Name</th>      
                                    <th>Action</th>      
                                </tr>
                            </thead>  
                            <tbody>
                            <?php 
                                $i = 1;
                                foreach ($classes as $key => $cl)
                                {
                                    if ($cl->ClassName == '11' || $cl->ClassName == '12') {
                                        $class_name = $cl->ClassName." (".$cl->stream.")";
                                    }
                                    else
                                    {
                                        $class_name = $cl->ClassName;
                                    }
                                ?>
                                <tr class="odd gradeX" >
                                    <td class="center"> <?php echo $i;?></td>
                                    <td class="center"> <?php echo $class_name;?></td>
                                    <td class="center">
                                        <a href="{{url('class/'.$cl->ClassId.'/edit')}}" class="btn btn-primary btn-rounded" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;

                                        <a  onclick="deleteClass('{{$cl->ClassId}}');" class="btn btn-danger btn-rounded" name="delete" id="delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                    </td>
                                </tr> 
                            <?php $i++; } ?> 
                        </tbody>  
                    </table>
                    </div>
                </div>
            </div>
        </div>                    
    </div>
    <div class="message-box message-box-success animated fadeIn" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Class added successfully.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger1">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Error to add class.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger2">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Class is already exist.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger3">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">This class is not alloweded in school.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Deleted</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Class deleted successfully.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger4">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;"> Error to delete.</p>
                </div>
                <div class="mb-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- PAGE CONTENT WRAPPER -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>  
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
                addClass();
            }
        });
        function addClass()
        {
            var class_type = $('#class_type').val();
                ClassName = $('#ClassName').val();
                stream = $('#stream').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                // alert(school_id);

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("class_type", class_type);
                formData.append("ClassName", ClassName);
                formData.append("stream", stream);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('class/addClass') }}",
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
                            location.reload();
                        }, 1500);
                    }
                    else if(response.success==2)
                    {
                        $("#message-box-danger2").modal('show');
                        setTimeout(function(){ 
                            $("#message-box-danger2").modal('hide');
                            location.reload();
                        }, 1500);
                    }
                    else if(response.success==3)
                    {
                        $("#message-box-danger3").modal('show');
                        setTimeout(function(){ 
                            $("#message-box-danger3").modal('hide');
                            location.reload();
                        }, 1500);   
                    }
                    else
                    {
                        $("#message-box-danger1").modal('show');
                        setTimeout(function(){ 
                            $("#message-box-danger1").modal('hide');
                            location.reload();
                        }, 1500);
                    }

                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }

        function deleteClass(id)
        {
            var checkstr =  confirm('Are you sure you want to delete Class ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/deleteclass') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {'id':id},
                    success: function(data) {
                        // location.reload();
                        var response = JSON.parse(data);
                        // console.log("res==>"+response.success);

                        if(response.success == 1){
                            // alert(data.msg);
                            $("#message-box-danger").modal('show');
                            setTimeout(function(){ $("#message-box-danger").modal('hide'); }, 1500);
                            location.href="{{ url('/class') }}";
                        }else{
                            // alert(data.msg);
                            $("#message-box-danger4").modal('show');
                            setTimeout(function(){ $("#message-box-danger4").modal('hide'); }, 1500);
                            return false;
                        }

                    },error: function(xhr, status, error) {
                       
                    }
                });
            }
            return false;
        }

        

    </script>
@endsection