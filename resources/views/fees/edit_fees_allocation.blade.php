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
        <li class="active">Edit Fee Allocation</li>
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
                            <h3 class="panel-title"><strong>Edit Fees Allocation</strong> </h3>
                            <ul class="panel-controls">
                                <li><a href="{{url('feeAllocation')}}" title="Cancel"><span class="fa fa-times"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Fee Category</label>
                                        <div class="col-md-9 col-xs-12">
                                            <select class="form-control" id="fee_category_id" name="fee_category_id" onchange="get_subcat(this.value)" required>
                                                <option value="">Select</option>
                                                <?php   
                                                    foreach($categorys as $key => $cg){
                                                ?>
                                                    <option value="<?php echo $cg->fee_category_id; ?>"<?php if($feeallocation->fee_category_id==$cg->fee_category_id){ echo "selected"; } ?>> <?php echo $cg->fee_category_name; ?></option>
                                                <?php   }   ?>
                                            </select>
                                            <span class="help-block">Select Category </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Fee SubCategory</label>
                                        <div class="col-md-9 col-xs-12">
                                            <select class="form-control"  id="fee_subcategory_id" name="fee_subcategory_id" required>
                                                <option value="">Select SubCategory</option>
                                            </select>

                                            <input type="hidden" class="form-control" id="fee_allocation_id" name="fee_allocation_id" value="{{ $feeallocation->fee_allocation_id }}" />
                                            <span class="help-block">Select SubCategory</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Class</label>
                                        <div class="col-md-9 col-xs-12">
                                            <select class="form-control cl"  id="class_id" name="class_id" disabled>
                                                <option value="{{ $feeallocation->ClassId }}">{{ $feeallocation->ClassName}}</option>
                                            </select>
                                        <span class="help-block">Class </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Division</label>
                                         <div class="col-md-9 col-xs-12">
                                            <select class="form-control cl" id="div_id" name="div_id" disabled>
                                                <option value="{{ $feeallocation->DivisionId }}">{{ $feeallocation->DivisionName}}</option>
                                            </select>
                                            <span class="help-block">Division</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Student</label>
                                         <div class="col-md-9 col-xs-12">
                                            <select class="form-control cl" id="student_id" name="student_id" disabled>
                                                <option value="{{ $feeallocation->StudentId }}">{{ $feeallocation->StudentName}}</option>
                                            </select>
                                            <span class="help-block">Student</span>
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
                    <p style="font-size: 15px;">Fees Allocation edited successfully.</p>
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
                    <p> Fees Allocation already exist.</p>
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

@section('scripts')

@endsection

    <!-- PAGE CONTENT WRAPPER -->
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script type="text/javascript">
        

        $( document ).ready(function() {
            get_subcat('<?php echo $feeallocation->fee_category_id; ?>');
            // document.getElementById('fee_subcategory_id').value='<?php echo $feeallocation->fee_subcategory_id; ?>';
            // $('#fee_subcategory_id').val('1');
            setTimeout(function(){ 
                $('#fee_subcategory_id').val('<?php echo $feeallocation->fee_subcategory_id; ?>');
                // alert("Hello");
            }, 1000);
        });

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

        var validator = $("#add_role_form").validate({
            rules: {
                fee_category_id: { required: true },
                fee_subcategory_id: { required: true },
            },
            submitHandler: function(form) 
            { 
                editFeeAllocation();
            }
        });
        function editFeeAllocation()
        {
            var fee_category_id = $('#fee_category_id').val();
                fee_subcategory_id = $('#fee_subcategory_id').val();
                fee_allocation_id = $('#fee_allocation_id').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                class_id = $('#class_id').val();
                student_id = $('#student_id').val();

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("fee_category_id", fee_category_id);
                formData.append("fee_subcategory_id", fee_subcategory_id);
                formData.append("fee_allocation_id", fee_allocation_id);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);
                formData.append("class_id", class_id);
                formData.append("student_id", student_id);

            $.ajax({
                url: "{{ url('feeAllocation/updateFeeAllocation') }}",
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
                        location.href="{{ url('/feeAllocation') }}";
                    }
                    else if(response.success == 2)
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