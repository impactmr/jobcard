@extends('basic')

@Section('PageTitle') Job Card @stop

@Section('SearchForm') @Stop

@Section('JobCardActive') class="active" @stop

@Section('DropDown')<h4>Job Card</h4 >@stop

@Section('Body')

    @if (Session::has('message'))
        <div class="alert alert-info" style="clear:both;">{{ Session::get('message') }}</div>
    @endif

    <div class="col-xs-8">
        {!! Form::open(['name' => 'projectform', 'method' => 'POST','url' => ['jobcard/0']]) !!}
            {!! Form::select('selectedproject', $projectslist, $selectedproject, ['id' => 'select2-target', 'class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
        {!! Form::close() !!}
    </div>

    
    <div class="col-xs-4">
        <div class="btn-group" style="width:100%">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-info-circle"></i> Project Details
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" style="width:100%;padding:2%">
                <h4><small> Project Manager: {!! $projectmanager->first_name." ".$projectmanager->last_name !!} </small></h4>
                <h4><small> Sector: {!! $project->sector !!} </small></h4>
                <h4><small> Type: {!! $projecttype !!} </small></h4>
                <h4><small> Proposal Date: {!! date("d/m/Y",strtotime($project->proposal_date)) !!} </small></h4>
                <h4><small> Date Won: {!! date("d/m/Y",strtotime($project->won_date)) !!} </small></h4>
             </ul>
        </div>
    </div>
    
    
    
    <br>
    <br>
    <hr>
    
    <div class="col-xs-12">
        <a href="{!! action('JobCardController@edit', $selectedproject) !!}"><i class="fa fa-edit"></i>Edit This Job Card</a>
    </div>

    <div class="col-xs-12" style="margin-top:1%;clear:both"><h4> Client: {!! $project->client !!} </h4></div>

    <div class="col-xs-6" style="margin-top:2%">
        <div class="table-responsive">          
            <table class="table text-center">
                <thead>
                    <tr>
                        <th class="text-center" style="font-size: 11px"></th>
                        <th class="text-center" style="font-size: 11px">Budget Costs</th>
                        <th class="text-center" style="font-size: 11px">Actual (To Date) Costs</th>
                        <th class="text-center" style="font-size: 11px">Forecast Costs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="font-size: 11px">Current Value</th>
                        <td>£{!! number_format(round($BudgetCosts[0],2)) !!}</td>
                        <td>£{!! number_format(round($ActualCosts[0],2)) !!}</td>
                        <td>£{!! number_format(round($ForecastCosts[0],2)) !!}</td>
                    </tr>
                    <tr>
                        <th style="font-size: 11px">Contribution</th>
                        <td>£{!! number_format(round($BudgetCosts[1],2)) !!}</td>
                        <td>£{!! number_format(round($ActualCosts[1],2)) !!}</td>
                        <td>£{!! number_format(round($ForecastCosts[1],2)) !!}</td>
                    </tr>
                    <tr>
                        <th style="font-size: 11px">Gross Margin %</th>
                        <td>{!! number_format(round($BudgetCosts[2],2)) !!}%</td>
                        <td>{!! number_format(round($ActualCosts[2],2)) !!}%</td>
                        <td>{!! number_format(round($ForecastCosts[2],2)) !!}%</td>
                    </tr>
                    <tr>
                        <th style="font-size: 11px">Supplier Costs</th>
                        <td>£{!! number_format(round($BudgetCosts[3],2)) !!}</td>
                        <td>£{!! number_format(round($ActualCosts[3],2)) !!}</td>
                        <td>£{!! number_format(round($ForecastCosts[3],2)) !!}</td>
                    </tr>
                    <tr>
                        <th style="font-size: 11px">Staff Costs</th>
                        <td>£{!! number_format(round($BudgetCosts[4],2)) !!}</td>
                        <td>£{!! number_format(round($ActualCosts[4],2)) !!}</td>
                        <td>£{!! number_format(round($ForecastCosts[4],2)) !!}</td>
                    </tr>
                    <tr>
                        <th style="font-size: 11px">Net Profit</th>
                        <td>£{!! number_format(round($BudgetCosts[5],2)) !!}</td>
                        <td>£{!! number_format(round($ActualCosts[5],2)) !!}</td>
                        <td>£{!! number_format(round($ForecastCosts[5],2)) !!}</td>
                    </tr>
                    <tr>
                        <th style="font-size: 11px">Net Profit %</th>
                        <td>{!! number_format(round($BudgetCosts[6],2)) !!}%</td>
                        <td>{!! number_format(round($ActualCosts[6],2)) !!}%</td>
                        <td>{!! number_format(round($ForecastCosts[6],2)) !!}%</td>
                    </tr>
                </tbody>
             </table>
        </div>
    </div>

    <div class="col-xs-4" style="margin-top:2%">
        <div class="table-responsive">          
            <table class="table text-center">
                <tbody>
                    <tr>
                        <th style="font-size: 11px">Target Profit</th>
                        <td>{!! round($TargetProfit,2)  !!}%</td>
                    </tr>
                    <tr>
                        <th style="font-size: 11px">Estimated Completion</th>
                        <td>{!! round($EstimatedCompletion,2) !!}%</td>
                    </tr>
                </tbody>
             </table>
        </div>
    </div>

    <div class="col-xs-12" style="margin-top:2%">
        <div class="table-responsive">          
            <table class="table text-center table-bordered" id="results">
                <thead>
                    <tr>
                        <th style="font-size: 11px"> Employee </th>
                        <th class="text-center" style="font-size: 11px"> Budget Hours </th>
                        <th class="text-center" style="font-size: 11px"> Worked Hours </th>
                        <th class="text-center" style="font-size: 11px"> Forecast Hours </th>
                        <th class="text-center" style="font-size: 11px"> Worked Hours vs Budget Hours </th>
                        <th class="text-center" style="font-size: 11px"> Worked Hours vs Forecast Hours </th>
                        <th class="text-center" style="font-size: 11px"> Budget Staff Cost </th>
                        <th class="text-center" style="font-size: 11px"> Actual Staff Cost </th>
                        <th class="text-center" style="font-size: 11px"> Forecast Staff Cost </th>
                        <th class="text-center" style="font-size: 11px"> total worked+forecast+budget </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($employeehours as $employee)
                    <tr>
                        <td>
                            <h4 align="left">
                                <!--Name-->
                                <small>{!! $employee[1] !!}</small>
                            </h4>
                        </td>
                        
                        <td>
                            <h4>
                                <!--Budget Hours-->
                                <small>{!! number_format(round($employee[2])) !!}</small>
                            </h4>
                        </td>
                        
                        <td>
                            <h4>
                                <!--Worked Hours-->
                                <small>{!! number_format(round($employee[4])) !!}</small>
                            </h4>
                        </td>
                        
                        <td>
                            <h4>
                                <!--Forecast Hours-->
                                <small> {!! number_format(round($employee[3])) !!}</small>
                            </h4>
                        </td>
                        
                        @if ($employee[4] - $employee[2] < 0)
                            <td style="background:#FFCCCC;">
                        @elseif ($employee[4] - $employee[2] > 0)
                            <td style="background:#CEEEDB;">
                        @else
                            <td style="background:#F0F0F0 ;">
                        @endif
                            <h4>
                                <!--Worked v Budget-->
                                <small>{!! number_format(round($employee[4])) - $employee[2] !!}</small>
                            </h4>
                        </td>
                        
                         @if ($employee[4] - $employee[3] < 0)
                            <td style="background:#FFCCCC;">
                        @elseif ($employee[4] - $employee[3] > 0)
                            <td style="background:#CEEEDB;">
                        @else
                            <td style="background:#F0F0F0;">
                        @endif
                            <h4>
                                <!--Worked v Forecast-->
                                <small>{!! number_format(round($employee[4])) - $employee[3] !!}</small>
                            </h4>
                        </td>
                        
                        <td>
                            <h4>
                                <!--Budget Cost-->
                                <small>£{!! number_format(round($employee[5],2)) !!}</small>
                            </h4>
                        </td>
                        
                        <td>
                            <h4>
                                <!--Actual Cost-->
                                <small>£{!! number_format(round($employee[7],2)) !!}</small>
                            </h4>
                        </td>
                        
                        <td>
                            <h4>
                                <!--Forecast Cost-->
                                <small>£{!!number_format(round($employee[6],2)) !!}</small>
                            </h4>
                        </td>

                        <td>
                            {!! $employee[2] + $employee[3] + $employee[4] !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div id="pageNavPosition"></div>


        </div>
    </div>

@stop

@Section('Footer') Copyright &copy; Impact Research {!! date('Y', strtotime('now')) !!} @Stop

@Section('EndScript')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#results').DataTable({
                "order": [[ 9, "desc" ]],
                "columnDefs": [
                    {
                        'targets': [9],
                        'visible': false,
                        'searchable': false
                    },
                ],
            });

            $('#select2-target').select2();
        });
    </script>
@Stop
