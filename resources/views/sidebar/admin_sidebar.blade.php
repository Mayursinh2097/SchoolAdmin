<li class="xn-title">Navigation</li>
<li class="{{ Request::is('dashboard') ? 'active':'' }}">
    <a href="{{url('dashboard')}}" title="Dashboard"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
</li> 
<li class="xn-openable {{ Request::is('school*') ? 'active':'' }} || {{ Request::is('class*') ? 'active':'' }}">
    <a href="#"><span class="fa fa-gears"></span> <span class="xn-text">School</span></a>
    <ul>
        <li class="{{ Request::is('school*') ? 'active':'' }}">
            <a href="{{url('/school')}}" title="School Management"><span class="fa fa-circle-o"></span> School Management</a>
        </li>
        <li class="{{ Request::is('class') ? 'active':'' }}">
            <a href="{{url('/class')}}" title="Class Management"><span class="fa fa-circle-o"></span>Class Management</a>
        </li>
        <li class="{{ Request::is('add_div') ? 'active':'' }}">
            <a href="{{url('/add_div')}}" title="Division Management"><span class="fa fa-circle-o"></span>Division Management</a>
        </li>
        <li class="{{ Request::is('add_state') ? 'active':'' }}">
            <a href="{{url('/add_state')}}" title="State Management"><span class="fa fa-circle-o"></span>State Management</a>
        </li>
        <li class="{{ Request::is('add_district') ? 'active':'' }}">
            <a href="{{url('/add_district')}}" title="District Management"><span class="fa fa-circle-o"></span>District Management</a>
        </li>
        <li class="{{ Request::is('add_religion') ? 'active':'' }}">
            <a href="{{url('/add_religion')}}" title="Religion Management"><span class="fa fa-circle-o"></span>Religion Management</a>
        </li>
        <li class="{{ Request::is('subject') ? 'active':'' }}">
            <a href="{{url('/subject')}}" title="Subject Management"><span class="fa fa-circle-o"></span>Subject Management</a>
        </li>
        <li class="{{ Request::is('subject_class') ? 'active':'' }}">
            <a href="{{url('/subject_class')}}" title="Class Subject Allocation"><span class="fa fa-circle-o"></span>Class Subject Allocation</a>
        </li>
        <li class="{{ Request::is('lecture') ? 'active':'' }}">
            <a href="{{url('/lecture')}}" title="Lecture Management"><span class="fa fa-circle-o"></span>Lecture Management</a>
        </li>
        <li class="{{ Request::is('advertisement') ? 'active':'' }}">
            <a href="{{url('/advertisement')}}" title="Advertisement"><span class="fa fa-circle-o"></span>Advertisement</a>
        </li>
        <li class="{{ Request::is('school_holiday') ? 'active':'' }}">
            <a href="{{url('/school_holiday')}}" title="Holiday"><span class="fa fa-circle-o"></span>Holiday</a>
        </li>
        <li class="{{ Request::is('sub_pdf') ? 'active':'' }}">
            <a href="{{url('/sub_pdf')}}" title="Subject PDF"><span class="fa fa-circle-o"></span>Subject PDF</a>
        </li>
    </ul>
</li>
<!--  <li class="{{ Request::is('offerlist*') ? 'active':'' }} ">
    <a href="{{url('/offerlist')}}"><span class="fa fa-list"></span> <span class="xn-text">Offer List</span></a>                        
</li>  -->