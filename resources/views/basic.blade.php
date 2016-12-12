<!DOCTYPE html>
<html lang='en'>
    
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.13/b-1.2.3/b-colvis-1.2.3/datatables.min.css"/>
        <link href="{{ asset('/css/templatemo_415_dashboard/css/templatemo_main.css') }}" rel="stylesheet">
        <title>@yield('PageTitle')</title>
        @yield('Script')
        <script type="text/javascript" src="{{ asset('/js/paging.js') }}"></script>
    </head>

    <body>
        <nav class="navbar navbar-default" style="background-color: white">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/" style="color:#b0312a;">Impact Research</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                                    <li><a href="/"><i class="fa fa-home"></i>Home</a> </li>
                                    <li><a href="{!! action('JobCardController@getAll').'/100' !!}"><i class="fa fa-database"></i> Job Card</a></li>
                                </ul>
                            </li>
                            
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                    <li><a href="/"><i class="fa fa-home"></i>Home</a> </li>
                                    <li><a href="{!! action('JobCardController@getAll').'/100' !!}"><i class="fa fa-database"></i> Job Card</a></li>
                                    <li><a href="{!! action('EmployeeAdminController@index') !!}"><i class="fa fa-users"></i> Employee Admin</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        
        <!--Open Page Wrapper-->
        <div class="templatemo-page-wrapper">
            <!--Open SideBar Wrapper-->
            <div class="navbar-collapse collapse templatemo-sidebar" > 
                <!--SideBar Menu-->
                <ul class="templatemo-sidebar-menu">
                    <li> @yield('SearchForm') </li>
                    <li @yield('HomeActive')> <a href="/"><i class="fa fa-home"></i>Home</a></li>
                    <li @yield('JobCardActive')><a href="{!! action('JobCardController@getAll').'/100' !!}"><i class="fa fa-database"></i>Job Card</a></li>
                    @if (Auth::user())
                    <li id="MainMenu" @yield('EmployeeActive')><a href="#submenu" data-toggle="collapse" data-parent="#MainMenu"><i class="fa fa-users"></i>Employee Admin</a></li>
                        <div class="collapse" id="submenu">
                            <a href="{!! action('EmployeeAdminController@create') !!}" class="list-group-item"><i class="fa fa-user"></i>Create Employee</a>
                            <a href="{!! action('EmployeeAdminController@getAll') !!}" class="list-group-item"><i class="fa fa-cubes"></i>Manage Employees</a>
                            <a href="{!! action('JobCodeController@create') !!}" class="list-group-item"><i class="fa fa-cog"></i>Create Job Role</a>
                            <a href="{!! action('JobCodeController@show') !!}" class="list-group-item"><i class="fa fa-edit"></i>Manage Job Roles</a>
                        </div>
                    @endif
                    
                </ul>
            </div>

            <!--Open Content Wrapper-->
            <div class="templatemo-content-wrapper">
                
                <div class="templatemo-content">  
                    
                    <div> @yield('Body') </div>
                    
                </div>
                
            </div>
        </div>
        
        <footer class="templatemo-footer">
            <div class="templatemo-copyright col-md-offset-1"> @yield('Footer') </div>
        </footer>
    </body>
    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/b-1.2.3/b-colvis-1.2.3/datatables.min.js"></script>    @yield('EndScript')
</html>