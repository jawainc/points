<header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">SPS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ config('app.name', 'Students Point System') }}</span>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <i class="fas fa-bars"></i>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{route('admin.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="fas fa-sign-out-alt fa-lg"></i></a>
                </li>
            </ul>
        </div>
    </nav>
    <form id="logout-form" method="post" action="{{route('admin.logout')}}" class="hidden">@csrf</form>
</header>

