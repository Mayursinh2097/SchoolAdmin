@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Student</li>
        <li class="active">View All Teachers</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Total Teacher's</strong>  {{$totalTeachers}} </h3>
                    </div>
                    <div class="panel-body">
                        <strong><p>Use search to find User. You can search by: Name. Or use the advanced Search.</p></strong>
                        <!-- <strong><p>Use search to find User. You can search by: Name, address, phone. Or use the advanced search.</p></strong> -->
                        <form class="form-horizontal" id="searchteacher1">
                            {{csrf_field()}}
                        </form>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="fa fa-search"></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Who are you looking for?" id="tname" name="tname" />
                                    <div class="input-group-btn"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="showteacher"></div>
        </div>                   
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-trash-o"></span> Deleted</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Teacher data is deleted.</p>
                </div>
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
    @section('scripts')
    
    @endsection
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

    <script type="text/javascript">

        window.onload = function() 
        {
            searchteacher();
        }

        $("#tname").keyup(function(){

            searchteacher();
        });

        function imgError(image,gender) 
        {
            image.onerror = "";
            if(gender == 1){
               image.src = "{{asset('file_upload')}}/boy.png";
            }else{
                image.src = "{{asset('file_upload')}}/girl.png";
            }
            return true;
        }

        function searchteacher()
        {
            var tname = $('#tname').val();
            var role = '<?php echo $RoleId; ?>';
            var sid = '<?php echo $sid; ?>';
            var school_id = '<?php echo $school_id; ?>';
            var year_id = '<?php echo $year_id; ?>';

            var formData = new FormData($('#searchteacher1')[0]);
                formData.append("tname", tname);
                formData.append("role", role);
                formData.append("school_id", school_id);
                formData.append("sid", sid);

            $.ajax({
                url: "{{ url('viewTeacher') }}",
                method: 'post',
                contentType: false,
                processData: false,
                async: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                data: formData,
                success: function (data1) {
                    
                    var response = data1;
                    if($.isEmptyObject(response.data)){
                        $("#showteacher").html('');
                        $("#showteacher").append('<div class="col-sm-12" >Data is Not Available..</div>');
                    }
                    else
                    {
                        $("#showteacher").html('');
                        var htmldata = '';
                        var total_teacher = response.length;
                        var fileUrl = "{{asset('file_upload')}}";

                          $.each(response.data, function(index, item) 
                          {
                            // alert(item.photo);
                     
                            if(item.photo == '0')
                            {
                                alert("empty");
                                if(item.Gender == '1')
                                {
                                    // alert("set boy photo");
                                    imghtml = '<img src="'+fileUrl+'/boy.png" onerror="imgError(this,'+item.Gender+');" alt="'+item.Name+'"/>';
                                }
                                else if(item.Gender == '2')
                                {
                                    // alert("set girl photo");
                                    imghtml = '<img src="'+fileUrl+'/girl.png" onerror="imgError(this,'+item.Gender+');" alt="'+item.Name+'"/>';
                                }
                                else
                                {
                                    // alert("set empty photo");
                                    imghtml = '<img src="'+fileUrl+'/no_image.jpg" onerror="imgError(this,'+item.Gender+');" alt="'+item.Name+'"/>';
                                }
                            }
                            else
                            {
                                // alert(item.photo);
                                // alert("empty");
                                imghtml = '<img src="'+fileUrl+'/teacher/'+item.photo+'" onerror="imgError(this,'+item.Gender+');" alt="'+item.Name+'"/>';
                            }

                            var role = '';

                            // alert(item.status);

                            // if(item.RollId == 1) { role = 'Admin(Trusty)'; }
                            // else if(item.RollId == 2) { role = 'Principal'; }
                            // else if(item.RollId == 3) { role = 'Teacher'; }
                            // else if(item.RollId == 4) { role = 'Hostel Manager'; }
                            // else if(item.RollId == 5) { role = 'Fee Manager'; }
                            // else if(item.RollId == 6) { role = 'Librarian'; }

                            htmldata += '<div class="col-md-3"><div class="panel panel-default"><div class="panel-body profile"><div class="profile-image"><a href="teacher_detail.php?id='+item.UserId+'" title="View Detail">'+imghtml+'</a></div><div class="profile-data"><div class="profile-data-name" style="height: 20px; overflow: hidden;text-overflow: ellipsis; margin-top: -1px">'+item.Name+'</div><div class="profile-data-title">'+item.role+'</div></div><div class="profile-controls"><a href="edit_teacher.php?id='+item.UserId+'" class="profile-control-left" title="Edit"><span class="fa fa-edit"></span></a><a class="profile-control-right delete" title="Delete" onClick="DeleteUser('+item.UserId+');"><span class="fa fa-trash-o"></span></a></div></div><div class="panel-body"><div class="contact-info"><p>';

                            if(item.status==1)
                            {
                                htmldata += '<button class="btn btn-danger" name="save" id="save" style="width: 80px;" onclick="change_status('+item.status+','+item.UserId+')">Active</button> ';
                            }
                            if(item.status==0)
                            {
                                htmldata += '<button class="btn btn-success" name="save" id="save" style="width: 80px;" onclick="change_status('+item.status+','+item.UserId+')">Deactive</button>';
                            }

                            htmldata += '</p><p><small>Mobile</small><br/>'+item.ContactNumber1+'</p><p><small>Email</small><br/>'+item.email+'</p><p><small>Address</small><br/><div style="height: 13px;overflow: hidden;text-overflow: ellipsis; margin-top: -1px">'+item.Address+'</div></p></div></div></div></div>';
                      });
                        
                        $("#showteacher").append(htmldata);      
                        // $("#total").append(total_teacher);      
                    }
                }
            });
        }
    </script>

    <script type="text/javascript">

        function change_status(status_value, user_id)
        {
            if(status_value==0)
            {
                var change_status = 1;
            }
            if(status_value==1)
            {
                var change_status = 0;
            }

            $.ajax({
                url: "{{url('changeStatus')}}",
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                data: {change_status: change_status, user_id: user_id},
                success: function(data)
                {
                    location.reload();
                }
            });
            return false;
        }

        function DeleteUser(id)
        {
            var checkstr =  confirm('Are you sure you want to Delete ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/deleteUser') }}",
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
                            location.href="{{ url('/teachers') }}";
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