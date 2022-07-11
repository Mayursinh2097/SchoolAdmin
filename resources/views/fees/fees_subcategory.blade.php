@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Fees</li>
        <li class="active">View SubCategory</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title"><strong>View Fees SubCategory</strong> </h3>
                        <ul class="panel-controls">
                            <a href="{{url('/subcategory/create')}}" title="ADD"><button class="btn btn-primary" name="save" id="save" style="margin-left:10px; ">Add SubCategory</button></a>
                        </ul>                                
                    </div>
                    <div class="panel-body">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Fee Category</th>      
                                    <th>Fee SubCategory</th>      
                                    <th>Amount</th>      
                                    <th>Action</th>      
                                </tr>
                            </thead>  
                            <tbody>
                            <?php 
                                $i = 1;
                                foreach ($subcategorys as $key => $cg){ ?>
                                <tr class="odd gradeX" >
                                    <td class="center"> {{ $i }}</td>
                                    <td class="center"> {{ $cg->fee_category_name }}</td>
                                    <td class="center"> {{ $cg->fee_subcategory_name }}</td>
                                    <td class="center"> {{ $cg->amount }}</td>
                                    <td class="center">
                                        <a href="{{url('subcategory/'.$cg->fee_subcategory_id.'/edit')}}" class="btn btn-primary btn-rounded" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;

                                        <a  onclick="deleteSubCategory('{{$cg->fee_subcategory_id}}');" class="btn btn-danger btn-rounded" name="delete" id="delete" title="Delete"><i class="fa fa-trash-o"></i></a>
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
    <!-- PAGE CONTENT WRAPPER -->

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Deleted</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">SubCategory deleted successfully.</p>
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

    @section('scripts')
    
    @endsection
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>  
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
                addSubCategory();
            }
        });
        function addSubCategory()
        {
            var fee_category = $('#fee_category').val();
                receipt_no = $('#receipt_no').val();
                description = $('#description').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("fee_category", fee_category);
                formData.append("receipt_no", receipt_no);
                formData.append("description", description);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);

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

        function deleteSubCategory(id)
        {
            var checkstr =  confirm('Are you sure you want to delete SubCategory ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/deleteSubCategory') }}",
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
                            location.href="{{ url('/subcategory') }}";
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