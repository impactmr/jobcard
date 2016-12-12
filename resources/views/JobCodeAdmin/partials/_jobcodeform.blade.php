<div class='form-group'>
    {!! Form::label('role_name', 'Role Name:') !!}
    {!! Form::text('role_name', $defaultrole, ['class' => 'form-control']) !!}
</div>

<div class='form-group'>
    {!! Form::label('rate', 'Rate: £') !!}
    {!! Form::text('rate', $defaultrate, ['class' => 'form-control']) !!}
</div>

<div class='form-group'>
    {!! Form::submit(isset($buttontext) ? $buttontext : 'Create Employee', ['class' => 'btn btn-primary form-control']) !!}
</div>