<?php namespace App\Http\Controllers;

use DB;
use Input;
use App\employee;
use App\employeejobcode;
use App\jobcode;
use App\timesheethours;
use App\project;
use App\projectcost;
use App\projecthours;
use Illuminate\Http\Request;

class JobCardController extends Controller {
        
        //This function gathers all the data for the jobcard and passes it to the view JobCard.Index
        Public function getAll($id, Request $request)
        {
           
//          Get Project ID  
            if($id == 0){
                $id = Input::get('selectedproject');
            }
            
            
            $selectedproject = $id; //$request->input('selectedproject') ?: 1; //Get Code for Selected Project from user input if not set then set to 1
            $project = project::find($selectedproject); //Find the selected project
            $projectmanager = employee::find($project->project_manager);
            $projectcost = projectcost::where('fk1_project_code',"=",$selectedproject)->first(); //Get the budget and forecast costs from the projectcosts table 
            $employees = employee::orderBy('employee_code','ASC')->get(); //Get all employees
            $emphours = timesheethours::where('fk2_project_code','=',$selectedproject)->get(); //Get worked hours for the project from the timesheethours table
            //$projectslist = project::lists('name', 'project_code'); //Get the list of available projects
            
            $projectslist = project::select('project_code', DB::raw('CONCAT(project_code, " ", name) AS project_name'))
                ->orderBy('project_code')
                ->lists('project_name', 'project_code');
            
            //Build Project Type String i.e. adhoc/qual/quant
            $projecttype = ""; //Initialise variable
            if($project->adhoc == 1){ $projecttype .= "| Adhoc"; } //Add "Adhoc" to string if set to 1 in project table
            if($project->quant == 1){ $projecttype .= "| Quant"; } //Add "Quant" to string if set to 1 in project table
            if($project->qual == 1){ $projecttype .= "| Qual"; } //Add "Qual" to string if set to 1 in project table
            if($project->time_only == 1){ $projecttype .= "| Time Only"; }//Add "Time Only" to string if set to 1 in project table
            if($project->tracking == 1){ $projecttype .= "| Tracking"; }//Add "Tracking" to string if set to 1 in project table

            $BudgetStaffCost = 0; //Initialise variable
            $ActualStaffCost = 0; //Initialise variable
            $ForecastStaffCost = 0; //Initialise variable
            
         
            //Loop through each employees and get all data required for the jobcard
            foreach($employees as $employee){
                
                $employeeworkedhours = 0;
                $TotalActual = 0;

                $projecthours = projecthours::where('fk1_employee_code',"=",$employee->employee_code)
                        ->where('fk2_project_code','=',$selectedproject)
                        ->first(); //Get budget and forecast hours from the projecthours table for the current employee
                
                               
                $hoursworked = timesheethours::where('fk2_project_code','=',$selectedproject)
                        ->where('fk1_employee_code','=',$employee->employee_code)
                        ->get(); //get the sum of worked hours from the timesheet hours table for the current employee
                
                
                $EmployeeProjectHours = projecthours::where('fk1_employee_code',"=",$employee->employee_code)
                        ->where('fk2_project_code','=',$selectedproject)
                        ->get();
                
                foreach($EmployeeProjectHours as $EmployeeProjectHour){
                    
                    $employeejobcodes = employeejobcode::where('fk1_employee_code',"=",$EmployeeProjectHour->fk1_employee_code)
                            ->whereraw("DATE(start_date) <= '$EmployeeProjectHour->created_at'")
                            ->orderby('start_date', 'DESC')
                            ->first(); //Get latest employee jobcode on or before the input date for the hours entry
                    $employeejobcode = jobcode::find($employeejobcodes->fk2_job_code); //Get jobcode info
                    
                    $EmployeeForecast = $EmployeeProjectHour->forecast_hours * ($employeejobcode->rate / 7);
                    $EmployeeBudget = $EmployeeProjectHour->budget_hours * ($employeejobcode->rate / 7);
                }
                
                
                
                //loop through each timesheet entry for the project and calculate cost based on dated jobcodes
                foreach($hoursworked as $hours){

                    $employeejobcodes = employeejobcode::where('fk1_employee_code',"=",$hours->fk1_employee_code)
                            ->whereraw("DATE(start_date) <= '$hours->input_date'")
                            ->orderby('start_date', 'DESC')
                            ->first(); //Get latest employee jobcode on or before the input date for the hours entry
                    $employeejobcode = jobcode::find($employeejobcodes->fk2_job_code); //Get jobcode info

                    $TotalActual += $hours->worked_hours * ($employeejobcode->rate / 7); //Multiply hours worked by current employee's jobrate
                    $ActualStaffCost += $hours->worked_hours * ($employeejobcode->rate / 7);
                    $employeeworkedhours += $hours->worked_hours;   
                
                }
                
             
               //if employee has no forecast or budget hours then add this array entry for current employee
                if(empty($projecthours)){
                    $emparray[] = array(
                        $employee->employee_code, //Store Employee Code in Position 0
                        $employee->first_name." ".$employee->last_name, //Store Employee Name in Position 1
                        0, //Set budget hours to 0 in position 2
                        0, //Set forecast hours to 0 in position 3
                        $employeeworkedhours, //Store hours worked in Position 4
                        0, //Store Budget Cost in Position 5
                        0,//Store Forecast Cost in Position 6
                        $TotalActual);//Store Actual Cost in Position 7
                }
                
                
                //if employee has forecast or budget hours then add this array entry for current employee
                else{ 
                    $emparray[] = array(
                        $employee->employee_code, //Store Employee Code in Position 0
                        $employee->first_name." ".$employee->last_name, //Store Employee Name in Position 1
                        $projecthours->budget_hours, //Set budget hours to budget hours in position 2
                        $projecthours->forecast_hours, //Set forecast hours to forecast hours in position 3
                        $employeeworkedhours, //Store hours worked in Position 4
                        $EmployeeBudget, //Store Budget Cost in Position 5
                        $EmployeeForecast,//Store Forecast Cost in Position 6
                        $TotalActual);//Store Actual Cost in Position 7

                    $BudgetStaffCost += $EmployeeBudget; //total budget staff cost by multiplying budget hours by employees job rate
                    $ForecastStaffCost += $EmployeeForecast;
            }}
            
            

            //if project has a project cost entry in projectcost table then calculate the following costs
            if(!empty($projectcost)){
                
                
                $EstimatedCompletion = $projectcost->estimated_completion; //Set estimated completion
                $TargetProfit = $projectcost->target_profit; //Set target profit
                $CurrentValue = $projectcost->current_value; //Set Current Value
                $ActualValue = $CurrentValue * $EstimatedCompletion; //Calculate Actual Value ( Current Value multiplied by Estimated Completion)
                
                If($ActualValue == 0){
                $ActualValue = 1;}
                
                $SupplierCost = $projectcost->supplier_costs; //Set Supplier Costs
                $ActualSupplierCost = $SupplierCost * $EstimatedCompletion; //Calculate Actual Supplier Costs ( Supplier Costs multiplied by Estimated Completion)
                $Contribution = $CurrentValue - $SupplierCost; //Calculate Contribution (Current Value - Supplier Costs)
                $ActualContribution = $ActualValue - $ActualSupplierCost; //Calculate Actual Contribution (Actual Value - Actual Supplier Costs)
                if($CurrentValue > 0){
                $GrossMargin = $Contribution / $CurrentValue; //Calculate Gross Margin (Contribution - Current Value)
                $ActualGrossMargin = $ActualContribution / $ActualValue; //Calculate Actual Gross Margin (Actual Contribution - Actual Value)
                $Netprofit = $CurrentValue - $SupplierCost - $BudgetStaffCost; //Calculate Net profit (current value - supplier cost - budget staff costs)
                $NetProfitPercent = $Netprofit / $CurrentValue; //Calculate Net Profit Percent ( Netprofit / Current Value )
                $ActualNetprofit = $ActualValue - $ActualSupplierCost - $ActualStaffCost; //Calculate Actual net profit (Actual value - Actual supplier cost - Actual staff costs)
                $ActualNetProfitPercent = $ActualNetprofit / $ActualValue ; //Calculate Actual Net Profit Percent ( Actual Netprofit / Actual Value )
                $ForecastNetprofit = $CurrentValue - $SupplierCost - $ForecastStaffCost; //alculate forecast net profit (current value - supplier cost - forecast staff costs)
                $ForecastNetProfitPercent = $ForecastNetprofit / $CurrentValue; //Calculate Forecast Net Profit Percent ( Actual Netprofit / Actual Value )
                }
        
                else{
                $GrossMargin = 0; //Calculate Gross Margin (Contribution - Current Value)
                $ActualGrossMargin = 0; //Calculate Actual Gross Margin (Actual Contribution - Actual Value)
                $Netprofit = 0; //Calculate Net profit (current value - supplier cost - budget staff costs)
                $NetProfitPercent = 0; //Calculate Net Profit Percent ( Netprofit / Current Value )
                $ActualNetprofit = 0; //Calculate Actual net profit (Actual value - Actual supplier cost - Actual staff costs)
                $ActualNetProfitPercent = 0; //Calculate Actual Net Profit Percent ( Actual Netprofit / Actual Value )
                $ForecastNetprofit = 0; //alculate forecast net profit (current value - supplier cost - forecast staff costs)
                $ForecastNetProfitPercent = 0; 
                }
                    
                
                
                
                //Build Budget Costs Array
                $BudgetCosts = array( 
                    $CurrentValue, //Store Current Value in Position 0
                    $Contribution, //Store Contribution in Position 1
                    round($GrossMargin,2) * 100, //Store Gross Margin (Round to 2 decimal places and multiply by 100) in Position 2
                    $SupplierCost, //Store Supplier Costs in Position 3
                    $BudgetStaffCost, //Store Budget Staff Cost in Position 4
                    $Netprofit,//Store Net Profit in Position 5
                    round($NetProfitPercent ,2) * 100 //Store Net Profit Percentage (Round to 2 decimal places and multiply by 100) in Position 6

                );
                
                //Build Forecast Costs Array
                 $ForecastCosts = array( 
                    $CurrentValue, //Store Forecast Current Value in Position 0
                    $Contribution, //Store Forecast Contribution in Position 1
                    round($GrossMargin,2) * 100, //Store Forecast Gross Margin (Round to 2 decimal places and multiply by 100) in Position 2
                    $SupplierCost, //Store Forecast Supplier Costs in Position 3
                    $ForecastStaffCost,//Store Forecast Staff Cost in Position 4
                    $ForecastNetprofit, //Store Forecast Net Profit in Position 5
                    round($ForecastNetProfitPercent,2) * 100 //Store Forecast Net Profit Percentage (Round to 2 decimal places and multiply by 100) in Position 6           
                );
                 
                //Build Actual Costs Array
                $ActualCosts = array( 
                    $ActualValue, //Store Actual Current Value in Position 0
                    $ActualContribution, //Store Actual Contribution in Position 1
                    round($ActualGrossMargin,2) * 100, //Store Actual Gross Margin (Round to 2 decimal places and multiply by 100) in Position 2
                    $ActualSupplierCost, //Store Actual Supplier Costs in Position 3
                    $ActualStaffCost, //Store Actual  Budget Staff Cost in Position 4
                    $ActualNetprofit, //Store Actual Net Profit in Position 5
                    round($ActualNetProfitPercent,2) * 100 //Store Actual Net Profit Percentage (Round to 2 decimal places and multiply by 100) in Position 6              
                ); 
            }  

                
//Display the index view within the jobcard directory
		return view ('JobCard.index')
                    ->with('projectslist',$projectslist) //Pass Project List to view
                    ->with('projecttype', $projecttype) //Pass Project Type to view
                    ->with('projectmanager', $projectmanager)
                    ->with('project', $project) //Pass Project to View
                    ->with('employeehours', $emparray) //Pass Emparray to view as employeehours
                    ->with('selectedproject',$selectedproject) //Pass Selected project to view
                    ->with('BudgetCosts', $BudgetCosts) //Pass Budget Costs to View
                    ->with('ActualCosts', $ActualCosts) //Pass Actual Costs to View
                    ->with('ForecastCosts', $ForecastCosts) //Pass Forecast Costs to View
                    ->with('TargetProfit', $TargetProfit * 100) //Pass Target Profit to View
                    ->with('EstimatedCompletion', $EstimatedCompletion * 100); //Pass Estimated Completion to View

        } 
        
