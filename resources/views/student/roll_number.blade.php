@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Student</li>
        <li class="active">Student Roll Number</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">     
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Allocate Student's Roll Number</strong> </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 col-xs-12 control-label">Class</label>
                                    <div class="col-md-10 col-xs-3">
                                        <select class="form-control" name="class_id" id="class_id">
                                            <option value="">Select Class</option>
                                            <?php   
                                                foreach($classes as $key => $cl){
                                            ?> 
                                                <option value="<?php echo $cl->ClassId; ?>"><?php echo $cl->ClassName; ?></option>
                                            <?php   }   ?> 
                                        </select>
                                        <span class="help-block">Select Class </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Division</label>
                                    <div class="col-md-10 col-xs-3">
                                        <select class="form-control" name="div_id" id="div_id">
                                            <option value="">Select Division</option>
                                        </select>
                                        <span class="help-block">Select Division </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">                                
                            <h3 class="panel-title"><strong>View Student Details</strong> </h3>
                        </div>
                        <div class="panel-body">
                            <div id="studentdata">
                                         
                            </div>
                        </div>
                    </div>
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
                        <p style="font-size: 15px;">Student data is updated Successfully.</p>
                    </div>
                    <div class="mb-footer"></div>
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
                    <div class="mb-footer"></div>
                </div>
            </div>
        </div>

        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger456">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Error</div>
                    <div class="mb-content">
                        <p style="font-size: 15px;">Student Roll Number already exist.</p>
                    </div>
                    <div class="mb-footer"></div>
                </div>
            </div>
        </div>

        <div class="message-box message-box-danger animated fadeIn" id="message-box-danger123">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-trash-o"></span> Deleted</div>
                    <div class="mb-content">
                        <p style="font-size: 15px;">Student data is deleted.</p>
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
    <!-- END ALERT BOX -->
    @section('scripts')
    
    @endsection
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
    
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script type='text/javascript' src="{{asset('js/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>

    <script type="text/javascript">

        $("#class_id").change(function(){
            var class_id = $('#class_id').val();
            get_div(class_id);
        });

        function get_div(class_id){
            var class_id = class_id;
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                RoleId = '<?php echo $RoleId; ?>';

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
                        html_data += '<option value="">Select</option>';
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
    </script>

    <script type="text/javascript">

        $("#div_id").change(function(){
            var class_id = $('#class_id').val();
                div_id = $('#div_id').val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                RoleId = '<?php echo $RoleId; ?>';
            get_stu_data(class_id, div_id, school_id, year_id);        
        });

        function get_stu_data(class_id, div_id, school_id, year_id)
        {
            var class_id = class_id;
            var div_id = div_id;
                school_id = school_id;
                year_id = year_id;
        
            $.ajax({
                url: "{{ url('student/getStudents') }}",
                method: 'get',
                dataType: 'json',
                data: {'class_id':class_id, 'div_id':div_id, 'school_id':school_id, 'year_id':year_id},
                success: function(response) {

                    // console.log(JSON.stringify(response));
                    var len = 0;
                    if(response.success == 0)
                    {
                        $("#studentdata").html('');
                        $("#studentdata").append('<div class="col-sm-12" >Student Data is Not Available</div>');

                    }else{

                        $("#studentdata").html('');
                        var html_data = '';
                        var htmldata = '';
                        var j = 1;
                        for(var i=0; i<response.data.length; i++)
                        {
                            // alert(response.data[i].Gender);
                            if (response.data[i].Gender == '1') { var gender = 'Male'; }
                            else if (response.data[i].Gender == '2') { var gender = 'Female'; }
                            else { var gender = ''; }

                            html_data += '<tr class="odd gradeX">';
                            html_data += '<td class="center">'+j+'</td>';
                            html_data += '<td class="center" id="sn_row'+response.data[i].StudentId+'">'+response.data[i].Roll_Number+'</td>';
                            html_data += '<td class="center">'+response.data[i].StudentName+'</td>';
                            html_data += '<td class="center" id="cl_row'+response.data[i].StudentId+'" style="display:none;">'+response.data[i].Current_Class+'</td>';
                            html_data += '<td class="center" id="de_row'+response.data[i].StudentId+'" style="display:none;">'+response.data[i].Current_Div+'</td>';
                            if (RoleId != 2) {
                                var url = "{{url('students')}}/"+response.data[i].StudentId+'/edit';
                                html_data += '<td class="center">';

                                html_data += '<a id="edit_button'+response.data[i].StudentId+'" style="width: min-content;" class="btn btn-primary btn-rounded" title="Edit"><i class="fa fa-edit" onclick="edit_row('+response.data[i].StudentId+')"></i></a>';

                                html_data += '<a id="save_button'+response.data[i].StudentId+'" class="btn btn-primary btn-rounded" title="Save" style="width: min-content; display: none;"><i class="fa fa-floppy-o" onclick="save_row('+response.data[i].StudentId+')"></i></a>';

                                html_data += '<input type="hidden" id="old_num'+response.data[i].StudentId+'" value="'+response.data[i].Roll_Number+'"></td>';


                                // html_data += '<td class="center"><a href="'+url+'" class="btn btn-primary btn-rounded" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a onClick="deleteStudent('+response.data[i].StudentId+');" style="cursor:pointer" class="btn btn-primary btn-rounded" title="Delete"><i class="fa fa-trash-o "></i></a></td>';
                            }
                            html_data += '</tr>';
                            j++;
                            htmldata = html_data;
                        }

                        if (RoleId != 2) {
                            var html_data = '<table class="table table-hover datatable" style="table-layout:fixed;"><thead><tr><th>#</th><th>Roll Number</th><th>Student Name</th><th>Action</th></tr></thead><tbody>'+htmldata+'</tbody></table>';
                        }else{
                            var html_data = '<table class="table table-hover datatable" style="table-layout:fixed;"><thead><tr><th>#</th><th>Roll Number</th><th>Student Name</th></tr></thead><tbody>'+htmldata+'</tbody></table>';
                        }
                        $("#studentdata").html(html_data);
                        $(".datatable").DataTable();
                        
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
            return false;
        }


        function edit_row(no)
        {
            
            document.getElementById("edit_button"+no).style.display="none";
            document.getElementById("save_button"+no).style.display="block";
            
            var roll_number=document.getElementById("sn_row"+no); //student_id
            var classid=document.getElementById("cl_row"+no);
            var divid=document.getElementById("de_row"+no);
            
            var roll_number_data=roll_number.innerHTML;
            var class_data=classid.innerHTML;
            var div_data=divid.innerHTML;
            
            roll_number.innerHTML="<input type='text' id='roll_number_text"+no+"' value='"+roll_number_data+"'>";
            classid.innerHTML="<input type='text' id='class_id_text"+no+"' value='"+class_data+"'>";
            divid.innerHTML="<input type='text' id='div_id_text"+no+"' value='"+div_data+"'>";
        
        }

        function save_row(no)
        {
            var edit_num = $('#roll_number_text'+no).val();
            var edit_class = $('#class_id_text'+no).val();
            var edit_div = $('#div_id_text'+no).val();
            var old_num = $('#old_num'+no).val();
                school_id = '<?php echo $school_id; ?>';
                year_id = '<?php echo $year_id; ?>';
                // alert("edit_num==>"+edit_num);
                // alert("edit_div"+edit_div);
                // alert("edit_class"+edit_class);

            document.getElementById("edit_button"+no).style.display="block";
            document.getElementById("save_button"+no).style.display="none";

            var formData = new FormData($('#add_role_form')[0]);
                formData.append("edit_num", edit_num);
                formData.append("edit_class", edit_class);
                formData.append("edit_div", edit_div);
                formData.append("no", no);
                formData.append("year_id", year_id);

            $.ajax({
                url: "{{ url('student/saveStudentRollNumber') }}",
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

                    if(response.success == 1){

                        var new_row = '<td class="center" id="sn_row'+no+'">'+edit_num+'</td>';
                        $('#name_text'+no).parent().replaceWith(new_row);

                        $("#message-box-success").modal();
                        setTimeout(function(){ $("#message-box-success").modal('hide'); }, 1500);   
                    }
                    else if(response.success == 2)
                    {
                        var new_row = '<td class="center" id="sn_row'+no+'">'+old_num+'</td>';
                        $('#name_text'+no).parent().replaceWith(new_row);

                        $("#message-box-danger456").modal('show');
                        setTimeout(function(){ $("#message-box-danger456").modal('hide'); }, 1500);
                    }
                    else
                    {
                        $("#message-box-danger").modal('show');
                        setTimeout(function(){ $("#message-box-danger").modal('hide'); }, 1500);
                    }
                },error: function(xhr, status, error) {
                    alert('error : '+xhr.responseText);
                }
            });
            return false;
        }

        function deleteStudent(id)
        {
            var checkstr =  confirm('Are you sure you want to delete Student ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/deleteStudent') }}",
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
                            location.href="{{ url('/students') }}";
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