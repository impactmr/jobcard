@extends('basic')
@Section('PageTitle') Job Card @stop

@Section('Script')

<script type="text/javascript" src="{{ asset('/js/JobCardEdit.js') }}"> </script>

@Stop

@Section('SearchForm') @Stop

@Section('JobCardActive') class="active" @stop

@Section('DropDown')<h4>Job Card</h4 >@stop

@Section('Body')

<div id="EmployeeCount" style="visibility: hidden;"> {{ $employeecount }} </div>
<div id="ProjectID" style="visibility: hidden;"> {{ $project->project_code }} </div>

    <div class="col-xs-12">
        <div class="btn-group" style="width:100%">
            <button id="SubmitButton" class="btn-primary" onclick="Validation();" style="float: left;">Submit Changes</button>
            <div class="col-xs-3" style="float: right;">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" style="float:right">
              <i class="fa fa-info-circle"></i> Project Details
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" style="width:100%;padding:2%; float:right;">
                <h4><small> Project Manager: {!! $projectmanager->first_name." ".$projectmanager->last_name !!} </small></h4>
                <h4><small> Sector: {!! $project->sector !!} </small></h4>
                <h4><small> Type: {!! $projecttype !!} </small></h4>
                <h4><small> Proposal Date: {!! date("d/m/Y",strtotime($project->proposal_date)) !!} </small></h4>
                <h4><small> Date Won: {!! date("d/m/Y",strtotime($project->won_date)) !!} </small></h4>
             </ul>
                </div>
        </div>
    </div>
    
    <br>
    <br>
    
    <hr>

    <div class="col-xs-12" style="margin-top:1%;clear:both"><h4> Client: {!! $project->client !!} </h4></div>
    <div class="col-xs-12" style="margin-top:1%;clear:both"><h4> Project: {!! $project->name !!} </h4></div>
    
    <div class="col-xs-4" style="margin-top:2%">

        <div class="table-responsive">          
            <table class="table text-center">

                <tr>
                    <th>Target Profit</th>                
                    <td style="background-color:#FFFFE6;border-color:#FFFF00;background-color:1px">                        
                        <small id="target1" contenteditable="true" onclick="setTimeout(document.execCommand('selectAll',false,null),100)" onkeypress="return disableEnterKey(event)">{!! $TargetProfit  !!}</small><small contenteditable = "false">%</small> 
                    </td>

                </tr>

                <tr>
                    <th>Estimated Completion</th>
                    <td  style="background-color:#FFFFE6;border-color:#FFFF00;background-color:1px">
                        <small id="target2" contenteditable="true" onclick="setTimeout(document.execCommand('selectAll',false,null),100)" onkeypress="return disableEnterKey(event)">{!! $EstimatedCompletion !!}</small><small contenteditable = "false">%</small> 
                    </td>
                </tr>

             </table>
        </div>
    </div>
    
    <div class="col-xs-12">
        
        {!! Form::open(['id' => 'inputs', 'method' => 'PATCH', 'url' => 'jobcard/update']) !!}
                            
               <input type='hidden' name='ProjectID' value='{{$project->project_code}}'/>         

        {!! Form::close() !!}
        
        
        <div class="table-responsive">          
            <table class="table text-center table-bordered" id="results">
                <thead>
                <tr>
                    <th> Employee </th> <th class="text-center"> Budget Hours </th>
                    <th class="text-center"> Worked Hours </th>
                    <th class="text-center"> Forecast Hours </th>
                </tr>
                </thead>
                <tbody>
                
                <?php $i=0 ?>
                
                @foreach ($employeehours as $employee)     
                    <?php $i++ ?>
                    <tr>
                        <td>
                            <h4 align="left">
                                <small>{!! $employee[1] !!}</small> 
                            </h4>
                        </td>
                        
                        <td  style="background-color:#FFFFE6;border-color:#FFFF00;background-color:1px" onkeypress="return disableEnterKey(event);">
                            <h4>
                                <small contenteditable="true"  id="budget_{{$i}}" onclick="setTimeout(document.execCommand('selectAll',false,null),100)" on="setTimeout(document.execCommand('selectAll',false,null),100)">{!! $employee[2] !!}</small>
                            </h4>
                        </td>
                        
                        <td style="border-width:1px">
                            <h4>
                                <small >{!! $employee[4] !!}</small>
                            </h4>
                        </td>
                        
                        <td  style="background-color:#FFFFE6;border-color:#FFFF00;border-width:1px" onkeypress="return disableEnterKey(event)">
                            <h4>
                                <small contenteditable="true" id="forecast_{{$i}}" onclick="setTimeout(document.execCommand('selectAll',false,null),100)"> {!! $employee[3] !!}</small>
                            </h4>
                        </td>                       

                    </tr>

                    
                    
                @endforeach
                </tbody>
            </table>
            
            
            
            

        </div>
        
    </div>

@stop

@Section('Footer') Copyright &copy; Impact Research 2015 @Stop

@Section('EndScript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#results').DataTable({
            "order": [[ 1, "desc" ]],
            "pageLength": 100
        });
    });
</script>
@Stop