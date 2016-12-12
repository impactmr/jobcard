@extends('basic')
@Section('PageTitle') Employee Admin @stop

@Section('SearchForm') @Stop

@Section('EmployeeActive') class="active" @stop

@Section('DropDown')<h4></h4>@stop


@Section('Body')

 <div class="container">
        <h2>Job History</h2>
        <br>
        <a href="{!! action('JobCodeController@edit', array_values($jobarray)[0]) !!}" ><i class="fa fa-edit"></i>Update This Job</a>
        <br>
        <br>
   
   <div class="table-responsive">          
            <table class="table" id="results">
                <th> Job Role </th> <th> Rate </th> <th> Updated </th>

                @foreach ($jobarray as $job) 
                    <tr>
                    <td>
                        <h4>    
                            {!! $job[2]; !!}
                        </h4>
                    </td>
                    <td>
                        <h4>    
                           {!! "£ ".$job[3]; !!}
                        </h4>
                    </td>
                    <td>
                        <h4>    
                            {!! date("d/m/Y H:i",strtotime($job[4])); !!}
                        </h4>
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
