<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('admin/') }}" class="logo">
            <span class="logo-mini"><b>Agents</b></span>
            <span class="logo-lg"><b>Agents.com.pk</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li></li>

                    <li><a href="{{ url('/') }}" target="_blank" class="btn btn-warning">Preview Site</a></li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">{{ auth()->guard('admin')->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="http://placehold.it/160x160" class="img-circle" alt="User Image">

                                <p>
                                    {{ auth()->guard('admin')->user()->name }} <br>
                                    {{ unslug(auth()->guard('admin')->user()->type)  }}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">Sign out</a>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>