        //This function gathers all data required for the edit mode of the jobcard and passes it to jobcard.edit
        Public function edit($id)
        {
            $selectedproject = $id ?: 1; //Get Code for Selected Project from user input if not set then set to 1
            $project = project::find($selectedproject); //Find the selected project
            $projectmanager = employee::find($project->project_manager); //Get the project manager details from the employee table
            $projectcost = projectcost::where('fk1_project_code',"=",$selectedproject)->first(); //Get the budget and forecast costs from the projectcosts table 
            $employees = employee::orderBy('employee_code','ASC')->get(); //Get all employees
            
            $EstimatedCompletion = $projectcost->estimated_completion; //Set estimated completion
            $TargetProfit = $projectcost->target_profit; //Set target profit

            //Build Project Type String i.e. adhoc/qual/quant
            $projecttype = ""; //Initialise variable
            if($project->adhoc == 1){ $projecttype .= "| Adhoc"; } //Add "Adhoc" to string if set to 1 in project table
            if($project->quant == 1){ $projecttype .= "| Quant"; } //Add "Quant" to string if set to 1 in project table
            if($project->qual == 1){ $projecttype .= "| Qual"; } //Add "Qual" to string if set to 1 in project table
            if($project->time_only == 1){ $projecttype .= "| Time Only"; }//Add "Time Only" to string if set to 1 in project table
            if($project->tracking == 1){ $projecttype .= "| Tracking"; }//Add "Tracking" to string if set to 1 in project table

         
            //Loop through each employees and get all data required for the jobcard
            foreach($employees as $employee){

                $projecthours = projecthours::where('fk1_employee_code',"=",$employee->employee_code)
                        ->where('fk2_project_code','=',$selectedproject)
                        ->first(); //Get budget and forecast hours from the projecthours table for the current employee in loop
                
                
                $hoursworked = timesheethours::where('fk2_project_code','=',$selectedproject)
                        ->where('fk1_employee_code','=',$employee->employee_code)
                        ->sum('worked_hours'); //get the sum of worked hours from the timesheet hours table for the current employee
                
                //if employee has no forecast or budget hours then add this array entry for current employee
                if(empty($projecthours)){
                    $emparray[] = array(
                        $employee->employee_code, //Store Employee Code in Position 0
                        $employee->first_name." ".$employee->last_name, //Store Employee Name in Position 1
                        0, //Set budget hours to 0 in position 2
                        0, //Set forecast hours to 0 in position 3
                        $hoursworked); //Store hours worked in Position 4
                }
                
                //if employee has forecast or budget hours then add this array entry for current employee
                else{ 
                    $emparray[] = array(
                        $employee->employee_code, //Store Employee Code in Position 0
                        $employee->first_name." ".$employee->last_name, //Store Employee Name in Position 1
                        $projecthours->budget_hours, //Set budget hours to budget hours in position 2
                        $projecthours->forecast_hours, //Set forecast hours to forecast hours in position 3
                        $hoursworked); //Store hours worked in Position 4

                }}
            
            
            //Display the edit view within the jobcard directory
            return view ('JobCard.edit')
                ->with('projecttype', $projecttype) //Pass Project Type to view
                ->with('project', $project) //Pass Project to View
                ->with('projectmanager', $projectmanager) //Pass Project Manager details to view
                ->with('employeehours', $emparray) //Pass Emparray to view as employeehours
                ->with('employeecount', sizeof($emparray)) //Pass number of employees to view
                ->with('TargetProfit', $TargetProfit * 100) //Pass Target Profit to View
                ->with('EstimatedCompletion', $EstimatedCompletion * 100); //Pass Estimated Completion to View
            

            
        }
        
