@extends('basic')
@Section('PageTitle') Employee Admin @stop

@Section('SearchForm') @Stop

@Section('EmployeeActive') class="active" @stop

@Section('Body')
    
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2" style="margin-top:2%;">
			<div class="panel panel-default">
				<div class="panel-heading">Create A Job Role</div>
				<div class="panel-body">
    
                                    {!! Form::open(['url' => 'jobcodeadmin']) !!}

                                        @include('JobCodeAdmin/partials/_jobcodeform', ['buttontext' => 'Create Job', 'defaultrate' => null, 'defaultrole' => null])

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
