@extends('basic')
@Section('PageTitle') Job Code Admin @stop

@Section('SearchForm') @Stop

@Section('EmployeeActive') class="active" @stop

@Section('DropDown')<h4></h4>@stop

@Section('Body')

<div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info" style="clear:both;">{{ Session::get('message') }}</div>
        @endif                                                                                 
        <br>
         <a href="{!! action('JobCodeController@create') !!}"><i class="fa fa-plus-square-o"></i> Create Job Role</a>
         
         <br>
         <br>
        <div class="table-responsive">          
            <table class="table" id="results">
                <th>Job Role</th><th>Created On</th><th>Last Updated</th><th></th><th></th>
                    @foreach ($joblevels as $joblevel)  
                    <tr>
                        <td>
                            <h4>    
                               {!! $joblevel->description !!}
                            </h4>
                        </td>
                        <td>
                            <h4>    
                                {{ date("d/m/Y H:i",strtotime($joblevel->created_at)) }}
                            </h4>
                        </td>
                        <td>
                            <h4>    
                                {{ date("d/m/Y H:i",strtotime($joblevel->updated_at)) }}
                            </h4>
                        </td>
                        <td>
                            <a href="{!! action('JobCodeController@edit', [$joblevel->job_level]) !!}" ><i class="fa fa-edit"></i>Update</a>
                        </td>
                        <td>
                            <a href="{!! action('JobCodeController@jobhistory', [$joblevel->job_level]) !!}"><i class="fa fa-clock-o"></i> History</a>
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


