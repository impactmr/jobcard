@extends('basic')
@Section('PageTitle') Employee Admin @stop

@Section('SearchForm') @Stop

@Section('EmployeeActive') class="active" @stop

@Section('DropDown')<h4>Employee Admin</h4>@stop

@Section('Body')

@if (Session::has('message'))
    <div class="alert alert-info" style="clear:both;">{{ Session::get('message') }}</div>
@endif

</hr>

        <div class="margin-bottom-30" style="float:left;">
            <h4> Admin Tasks </h4>
            <div class="templatemo-sidebar" style="background-color:#DFDFDF;float:left;">
             <ul class="templatemo-sidebar-menu">
                <li><a href="{!! action('EmployeeAdminController@create') !!}"><i class="fa fa-user"></i>Create an Employee</a></li>
                <li><a href="{!! action('EmployeeAdminController@getAll') !!}"><i class="fa fa-cubes"></i>Manage Employees</a></li>
                <li><a href="{!! action('JobCodeController@create') !!}"><i class="fa fa-cog"></i>Create a Job Role</a></li>
                <li><a href="{!! action('JobCodeController@show') !!}"><i class="fa fa-edit"></i>Update a Job Role</a></li>
             </ul>
            </div>
        </div>


@stop

@Section('Footer') Copyright &copy; Impact Research 2015 @Stop

