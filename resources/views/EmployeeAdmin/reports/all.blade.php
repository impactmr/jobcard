@extends('basic')
@Section('PageTitle') Employee Admin @stop

@Section('SearchForm') @Stop

@Section('EmployeeActive') class="active" @stop

@Section('DropDown')<h4></h4>@stop


@Section('Body')
   
    @if (Session::has('message'))
        <div class="alert alert-info" style="clear:both;">{{ Session::get('message') }}</div>
    @endif

    <div class="container">
        <br>
      
        {!! Form::open(['method' => 'POST', 'url' => ['employeeadmin/all']]) !!}
            {!! Form::select('joblevel', $joblevels, $selected, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
        {!! Form::close() !!}
        
        <br>
        
         <a href="{!! action('EmployeeAdminController@create') !!}"><i class="fa fa-plus-square-o"></i> Create Employee</a>
         
         <br>
         <br>
    
        <div class="table-responsive">          
            <table class="table" id="results">
                <th> Name </th> <th> Job Role </th> <th> Started Role </th><th></th><th></th>

                @foreach ($currentemployees as $currentemployee) 
                    <tr>
                    <td>
                        <h4>    
                            {!! $currentemployee[1]; !!}
                        </h4>
                    </td>
                    <td>
                        <h4>    
                           {!! $currentemployee[2]; !!}
                        </h4>
                    </td>
                    <td>
                        <h4>    
                            {!! date("d/m/Y H:i",strtotime($currentemployee[3])); !!}
                        </h4>
                    </td>
                    <td>
                        <a href="{!! action('EmployeeAdminController@edit', [$currentemployee[0]]) !!}" ><i class="fa fa-edit"></i>Update</a>
                    </td>
                    <td>
                         <a href="{!! action('EmployeeAdminController@employeehistory', [$currentemployee[0]]) !!}" ><i class="fa fa-clock-o"></i> Job History</a>
                    </td>
                    </tr>
                @endforeach
             </table>
            <div id="pageNavPosition"></div>
            
        </div>
    </div>


@stop


@Section('Footer') Copyright &copy; Impact Research 2015 @Stop

@Section('EndScript')

    <script type="text/javascript"><!--

        var pager = new Pager('results', 10); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
    //--></script>

@Stop

