@php ($userAvatar = (Auth::user()->avatar_name) ? Auth::user()->avatar_name : 'default_avatar.png')
<header class="main-header">
    <a href="{{ url('admin') }}" class="logo">
        <span class="logo-lg"><b>OXAL</b> Admin</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('user_avatars/'.$userAvatar) }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }} <span class="fa fa-angle-down"></span></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ asset('user_avatars/'.$userAvatar) }}" class="img-circle" alt="User Image">
                            <p>{{ Auth::user()->name }}</p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="{{ url('admin/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>