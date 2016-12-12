<!DOCTYPE html>
<html lang='en'>
    
    <head>
        
        <meta charset = "utf-8">
        <!--Link to CSS3 Style Sheet-->
        <meta name="viewport" content="width=device-width"> 
        <link href="{{ asset('/css/templatemo_415_dashboard/css/templatemo_main.css') }}" rel="stylesheet">
        <!--Set Page Title-->
        <title>@yield('PageTitle')</title>
  
    </head>

    <body>
        <nav class="navbar navbar-default" style="background-color: #EBEBEB">
            <div class="container-fluid">
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle Navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                        </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav navbar-right">
                                @if (Auth::guest())
                                        
                                        <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu<span class="caret"></span></a>
                                                <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                                                        <li><a href="/"><i class="fa fa-home"></i>Home</a> </li>
                                                        <li><a href="{!! action('JobCardController@index') !!}"><i class="fa fa-database"></i> Job Card</a></li>
                                                </ul>
                                        </li>
                                @else
                                        <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                                                <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                                        <li><a href="/"><i class="fa fa-home"></i>Home</a> </li>
                                                        <li><a href="{!! action('JobCardController@index') !!}"><i class="fa fa-database"></i> Job Card</a></li>
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
            <div class="navbar-collapse collapse templatemo-sidebar"> 
                <!--SideBar Menu-->
                <ul class="templatemo-sidebar-menu">
                    <li>
                        @yield('SearchForm')
                    </li>
                    <!--Navigation-->
                    <li @yield('HomeActive')>
                        <a href="/"><i class="fa fa-home"></i>Home</a>
                    </li>
                    <li @yield('JobCardActive')>
                        <a href="jobcard"><i class="fa fa-database"></i>Job Card</a>
                    </li>
                    <li @yield('EmployeeActive')>
                        <a href="employeeadmin"><i class="fa fa-users"></i>Employee Admin</a>
                    </li>
                </ul>
            </div>
            
            
            <!--Open Content Wrapper-->
            <div class="templatemo-content-wrapper">
                <div class="templatemo-content">
                
                    <!--Page Header Container-->
                    <div class="logo" style="margin-bottom:1%">
                        <img class = "logo" src = "{{ asset('img/impact.jpg') }}" alt="Impact Research Logo"/>
                    </div>

                    <div>
                        
                    <!--Table Wrapper-->
                     <div class="col-md-4 col-sm-4 margin-bottom-10">
                         <!--Table Container-->
                         <div class="panel panel-default">
                             <div class="panel-heading"><h1>Project Details</h1></div>
                             <div class="panel-body">

                                 <!--Table for Project Costs-->
                                 <table class="table table-striped">
                                     @yield('TableProjectDetails')
                                 </table>

                             </div>
                         </div>
                     </div>

                    <!--Table Wrapper-->
                     <div class="col-md-4 col-sm-4 margin-bottom-30">
                         <!--Table Container-->
                         <div class="panel panel-default">
                             <div class="panel-heading">Project Costs</div>
                             <div class="panel-body">

                                 <!--Table for Project Details-->
                                 <table class="table table-striped">				
                                     @yield('TableProjectCosts')
                                 </table>

                             </div>
                         </div>
                     </div>

                     <!--Table Wrapper-->
                     <div class="col-md-8 col-sm-8 margin-bottom-30" style="clear:both;">
                         <!--Table Container-->
                         <div class="panel panel-default">
                             <div class="panel-heading">
                             	Project Hours
                                @yield('EditButton')

                             </div>

                             <!--Table for Project Hours-->
                             <table class="table table-condensed">
                                 @Yield('TableEmployeeHours')
                             </table>
                         </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
        <footer class="templatemo-footer">
                <div class="templatemo-copyright"> @yield('Footer') </div>
        </footer>
    </body>
    <!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</html>