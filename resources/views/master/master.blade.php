<!DOCTYPE html>
<html lang="en">
<head>       
    @if(!Session::has('name'))
      <script>window.location = "{{url('/.')}}";</script>
    @endif 

    <?php

        $sid = session()->get('sid');
        $name = session()->get('name');
        $RoleId = session()->get('RoleId');
        $role = session()->get('role');
        $school_id = session()->get('school_id');
        $photo = session()->get('photo');

        $dataset_schoolall = DB::table('school_master')->select('school_id', 'schoolname')->where('trusty_sid', '=', $sid)->where('IsDelete', '=', '0')->where('status', '=', '0')->get();

        $dataset_yearall= DB::table('year_master')->select('YearId', 'StartYear', 'EndYear', 'YEAR')->where('IsDelete', '=', '0')->get();

        $dataset_school1 = DB::table('school_master')->select('school_id', 'schoolname')->where('trusty_sid', '=', $sid)->where('IsDelete', '=', '0')->first();

        $dt = date('Y-m-d');

        $dataset_y= DB::table('year_master')->select('year_master.*')->whereRaw('"'.$dt.'" between `StartYear` and `EndYear`')->first();

        $cookie_name = 'user';
        if($RoleId == 1)
        {
            if(!isset($_COOKIE['user']))
            {
                //echo "Hii";exit;
                $school_id = $dataset_school1->school_id;
                $school_name = $dataset_school1->schoolname;
            }
            else
            {
                //echo "Hii Else".$_COOKIE[$cookie_name];exit;
                $school_id = $_COOKIE[$cookie_name];

                $school = DB::table('school_master')->select('schoolname')->where('school_id', '=', $school_id)->where('IsDelete', '=', '0')->first();
                $school_name = $school->schoolname;
            }
        }
        else
        {
           // echo "Hello";exit;
            $school_id = session()->get('school_id');
            $school_name = session()->get('school_name');
        }

        if(!isset($_COOKIE['year'])) 
        {
            $year_id = $dataset_y->YearId;
            //echo "Hii".$year_id;exit;
        }
        else
        {
            $year_id = $_COOKIE['year'];
            //echo "HiiElse".$year_id;exit;

        }
    ?>
        <!-- META SECTION -->
        <title>School Management</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
        <!-- <link rel="shortcut icon" href="{{asset('images/favicon.png')}}"> -->
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-default.css')}}"/>
        <!-- EOF CSS INCLUDE -->       

            <style type="text/css">
                .goog-te-banner-frame.skiptranslate {display: none !important;} 
                body { top: 0px !important; }
                .goog-logo-link { display:none !important; } 
                .goog-te-gadget { color: #1f1f1f !important; /*color: transparent !important;*/ }
                /*div.goog-te-gadget { color: transparent !important; }*/
                select.goog-te-combo { 
                    /*color: black; */
                    border: 1px solid #101215;
                    background: #14171b;
                    color: #AAA;
                    height: 30px;
                    /* padding: 0px 0px 0px 0px; */
                }
            </style>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="{{url('/dashboard')}}">School Management</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            @if($photo)
                                <img src="{{asset('file_upload/'.$photo)}}" alt="School Management"/>
                            @else
                                <img src="{{asset('assets/images/users/avatar.jpg')}}" alt="School Management"/>
                            @endif
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                @if($photo)
                                    <img src="{{asset('file_upload/'.$photo)}}" alt="School Management"/>
                                @else
                                    <img src="{{asset('assets/images/users/avatar.jpg')}}" alt="School Management"/>
                                @endif
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name">{{ session()->get('name') }}</div>
                                <div class="profile-data-title">{{ session()->get('role') }}</div>
                            </div>
                            <div class="profile-controls">
                                <a href="#" class="profile-control-left" title="Profile"><span class="fa fa-info"></span></a>
                                <!-- <a href="{{url('pages-messages.html')}}" class="profile-control-right"><span class="fa fa-envelope"></span></a> -->
                            </div>
                        </div>                                                                        
                    </li>
                    @if($RoleId == 1 || $RollId = 2)
                        @include('sidebar.admin_sidebar')
                    @elseif($RoleId == 3)
                        @include('sidebar.teacher_sidebar')
                    @else
                        @include('sidebar.clerk_sidebar')
                    @endif
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                    <!-- <li class="xn-search">
                        <form role="form">
                            <input type="text" name="search" placeholder="Search..."/>
                        </form>
                    </li> -->   
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout" title="Logout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <?php if($RoleId == 1 || $RoleId == 2 || $RoleId == 8){ ?>
                        <li class="xn-search pull-right">
                            <form  action="#" method="POST">
                                <?php if($RoleId == 1){ ?>
                                    <select id="school_id" name="school_id" onchange="get_school(this.value)">
                                    <?php foreach ($dataset_schoolall as $key => $sc){ ?>
                                        <option value="<?php echo $sc->school_id; ?>" <?php if($sc->school_id == $_COOKIE[$cookie_name]){ echo "Selected"; } ?>><?php //echo $sc->school_id; ?><?php echo $sc->schoolname; ?></option>
                                    <?php } ?>
                                    </select>
                                <?php } ?>
                                <select id="year_id" name="year_id" onchange="get_year(this.value)" style="width: 120px;">
                                    <?php foreach ($dataset_yearall as $key => $yr){ ?>
                                    <option value="<?php echo $yr->YearId; ?>" <?php if(isset($_COOKIE['year'])){if($yr->YearId == $_COOKIE['year']){ echo "Selected"; }}else{if($yr->YearId == $dataset_y->YearId){ echo "Selected"; }} ?> ><?php //echo $yr->YearId.'nn'; ?><?php echo $yr->YEAR; ?></option>
                                    <?php } ?>
                                </select>
                            </form>
                        </li>
                    <?php } ?>

                    <li class="pull-right">
                        <button id="google_translate_element" class="form-control" style="margin-left: 20%;background: transparent;border: none;" ></button>
                    </li>
                    <!-- END SIGN OUT -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->     
                @show

                @yield('content')

                @section('footer')
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ url('doLogout') }}" class="btn btn-success btn-lg">Yes</a>
                            
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                            <form id="logout-form" action="" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('master.alert_box')
        <!-- END MESSAGE BOX-->
        @show
        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{asset('audio/alert.mp3')}}" preload="auto"></audio>
        <audio id="audio-fail" src="{{asset('audio/fail.mp3')}}" preload="auto"></audio>
        <!-- END PRELOADS -->

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{asset('js/plugins/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/jquery/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap.min.js')}}"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script type='text/javascript' src="{{asset('js/plugins/icheck/icheck.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>

        <!-- <script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script> -->
        <!-- <script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>  -->

        <script type="text/javascript" src="{{asset('js/plugins/rickshaw/d3.v3.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/rickshaw/rickshaw.min.js')}}"></script>
        <script type='text/javascript' src="{{asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script type='text/javascript' src="{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
        <script type='text/javascript' src="{{asset('js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/plugins/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- END THIS PAGE PLUGINS-->

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="{{asset('js/settings.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/actions.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
        <script type='text/javascript' src="{{asset('js/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
        <script type='text/javascript' src="{{asset('js/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

        <script type='text/javascript' src="{{asset('js/plugins/noty/jquery.noty.js')}}"></script>
        <script type='text/javascript' src="{{asset('js/plugins/noty/layouts/topCenter.js')}}"></script>
        <script type='text/javascript' src="{{asset('js/plugins/noty/layouts/topLeft.js')}}"></script>
        <script type='text/javascript' src="{{asset('js/plugins/noty/layouts/topRight.js')}}"></script>

        <script type='text/javascript' src="{{asset('js/plugins/noty/themes/default.js')}}"></script>
        
        <!-- <script type="text/javascript" src="{{asset('js/demo_dashboard.js')}}"></script> -->
        <!-- END TEMPLATE -->

        <script type="text/javascript">

            var role = '';
            // var school_id = '1';
            var school_id = '';
            var year_id = '';

            year_id = '<?php echo $year_id; ?>';

            function setCookie(cname, cvalue, exdays)
            {
                var d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                var expires = "expires="+ d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }

            function get_school(id)
            {
                setCookie('user', id, 1);
                location.reload();
            }

            function get_year(yid)
            {
                // echo "Hii";exit;
                setCookie('year', yid, 1);
                location.reload();
            }
            
        </script>
        <script type="text/javascript">
            // function googleTranslateElementInit() {
            //   new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
            // }

            // https://codepen.io/j_holtslander/pen/PjPWMe // works in mozila

            function googleTranslateElementInit() {
                  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT}, 'google_translate_element');
                }
            </script>

            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <!-- END SCRIPTS -->         
    </body>
</html> 