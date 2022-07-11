<li class="xn-title">Navigation</li>
<li class="{{ Request::is('dashboard') ? 'active':'' }}">
    <a href="{{url('dashboard')}}" title="Dashboard"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
</li> 
<li class="xn-openable {{ Request::is('school*') ? 'active':'' }} || {{ Request::is('class*') ? 'active':'' }} || {{ Request::is('division*') ? 'active':'' }} || {{ Request::is('state*') ? 'active':'' }} || {{ Request::is('district*') ? 'active':'' }} || {{ Request::is('religion*') ? 'active':'' }} || {{ Request::is('subject*') ? 'active':'' }} || {{ Request::is('allocateClassSubject*') ? 'active':'' }} || {{ Request::is('lecture*') ? 'active':'' }} || {{ Request::is('advertisement*') ? 'active':'' }} || {{ Request::is('holidays*') ? 'active':'' }} || {{ Request::is('subjectPdf*') ? 'active':'' }}">
    <a href="#" title="School"><span class="fa fa-gears"></span> <span class="xn-text">School</span></a>
    <ul>
        <li class="{{ Request::is('school*') ? 'active':'' }}">
            <a href="{{url('/school')}}" title="School Management"><span class="fa fa-circle-o"></span> School Management</a>
        </li>
        <li class="{{ Request::is('class*') ? 'active':'' }}">
            <a href="{{url('/class')}}" title="Class Management"><span class="fa fa-circle-o"></span>Class Management</a>
        </li>
        <li class="{{ Request::is('division*') ? 'active':'' }}">
            <a href="{{url('/division')}}" title="Division Management"><span class="fa fa-circle-o"></span>Division Management</a>
        </li>
        <li class="{{ Request::is('state*') ? 'active':'' }}">
            <a href="{{url('/state')}}" title="State Management"><span class="fa fa-circle-o"></span>State Management</a>
        </li>
        <li class="{{ Request::is('district*') ? 'active':'' }}">
            <a href="{{url('/district')}}" title="District Management"><span class="fa fa-circle-o"></span>District Management</a>
        </li>
        <li class="{{ Request::is('religion*') ? 'active':'' }}">
            <a href="{{url('/religion')}}" title="Religion Management"><span class="fa fa-circle-o"></span>Religion Management</a>
        </li>
        <li class="{{ Request::is('subject*') ? 'active':'' }}">
            <a href="{{url('/subject')}}" title="Subject Management"><span class="fa fa-circle-o"></span>Subject Management</a>
        </li>
        <li class="{{ Request::is('allocateClassSubject*') ? 'active':'' }}">
            <a href="{{url('/allocateClassSubject')}}" title="Class Subject Allocation"><span class="fa fa-circle-o"></span>Class Subject Allocation</a>
        </li>
        <li class="{{ Request::is('lecture*') ? 'active':'' }}">
            <a href="{{url('/lecture')}}" title="Lecture Management"><span class="fa fa-circle-o"></span>Lecture Management</a>
        </li>
        <!-- <li class="{{ Request::is('advertisement*') ? 'active':'' }}">
            <a href="{{url('/advertisement')}}" title="Advertisement"><span class="fa fa-circle-o"></span>Advertisement</a>
        </li> -->
        <li class="{{ Request::is('holidays*') ? 'active':'' }}">
            <a href="{{url('/holidays')}}" title="Holiday"><span class="fa fa-circle-o"></span>Holiday</a>
        </li>
        <!-- <li class="{{ Request::is('subjectPdf*') ? 'active':'' }}">
            <a href="{{url('/subjectPdf')}}" title="Subject PDF"><span class="fa fa-circle-o"></span>Subject PDF</a>
        </li> -->
    </ul>
</li>
<li class="xn-openable {{ Request::is('students*') ? 'active':'' }} || {{ Request::is('student*') ? 'active':'' }}">
    <a href="#" title="Student Details"><span class="fa fa-users"></span> <span class="xn-text">Student Details</span></a>
    <ul>
        <li class="{{ Request::is('students/create') ? 'active':'' }}">
            <a href="{{url('/students/create')}}" title="Add Student"><span class="fa fa-circle-o"></span>Add Student</a>
        </li>
        <li class="{{ Request::is('students') ? 'active':'' }}">
            <a href="{{url('/students')}}" title="Student Management"><span class="fa fa-circle-o"></span>Student Management</a>
        </li>
        <li class="{{ Request::is('student/rollNumber') ? 'active':'' }}">
            <a href="{{url('/student/rollNumber')}}" title="Student Roll Number"><span class="fa fa-circle-o"></span>Student Roll Number</a>
        </li>
        <li class="{{ Request::is('student/LC') ? 'active':'' }}">
            <a href="{{url('/student/LC')}}" title="Student Lc"><span class="fa fa-circle-o"></span>Student LC</a>
        </li>
    </ul>
</li>
<li class="xn-openable {{ Request::is('teachers*') ? 'active':'' }}">
    <a href="#" title="Teacher Details"><span class="fa fa-users"></span> <span class="xn-text">Teacher Details</span></a>
    <ul>
        <!-- <li class="{{ Request::is('teachers/create') ? 'active':'' }}">
            <a href="{{url('/teachers/create')}}" title="Add Teacher"><span class="fa fa-circle-o"></span>Add Teacher</a>
        </li> -->
        <li class="{{ Request::is('teachers') ? 'active':'' }}">
            <a href="{{url('/teachers')}}" title="Teacher Management"><span class="fa fa-circle-o"></span>Teacher Management</a>
        </li>
    </ul>
</li>
<li class="xn-openable {{ Request::is('category*') ? 'active':'' }} || {{ Request::is('subcategory*') ? 'active':'' }}">
    <a href="#" title="Teacher Details"><span class="fa fa-users"></span> <span class="xn-text">Fees Details</span></a>
    <ul>
        <li class="{{ Request::is('category*') ? 'active':'' }}">
            <a href="{{url('/category')}}" title="Category"><span class="fa fa-circle-o"></span>Category</a>
        </li>
        <li class="{{ Request::is('subcategory*') ? 'active':'' }}">
            <a href="{{url('/subcategory')}}" title="SubCategory"><span class="fa fa-circle-o"></span>SubCategory</a>
        </li>
    </ul>
</li>