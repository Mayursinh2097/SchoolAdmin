@extends('master.master')

@section('content')

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>School</li>
        <li class="active">View School</li>
    </ul>
    <!-- END BREADCRUMB -->           

    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">                
    
        <div class="row">
            <div class="col-md-12">

                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-default">
                    <div class="panel-heading">                                
                        <h3 class="panel-title"><strong>View School List</strong></h3>
                        <ul class="panel-controls">
                            <a href="{{ url('/school/create') }}"><button class="btn btn-primary pull-right" name="save" id="save">Add School</button></a>
                            <!-- <li><a href="{{url('admin/offerlist')}}" class="panel-refresh"><span class="fa fa-refresh"></span></a></li> -->
                            <!-- <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li> -->
                        </ul>                                
                    </div>
                    <div class="panel-body">
                        <table class="table datatable" id="school">
                            <thead>
                                <tr>
                                    <th>No.</th>                               
                                    <th>School Name</th>                               
                                    <th>Dise code</th>                               
                                    <th>Registration No</th>      
                                    <th>Contact No</th>      
                                    <th>Email</th>      
                                    <!-- <th>Standard</th>       -->
                                    <th>Language</th>   
                                    <th>Status</th>   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="schoolid">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($Schools as $sc)
                                    <tr>
                                        <td class="center"> <?php echo $i; ?></td>
                                        <td class="center"> <?php echo $sc->schoolname;?></td>
                                        <td class="center"> <?php echo $sc->diseccode;?></td>
                                        <td class="center"> <?php echo $sc->registration_no;?></td>
                                        <td class="center"> <?php echo $sc->contact_no1;?></td>
                                        <td class="center"> <?php echo $sc->email;?></td>
                                        <!-- <td class="center"> <?php echo $sc->standard;?></td> -->
                                        <td class="center"> <?php echo $sc->MediumName;?></td>
                                        <td class="center" style="text-align: center;">
                                            <label class="switch">
                                                <input type="checkbox" class="active_school" @if($sc->status == '0') {{ 'checked' }} @endif value="{{$sc->school_id}}" />
                                                <span></span>
                                              </label>
                                        </td>
                                        <td class="center">
                                            <a href="{{url('school/'.$sc->school_id.'/edit')}}" class="btn btn-primary btn-rounded" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                            <a  onclick="deleteSchool('{{$sc->school_id}}');" class="btn btn-danger btn-rounded" name="delete" id="delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END DEFAULT DATATABLE -->
            </div>
        </div>                                
    </div>
    <div class="message-box message-box-success animated fadeIn" id="message-box-success">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> Success</div>
                <div class="mb-content">
                    <p style="font-size: 15px;"></p>
                </div>
                <div class="mb-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- PAGE CONTENT WRAPPER -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">

        $('.active_school').on('change', function() {
       
            var val = this.checked ? 0 : 1;
            var status = this.checked ? 'Active' : 'Deactive';
            var checkstr =  confirm('Are you sure you want to '+status+' School ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/change_school_status') }}",
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {'school_id':this.value, 'status':val},
                    success: function(data) {
                        // alert(data.success);
                        if(data.success == 1)
                        {   
                            $("#message-box-success").modal('show');
                            setTimeout(function(){ $("#message-box-success").modal('hide'); }, 1500);
                        }
                        else
                        {
                            $("#message-box-danger").modal('show');
                            setTimeout(function(){ $("#message-box-danger").modal('hide'); }, 1500);
                        }
                    },error: function(xhr, status, error) {
                       
                    }
                });
              // do your code
            }
        });

        function deleteSchool(id){
            var checkstr =  confirm('Are you sure you want to delete School ?');
            if(checkstr == true){
                $.ajax({
                    url: "{{ url('/deleteschool') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    data: {'id':id},
                    success: function(data) {
                        // location.reload();
                        var response = JSON.parse(data);
                        // console.log("res==>"+response.success);

                        if(response.success == 1)
                        {   
                            $("#message-box-danger1").modal('show');
                            
                            setTimeout(function(){ 
                                $("#message-box-danger1").modal('hide');
                                location.reload();
                            }, 1500);
                        }
                        else
                        {
                            $("#message-box-danger").modal('show');
                            setTimeout(function(){ $("#message-box-danger").modal('hide'); }, 1500);
                        }
                    },error: function(xhr, status, error) {
                       
                    }
                });
            }
            return false;
        }

    </script>
@endsection