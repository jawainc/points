<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{Request::path() == 'admin'? 'active':''}}">
                <a href="{{route('admin.home')}}">
                    <i class="fa fa-th"></i> <span>dashboard</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="treeview {{str_contains(Request::path(), 'students')? 'active':''}}">
                <a href="#">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span>
                    <span class="pull-right-container">
                        <i class="fas fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::path() == 'admin/students'? 'active':''}}">
                        <a href="{{route('admin.students.index')}}"><i class="far fa-circle"></i> Manage Students</a>
                    </li>
                    <li class="{{str_contains(Request::path(), 'admin/categories/students')? 'active':''}}">
                        <a href="{{route('admin.students.categories')}}"><i class="far fa-circle"></i> Categories</a>
                    </li>
                    <li class="{{str_contains(Request::path(), 'admin/groups/students')? 'active':''}}">
                        <a href="{{route('admin.students.groups')}}"><i class="far fa-circle"></i> Groups</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{str_contains(Request::path(), 'course')? 'active':''}}">
                <a href="#">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Courses</span>
                    <span class="pull-right-container">
                        <i class="fas fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{Request::path() == 'admin/courses'? 'active':''}}">
                        <a href="{{route('admin.courses.index')}}"><i class="far fa-circle"></i> Manage Courses</a>
                    </li>
                    <li class="{{str_contains(Request::path(), 'admin/categories/course')? 'active':''}}">
                        <a href="{{route('admin.categories.course.index')}}"><i class="far fa-circle"></i> Categories</a>
                    </li>
                </ul>
            </li>
            <li class="{{str_contains(Request::path(),'users')? 'active':''}}">
                <a href="{{route('admin.users.index')}}"><i class="fas fa-users-cog"></i> Manage Users</a>
            </li>
            <li class="{{str_contains(Request::path(),'graphs')? 'active':''}}">
                <a href="{{route('admin.graphs.index')}}"><i class="fas fa-chart-line"></i> Graphs</a>
            </li>
            <li class="{{str_contains(Request::path(),'settings')? 'active':''}}">
                <a href="{{route('admin.settings.index')}}"><i class="fas fa-cogs"></i> Settings</a>
            </li>
        </ul>
    </section>
</aside>

<!--/. Sidebar navigation -->


{{--<div class="sidebar-fixed position-fixed">

    <a class="logo-wrapper waves-effect">
        <strong class="blue-text">{{ config('app.name', 'Students Point System') }}</strong>
    </a>

    <div class="list-group list-group-flush">
        <a href="{{URL::route('admin.home')}}" class="list-group-item waves-effect {{Request::path() == 'admin'? 'active':''}}">
            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
        </a>
        <a href="{{URL::route('admin.students.index')}}" class="list-group-item list-group-item-action waves-effect {{str_contains(Request::path(), 'admin/students')? 'active':''}}">
            <i class="fas fa-user-graduate mr-3"></i>Students
        </a>
    </div>

</div>--}}

