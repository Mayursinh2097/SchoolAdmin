<!DOCTYPE html>
<html lang="en" class="body-full-height">
<head> 
    @if(Session::has('name'))
      <script>window.location = "{{url('/dashboard')}}";</script>
    @endif
      
        <!-- META SECTION -->
        <title>School Management</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"> -->

        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/theme-default.css')}}"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        <div class="login-container lightmode">
            <div class="login-box animated fadeInDown">
                <div style="text-align: center;">
                    <h2 style="color: floralwhite;">School Management</h2>
                </div>
                <div class="login-body">
                    <div class="login-title"><strong style="color: #019806;">Welcome,</strong> Please login</div>
                    <form class="form-horizontal" id="loginForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Email Address" name="username"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" placeholder="Password" name="password"  />
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- <div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div> -->
                        <div class="col-md-6 pull-right">
                            <button class="btn btn-info btn-block btn_login" style="font-weight: bold;">LogIn</button>
                        </div>
                    </div>
                    <div id="alert"></div>
                    <div class="login-footer">
                        <div style="text-align: center; font-size: 15px; color: #019801; font-weight: bold;">
                            &copy; 2022 School Management
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/jquery-validation/jquery.validate.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#loginForm").validate({
                    rules: {
                        // "username": { required: true, email: true },
                        "username": "required",
                        "password": "required",
                    },submitHandler: function(form) {
                        var formData = new FormData($('form#loginForm')[0]);
                        $.ajax({
                            url: "{{ url('doLogin') }}",
                            method: 'post',
                            contentType: false,
                            processData: false,
                            async: false,
                            headers: {
                                'X-CSRF-TOKEN': $("input[name='_token']").val()
                            },
                            data: formData,
                            success: function(data) {
                                
                                if(data.success == false){

                                    $('#alert').html(data.error_msg);
                                    $('#alert').addClass('alert-danger');
                                    setTimeout(function(){ 
                                        $('#alert').html('');
                                        $('#alert').removeClass('alert-danger');
                                    }, 3000);
                                }else{
                                    location.href = "{{ url('/dashboard') }}";
                                }
                            },error: function(xhr, status, error) {
                            }
                        });
                        return false;
                    }
                });
                $('.btn_login').click(function() {
                    $("#loginForm").valid();      
                });
            });
        </script>
    </body>
</html>