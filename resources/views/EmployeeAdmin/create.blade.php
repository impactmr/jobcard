<!--This Page Extends the basic template-->
@extends('basic')

<!--Set Page Title-->
@Section('PageTitle') Employee Admin @stop

<!--Set Active Section-->
@Section('EmployeeActive') class="active" @stop

<!--Add content to page body-->
@Section('Body')

<!--Open container for Body Content-->
<div class="container-fluid">
        <!--Add Row to Container-->
	<div class="row">
                <!--Add Container for User Form-->
		<div class="col-md-8 col-md-offset-2" style="margin-top:2%;">
                        <!--Add Inner Container-->
			<div class="panel panel-default">
                                <!--Add Heading Container-->
				<div class="panel-heading">Create An Employee</div>
                                <!--Add Form Body-->
				<div class="panel-body">
                                    
                                    <!--Open User Form-->
                                    {!! Form::open(['url' => 'employeeadmin']) !!}

                                        @include('EmployeeAdmin/partials/_employeeform', ['buttontext' => 'Create Employee', 'default' => 1])

                                    {!! Form::close() !!}

                                    @if ($errors->any())

                                        <ul class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</l1>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                        </div>
                </div>
        </div>
</div>
                

@stop

@Section('Footer') Copyright &copy; Impact Research 2015 @Stop


