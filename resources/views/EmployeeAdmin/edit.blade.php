@extends('basic')
@Section('PageTitle') Employee Admin @stop

@Section('SearchForm') @Stop

@Section('EmployeeActive') class="active" @stop

@Section('Body')
    
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-1" style="margin-top:2%;">
			<div class="panel panel-default">
				<div class="panel-heading">Update An Employee</div>
				<div class="panel-body">
    
                                    {!! Form::model($selectedemployee,['method' => 'PATCH', 'route' => ['employeeadmin.update', $selectedemployee->employee_code]]) !!}

                                    @include('EmployeeAdmin/partials/_employeeform', ['buttontext' => 'Update Employee', 'default' => $currentjoblevel])

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
