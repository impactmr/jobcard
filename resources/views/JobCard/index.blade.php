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
        {!! Form::open(['method' => 'POST','url' => ['jobcard/0']]) !!}
            {!! Form::select('selectedproject', $projectslist, $selectedproject, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
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
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Budget Costs</th>
                    <th class="text-center">Actual (To Date) Costs</th>
                    <th class="text-center">Forecast Costs</th>

                </tr>

                 <tr>
                    <th>Current Value</th>
                    <td>£{!! number_format(round($BudgetCosts[0],2)) !!}</td>
                    <td>£{!! number_format(round($ActualCosts[0],2)) !!}</td>
                    <td>£{!! number_format(round($ForecastCosts[0],2)) !!}</td>
                </tr>

                <tr>
                    <th>Contribution</th>
                    <td>£{!! number_format(round($BudgetCosts[1],2)) !!}</td>
                    <td>£{!! number_format(round($ActualCosts[1],2)) !!}</td>
                    <td>£{!! number_format(round($ForecastCosts[1],2)) !!}</td>
                </tr>

                <tr>
                    <th>Gross Margin %</th>
                    <td>{!! number_format(round($BudgetCosts[2],2)) !!}%</td>
                    <td>{!! number_format(round($ActualCosts[2],2)) !!}%</td>
                    <td>{!! number_format(round($ForecastCosts[2],2)) !!}%</td>
                </tr>

                <tr>
                    <th>Supplier Costs</th>
                    <td>£{!! number_format(round($BudgetCosts[3],2)) !!}</td>
                    <td>£{!! number_format(round($ActualCosts[3],2)) !!}</td>
                    <td>£{!! number_format(round($ForecastCosts[3],2)) !!}</td>
                </tr>

                <tr>
                    <th>Staff Costs</th>
                    <td>£{!! number_format(round($BudgetCosts[4],2)) !!}</td>
                    <td>£{!! number_format(round($ActualCosts[4],2)) !!}</td>
                    <td>£{!! number_format(round($ForecastCosts[4],2)) !!}</td>
                </tr>

                <tr>
                    <th>Net Profit</th>
                    <td>£{!! number_format(round($BudgetCosts[5],2)) !!}</td>
                    <td>£{!! number_format(round($ActualCosts[5],2)) !!}</td>
                    <td>£{!! number_format(round($ForecastCosts[5],2)) !!}</td>
                </tr>

                <tr>
                    <th>Net Profit %</th>
                    <td>{!! number_format(round($BudgetCosts[6],2)) !!}%</td>
                    <td>{!! number_format(round($ActualCosts[6],2)) !!}%</td>
                    <td>{!! number_format(round($ForecastCosts[6],2)) !!}%</td>
                </tr>
             </table>
        </div>
    </div>

    <div class="col-xs-4" style="margin-top:2%">
        <div class="table-responsive">          
            <table class="table text-center">

                <tr>
                    <th>Target Profit</th>
                    <td>{!! round($TargetProfit,2)  !!}%</td>
                </tr>

                <tr>
                    <th>Estimated Completion</th>
                    <td>{!! round($EstimatedCompletion,2) !!}%</td>
                </tr>

             </table>
        </div>
    </div>


    <div class="col-xs-12" style="margin-top:2%">
        <div class="table-responsive">          
            <table class="table text-center table-bordered" id="results">
                
                <thead>
                    <th> Employee </th> <th class="text-center"> Budget Hours </th> 
                    <th class="text-center"> Worked Hours </th>
                    <th class="text-center"> Forecast Hours </th>
                    <th class="text-center"> Worked Hours vs Budget Hours </th>
                    <th class="text-center"> Worked Hours vs Forecast Hours </th>
                    <th class="text-center"> Budget Staff Cost </th>
                    <th class="text-center""> Actual Staff Cost </th>
                    <th class="text-center"> Forecast Staff Cost </th>
                </thead>
                @foreach ($employeehours as $employee)     
                <tbody>
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

                    </tr>
                </tbody>

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
