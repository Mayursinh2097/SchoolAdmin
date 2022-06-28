@extends('master.master')

@section('content')                   

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>                    
        <li class="active">Dashboard</li>
    </ul>
    <!-- END BREADCRUMB -->                       
    
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        
        <!-- START WIDGETS -->                    
        <div class="row">
            <div class="col-md-3">
                
                <!-- START WIDGET REGISTRED -->
                <div class="widget widget-default widget-item-icon" onclick="location.href='{{ url('dashboard') }}';">
                    <div class="widget-item-left">
                        <span class="fa fa-graduation-cap"></span>
                    </div>
                    <div class="widget-data">
                        <div class="widget-int num-count">{{$students}}</div>
                        <div class="widget-title">Total Student's</div>
                        <div class="widget-subtitle">On Website</div>
                    </div>
                    <div class="widget-controls">                                
                        <!-- <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a> -->
                    </div>                            
                </div>                            
                <!-- END WIDGET REGISTRED -->
                
            </div>
            <div class="col-md-3">
                
                <!-- START WIDGET REGISTRED -->
                <div class="widget widget-default widget-item-icon" onclick="location.href='{{ url('offerlist') }}';">
                    <div class="widget-item-left">
                        <span class="fa fa-users"></span>
                    </div>
                    <div class="widget-data">
                        <div class="widget-int num-count">{{$students}}</div>
                        <div class="widget-title">Total Teacher's</div>
                        <!-- <div class="widget-subtitle">On Website</div> -->
                    </div>
                    <div class="widget-controls">                                
                        <!-- <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a> -->
                    </div>                            
                </div>                            
                <!-- END WIDGET REGISTRED -->
                
            </div>
            <div class="col-md-3">
                
                <!-- START WIDGET CLOCK -->
                <div class="widget widget-info widget-padding-sm">
                    <div class="widget-big-int plugin-clock">00:00</div>                            
                    <div class="widget-subtitle plugin-date">Loading...</div>
                    <div class="widget-controls">                                
                        <!-- <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a> -->
                    </div>                            
                    <div class="widget-buttons widget-c3">
                        <div class="col">
                            <a href="#"><span class="fa fa-clock-o"></span></a>
                        </div>
                        <div class="col">
                            <a href="#"><span class="fa fa-bell"></span></a>
                        </div>
                        <div class="col">
                            <a href="#"><span class="fa fa-calendar"></span></a>
                        </div>
                    </div>                            
                </div>                        
                <!-- END WIDGET CLOCK -->
                
            </div>
        </div>
        <!-- END WIDGETS -->  
    </div>
    <!-- END PAGE CONTENT WRAPPER -->                                
@endsection