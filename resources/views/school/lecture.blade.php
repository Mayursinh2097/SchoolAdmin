@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">View Lecture</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">     
        <div class="row">
            <div class="col-md-12">
                <form id="add_role_form" class="form-horizontal" enctype="multipart/form-data" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Add Lecture</strong> </h3>
                            <ul class="panel-controls">
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Day</label>
                                    <div class="col-md-9 col-xs-3">
                                        <select class="form-control" name="day_id" id="day_id">
                                            <option value="">Select</option>
                                            <?php   
                                                foreach($days as $key => $dy){
                                            ?> 
                                                <option value="<?php echo $dy->day_id; ?>"><?php echo $dy->day; ?></option>
                                            <?php   }   ?> 
                                        </select>
                                        <span class="help-block">Select Class </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Lecture Name</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="text" class="form-control" id="lecture_name" name="lecture_name"/>
                                        </div>
                                        <span class="help-block">Fill up name</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Start Time</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="text" class="form-control" id="start_time" name="start_time"/>
                                        </div>
                                        <span class="help-block">Fill up name</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">End Time</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="text" class="form-control" id="end_time" name="end_time"/>
                                        </div>
                                        <span class="help-block">Fill up name</span>
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
                        <h3 class="panel-title"><strong>View Lectures </strong> </h3>
                        <ul class="panel-controls"></ul>                                
                    </div>
                    <div class="panel-body">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Day</th>      
                                    <th>Lecture</th>      
                                    <th>Start Time</th>      
                                    <th>End Time</th>      
                                    <th>Action</th>      
                                </tr>
                            </thead>  
                            <tbody>
                            <?php 
                                $i = 1;
                                foreach ($lectures as $key => $sm)
                                {
                            ?>
                                <tr class="odd gradeX" >
                                    <td class="center"> <?php echo $i;?></td>
                                    <td class="center"> <?php echo $sm->day;?></td>
                                    <td class="center"> <?php echo $sm->lecture_name;?></td>
                                    <td class="center"> <?php echo $sm->start_time;?></td>
                                    <td class="center"> <?php echo $sm->end_time;?></td>
                                    <td class="center">
                                        <a href="{{url('lecture/'.$sm->lecture_id.'/edit')}}" class="btn btn-primary btn-rounded" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;

                                        <a  onclick="deleteLecture('{{$sm->lecture_id}}');" class="btn btn-danger btn-rounded" name="delete" id="delete" title="Delete"><i class="fa fa-trash-o"></i></a>
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
                    <p style="font-size: 15px;">Lecture added successfully.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger45">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;">Error to add Lecture.</p>
                </div>
                <div class="mb-footer"></div>
            </div>
        </div>
    </div>

    <div class="message-box message-box-danger animated fadeIn" id="message-box-danger123">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span>Error</div>
                <div class="mb-content">
                    <p style="font-size: 15px;"> Lecture already inserted.</p>
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
                    <p style="font-size: 15px;"> Lecture deleted successfully.</p>
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
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

    <script type="text/javascript">

        $("#start_time").inputmask("hh:mm t", {"placeholder": "hh:mm t"});
        $("#end_time").inputmask("hh:mm t", {"placeholder": "hh:mm t"});

        var validator = $("#add_role_form").validate({
            rules: {
                day_id: { required: true, },
                lecture_name: { required: true, },
                start_time: { required: true, },
                end_time: { required: true, },
            },
            submitHandler: function(form) 
            { 
                addLecture();
            }
        });
        function addLecture()
        {
            var day_id = $('#day_id').val();
                lecture_name = $('#lecture_name').val();
                start_time = $('#start_time').val();
                end_time = $('#end_time').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                // alert(school_id);

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("day_id", day_id);
                formData.append("lecture_name", lecture_name);
                formData.append("start_time", start_time);
                formData.append("end_time", end_time);
                formData.append("school_id", school_id);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('lecture/addLecture') }}",
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
                    if(response.success==1)
                    {
                        $("#message-box-success").modal('show');
                        setTimeout(function(){ location.reload(); }, 1500);
                    }

                    else if(response.success==2)
                    {
                        $("#message-box-danger123").modal('show');
                        setTimeout(function(){ $("#message-box-danger123").modal('hide') }, 1500);
                    }

                    else
                    {
                        $("#message-box-danger45").modal('show');
                        setTimeout(function(){ $("#message-box-danger45").modal('hide'); }, 1500);
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
        }

        function deleteLecture(id)
        {
            var checkstr =  confirm('Are you sure you want to delete Lecture ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/deleteLecture') }}",
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
                            location.href="{{ url('/lecture') }}";
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