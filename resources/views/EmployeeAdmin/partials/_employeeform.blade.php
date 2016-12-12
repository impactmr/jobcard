<!--This form is a template for the create and edit options in the employee admin section-->

<!--First Name-->
<div class='form-group'>
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>

<!--Last Name-->
<div class='form-group'>
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
</div>

<!--Job Role-->
<div class='form-group'>
    {!! Form::label('joblevel', 'Job Role:') !!}
    {!! Form::select('joblevel', $joblevels, $default, ['class' => 'form-control']) !!}
</div>

<!--Submit Button-->
<div class='form-group'>
    {!! Form::submit(isset($buttontext) ? $buttontext : 'Create Employee', ['class' => 'btn btn-primary form-control']) !!}
</div>


