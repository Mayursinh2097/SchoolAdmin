@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Fees</li>
        <li class="active">Fees Allocation</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Fees Allocation</strong> </h3>
                            <ul class="panel-controls">
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Fee Category</label>
                                        <div class="col-md-9 col-xs-12">
                                            <select class="form-control"  id="fee_category_id" name="fee_category_id" onchange="get_subcat(this.value)" required>
                                                <option value="">Select</option>
                                                <?php   
                                                    foreach($categorys as $key => $cg){
                                                ?> 
                                                    <option value="<?php echo $cg->fee_category_id; ?>"><?php echo $cg->fee_category_name; ?></option>
                                                <?php   }   ?> 
                                            </select>
                                            <span class="help-block">Select Category </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Fee SubCategory</label>
                                        <div class="col-md-9 col-xs-12">
                                            <select class="form-control"  id="fee_subcategory_id" name="fee_subcategory_id" required>
                                                <option value="">Select SubCategory</option>
                                            </select>                                          
                                            <span class="help-block">Select SubCategory</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Class</label>
                                        <div class="col-md-9 col-xs-12">
                                            <select class="form-control"  id="class_id" name="class_id" onchange="get_div(this.value)" required>
                                                <option value="">Select</option>
                                                <?php   
                                                    foreach($classes as $key => $cl){
                                                ?> 
                                                    <option value="<?php echo $cl->ClassId; ?>"><?php echo $cl->ClassName; ?></option>
                                                <?php   }   ?> 
                                            </select>
                                            <span class="help-block">Select Class </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Division</label>
                                         <div class="col-md-9 col-xs-12">
                                            <select class="form-control" id="div_id" onchange="get_student()" name="div_id" required>
                                                <option value="">Select Division</option>
                                            </select>
                                            <span class="help-block">Select Division</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Student</label>
                                         <div class="col-md-9 col-xs-12">
                                            <select class="form-control" id="student_id" name="student_id" required>
                                                <option value="">Select Student</option>
                                            </select>
                                            <span class="help-block">Select Student</span>
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
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title"><strong>View Fees Allocation</strong> </h3>
                        <ul class="panel-controls"></ul>                                
                    </div>
                    <div class="panel-body">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Fees Category</th>      
                                    <th>Fees SubCategory</th>      
                                    <th>Class - Div</th>      
                                    <th>Student Name</th>      
                                    <th>Action</th>      
                                </tr>
                            </thead>  
                            <tbody>
                            <?php 
                                $i = 1;
                            foreach ($feeallocations as $key => $fa){ ?>
                                <tr class="odd gradeX" >
                                    <td class="center"> {{ $i }}</td>
                                    <td class="center"> {{ $fa->fee_category_name }}</td>
                                    <td class="center"> {{ $fa->fee_subcategory_name }}</td>
                                    <td class="center"> {{ $fa->ClassName }} - {{ $fa->DivisionName }}</td>
                                    <td class="center"> {{ $fa->StudentName }}</td>
                                    <td class="center">
                                        <a href="{{url('feeAllocation/'.$fa->fee_allocation_id.'/edit')}}" class="btn btn-primary btn-rounded" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;

                                        <a  onclick="deletefeeAllocation('{{$fa->fee_allocation_id}}', '{{$fa->StudentId}}', '{{$fa->ClassId}}', '{{$fa->fee_subcategory_id}}');" class="btn btn-danger btn-rounded" name="delete" id="delete" title="Delete"><i class="fa fa-trash-o"></i></a>
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
                    <p style="font-size: 15px;">Fees Allocation added successfully.</p>
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
                    <p style="font-size: 15px;">Error to add.</p>
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
                    <p style="font-size: 15px;">already exist.</p>
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
                    <p style="font-size: 15px;">Allocation deleted successfully.</p>
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

        function get_subcat(fee_category_id)
        {
            var fee_category_id = fee_category_id;
                // school_id = '<?php echo $school_id; ?>';
                // year_id = '<?php echo $year_id; ?>';
            $.ajax({
                url: "{{ url('feeAllocation/selectSubCat') }}",
                type: 'get',
                dataType: 'json',
                // data: {'fee_category_id':fee_category_id, 'school_id': school_id, 'year_id': year_id},
                data: {'fee_category_id':fee_category_id},
                success: function(response){
                    
                    var html_data = '';
                    var len = 0;
                    $("#fee_subcategory_id").empty();
                      
                    if(response.data != null){
                        len = response.data.length;
                    }
                    if(len > 0)
                    {
                        html_data += '<option value="">Select</option>';
                        // $("#fee_subcategory_id").append(html_data);
                        for(var i=0; i<len; i++)
                        {
                            /*var id = response.data[i].DivisionId;
                            var name = response.data[i].DivisionName;*/
                            html_data += "<option value='"+response.data[i].fee_subcategory_id+"'>"+response.data[i].fee_subcategory_name+"</option>"; 
                            $("#fee_subcategory_id").html(html_data); 
                        } 
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }

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
                    $("#div_id").empty();
                      
                    if(response.data != null){
                        len = response.data.length;
                    }
                    if(len > 0)
                    {
                        html_data += '<option value="">Select Division</option>';
                        // $("#div_id").append(html_data);
                        for(var i=0; i<len; i++)
                        {
                            /*var id = response.data[i].DivisionId;
                            var name = response.data[i].DivisionName;*/
                            html_data += "<option value='"+response.data[i].DivisionId+"'>"+response.data[i].DivisionName+"</option>"; 
                            $("#div_id").html(html_data); 
                        } 
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }

        function get_student()
        {
            var class_id = $('#class_id').val();
                div_id = $('#div_id').val();
                year_id = '<?php echo $year_id; ?>';
            $.ajax({
                url: "{{ url('selectStudent') }}",
                type: 'get',
                dataType: 'json',
                data: {'class_id':class_id, 'div_id': div_id, 'year_id': year_id},
                success: function(response){
                    
                    var html_data = '';
                    var len = 0;
                    $("#student_id").empty();
                      
                    if(response.data != null){
                        len = response.data.length;
                    }
                    if(len > 0)
                    {
                        html_data += '<option value="">Select Student</option>';
                        html_data += '<option value="">All</option>';
                        for(var i=0; i<len; i++)
                        {
                            html_data += "<option value='"+response.data[i].StudentId+"'>"+response.data[i].StudentName+"</option>"; 
                            $("#student_id").html(html_data); 
                        } 
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }
    </script>
    <script type="text/javascript">

        var validator = $("#add_role_form").validate({
            rules: {
                fee_category_id: { required: true },
                fee_subcategory_id: { required: true },
                class_id: { required: true },
                div_id: { required: true },
                student_id: { required: true },
            },
            submitHandler: function(form) 
            { 
                addFeeAllocation();
            }
        });

        function addFeeAllocation()
        {
            var fee_category_id = $('#fee_category_id').val();
                fee_subcategory_id = $('#fee_subcategory_id').val();
                class_id = $('#class_id').val();
                div_id = $('#div_id').val();
                student_id = $('#student_id').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("fee_category_id", fee_category_id);
                formData.append("fee_subcategory_id", fee_subcategory_id);
                formData.append("class_id", class_id);
                formData.append("div_id", div_id);
                formData.append("student_id", student_id);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('feeAllocation/addFeeAllocation') }}",
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

        function deletefeeAllocation(id, StudentId, ClassId, fee_subcategory_id)
        {
            var id = id;
                StudentId = StudentId;
                ClassId = ClassId;
                fee_subcategory_id = fee_subcategory_id;
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
            var checkstr =  confirm('Are you sure you want to delete Fee Allocation ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/deletefeeAllocation') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {'id':id, 'StudentId':StudentId, 'ClassId':ClassId, 'fee_subcategory_id':fee_subcategory_id, 'school_id':school_id, 'year_id':year_id},
                    success: function(data) {
                        // location.reload();
                        var response = JSON.parse(data);
                        // console.log("res==>"+response.success);

                        if(response.success == 1){
                            $("#message-box-danger").modal('show');
                            setTimeout(function(){ $("#message-box-danger").modal('hide'); }, 1500);
                            location.href="{{ url('/feeAllocation') }}";
                        }else{
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