        //This function updates the database after edits are made
        public function update(Request $request){
            
            $ProjectID = $request->ProjectID; //Get the project ID for the selected project
            $totalemployees = $request->employeecount; //Get number of employees
            
            $targetprofit = $request->input('target1'); //Get target profit from user input
            $EstComp = $request->input('target2'); //get Estimated Completion from user input
            
            $targetprofit = $targetprofit / 100; //Divide user input by 100 to get decimal
            $EstComp = $EstComp / 100; //Divide user input by 100 to get deimal 
            
            $projectcosts = projectcost::find($ProjectID); //get project costs entry for selected project
            
            $projectcosts->target_profit = $targetprofit; //update target profit
            $projectcosts->estimated_completion = $EstComp; //update estimated completion
            $projectcosts->save(); //save updates
            
            //Loop through each employee and update their hours in the project hours table
            for ($i = 1;$i <= $totalemployees; $i++){

                $budgethours = $request->input('budget_'.$i); //Get inputted budget hours for current employee
                $forecasthours = $request->input('forecast_'.$i); //Get forecast hours for current employee

                $projecthours = projecthours::where('fk1_employee_code',"=",$i)
                        ->where('fk2_project_code','=',$ProjectID)
                        ->first(); //Get budget and forecast hours from the projecthours table for the current employee
                
                //if no record exits for current employee within the selected project in the project hours table then create new entry
                if(empty($projecthours)){
                    
                    $newprojecthours = new projecthours; //Create new project hours entry
                    $newprojecthours->fk1_employee_code = $i; //Add employee code
                    $newprojecthours->fk2_project_code = $ProjectID; //Add Selected Project
                    $newprojecthours->budget_hours = $budgethours; //Add Budget Hours
                    $newprojecthours->forecast_hours = $forecasthours; //Add Forecast Hours
                    $newprojecthours->save(); //Save Updates to the database
                    
                }
                //If a record already exists then update hours
               else{
                    $projecthours->budget_hours = $budgethours; //Update budget hours for current employee
                    $projecthours->forecast_hours = $forecasthours; //update forecasr hours for current employee
                    $projecthours->save(); //save updated hours for current employee
                    
               }         
                
            }
            
            return redirect('jobcard/'.$ProjectID); //Redirect to jobcard home page for the selected project
            
        }
}