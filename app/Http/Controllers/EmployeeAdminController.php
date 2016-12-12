<?php namespace App\Http\Controllers;

use App\employee; //Use employee model
use App\employeejobcode; //Use employeejobcode
use App\jobcode; //Use jobcode
use App\joblevel; //Use joblevel

use App\Http\Controllers\Controller; //reference controllers namespace
use App\Http\Requests\CreateEmployeeRequest; //Validation Class for Creating Employee
use View; //reference view class
use Carbon\Carbon; //reference carbon class (used for Date/time functions)
Use Illuminate\Http\Request;

// This class handles all employee admin, from new employee creation, to updating their details, to removing them from the used list.

class EmployeeAdminController extends Controller {
    
        public function __construct()
        {
            $this->middleware('auth'); //This controller requires authentication i.e. users need to be logged in / NO GUEST ACCESS
        }

	public function Index() //This function is actioned when a request is made to "index" within this controller
	{
            
           return View('EmployeeAdmin.index'); //Display the View named "Index" within the EmployeeAdmin directory and pass all employees data. 
                
        }
        
        Public function create() //This function is actioned when a request is made to "create" within this controller
        {
           
            $joblevels = joblevel::lists('description', 'job_level'); //create a list of all job levels (includes ID)

            return View('EmployeeAdmin.create')->with('joblevels',$joblevels); //Display the View named "create" witihin the employeeadmin directory and pass joblevels list to the view. 
            
        }
        
        public function edit($id) //This function is actioned when a request is made to "edit" within this controller
        {
            $selectedemployee = employee::findorfail($id); //find employee with the specified ID or fail (throw an error)
            $joblevels = joblevel::lists('description', 'job_level'); //create list of all job levels(Includes ID)
            $currentjobcode = employeejobcode::where('fk1_employee_code',"=",$id)->orderby('start_date', 'DESC')->first(); //get current jobcode for the selected employee
            $currentjoblevel = jobcode::find($currentjobcode->fk2_job_code); //store current joblevel of selected employee to this variable
            return view('EmployeeAdmin.edit') 
                    ->with('selectedemployee', $selectedemployee)
                    ->with('joblevels', $joblevels)
                    ->with('currentjoblevel', $currentjoblevel->fk1_job_level);//Display View named "edit" withing the employeeadmin directory and pass joblevels list, selected employee details and current job level.
        }
        
        Public function store(CreateEmployeeRequest $request) //This function is actioned when a post request is made to employeeadmin "create" within this controller
        {   
            $NewEmp = new employee; //Create new employee object
            $NewEmp->first_name = $request->first_name; //assign first name from form input
            $NewEmp->last_name = $request->last_name; //assign last name from form input
            $NewEmp->Save(); //Save Employee
            
            $NewEmpJobCode = new employeejobcode; //Create new  employeejobcode object
            $NewEmpJobCode->fk1_employee_code = $NewEmp->employee_code; //Assign Employee Code
            
            $joblevel = $request->joblevel; //Get JobLevel from form input
            $latestjobcode = jobcode::where('fk1_job_level',"=",$joblevel)->orderby('start_date', 'DESC')->first(); //Get latest jobcode entry for the selected joblevel.
            
            $NewEmpJobCode->fk2_job_code = $latestjobcode->job_code; //Assign Job Code
            $NewEmpJobCode->start_date = Carbon::now(); //Assign Start Date
            $NewEmpJobCode->save(); //Save Job Code

            
            return redirect('employeeadmin/all'); //redirect user to employeeadmin "index" page
            
        }
        
        Public function update($id, CreateEmployeeRequest $request) //This function is actioned when a patch request is made to employeeadmin within this controller
        {
            $UpdateEmp = employee::findorfail($id); //find employee with the specified ID or fail(throw an error)
            $FormFirstName = $request->first_name; //Get first name input from form
            $FormLastName = $request->last_name; //Get last_name input from form 

            //if first name is different update the field
            if($UpdateEmp->first_name != $FormFirstName){
                
                $UpdateEmp->first_name = $FormFirstName;
                $UpdateEmp->save();
            } 
            
            //if last name is different update the field
            if($UpdateEmp->last_name != $FormLastName){
                
                $UpdateEmp->last_name = $FormLastName;
                $UpdateEmp->save();
            } 
 
            //Create New JobCode
            $joblevel = $request->joblevel; //Get JobLevel
            $currentjobcode = employeejobcode::where('fk1_employee_code',"=",$id)->orderby('start_date', 'DESC')->first(); //get current employeejobcode based on id
            $currentjoblevel = jobcode::find($currentjobcode->fk2_job_code); //get currentjoblevel
            
            //If joblevel has changed update (create a new jobcode entry)
            if($joblevel != $currentjoblevel->fk1_job_level){
            
                $NewEmpJobCode = new employeejobcode; //Create new  employeejobcode object
                $NewEmpJobCode->fk1_employee_code = $UpdateEmp->employee_code; //Assign Employee Code
                $latestjobcode = jobcode::where('fk1_job_level',"=",$joblevel)->orderby('start_date', 'DESC')->first(); //Get latest jobcode entry for the selected joblevel.
                $NewEmpJobCode->fk2_job_code = $latestjobcode->job_code; //Assign Job Code
                $NewEmpJobCode->start_date = Carbon::now(); //Assign Start Date
                $NewEmpJobCode->save(); //Save Job Code
            }
            
            return redirect('employeeadmin/all'); //Redirect to employeeadmin index page

        }
        
        
        //This function displays employees and can be filtered by job level 
        Public function getAll(Request $request)
        {
            
            $joblevels = ['0' => 'All'] + joblevel::lists('description', 'job_level'); //create list of all job levels(Includes ID)
            $selectedfilter = $request->input('joblevel');
            
            
            //If Selected Filter is 0 then display all employees
            if($selectedfilter == 0){
                
                //Get all employees and paginate according to limit
                $employees = employee::orderby('created_at', 'ASC')->get();
                
                //Loop through each employee and get their jobcode and joblevel details then build employee array
                foreach($employees as $employee){
                    $currentjobcode = employeejobcode::where('fk1_employee_code',"=",$employee->employee_code)->orderby('start_date', 'DESC')->first();
                    $currentjoblevel = jobcode::find($currentjobcode->fk2_job_code);
                    $joblevel = joblevel::where('job_level','=', $currentjoblevel->fk1_job_level)->first();
                    $currentemployees[] = array($employee->employee_code, $employee->first_name." ".$employee->last_name, $joblevel->description, $currentjobcode->start_date);
                }
            
                //return view for selected employees
                return view('EmployeeAdmin.reports.all') //Display View named "edit" withing the employeeadmin directory and pass joblevels list, selected employee details and current job level.
                    ->with('currentemployees', $currentemployees)
                    ->with('employees', $employees)
                    ->with('joblevels', $joblevels)
                    ->with('selected', $selectedfilter);
            }
            
            //If selected filter is greater than 0 then filter employees by selected job level
            else{
               $selectedjobcode = jobcode::where('fk1_job_level',"=",$selectedfilter)->orderby('start_date', 'DESC')->first(); //get current jobcode for selected job level
               $employees = employeejobcode::distinct()->select('fk1_employee_code')->where('fk2_job_code',"=",$selectedjobcode->job_code)->get();//get employees on selected job code
               
               //Loop through each employee and build array of selected employees
               foreach($employees as $employee){
                   $currentjobcode = employeejobcode::where('fk1_employee_code',"=",$employee->fk1_employee_code)->orderby('start_date', 'DESC')->first();
                    
                        $joblevel = joblevel::where('job_level','=', $selectedjobcode->fk1_job_level)->first();
                        $employeedetails = employee::find($employee->fk1_employee_code);
                        $currentemployees[] = array($employeedetails->employee_code, $employeedetails->first_name." ".$employeedetails->last_name, $joblevel->description, $currentjobcode->start_date);
                    
                }
                
                //return view with filtered data
                return view('EmployeeAdmin.reports.all') //Display View named "edit" withing the employeeadmin directory and pass joblevels list, selected employee details and current job level.
                    ->with('currentemployees', $currentemployees)
                    ->with('joblevels', $joblevels)
                    ->with('selected', $selectedfilter);
            
            }
        }
        
        //This function builds employee history for the selected employee
        public function employeehistory($id){
            
            //get jobcode history for selected employee
            $employeehistory = employeejobcode::where('fk1_employee_code',"=",$id)->orderby('start_date', 'DESC')->get();
            
            //loop through each employee job code and get details for employee array
            foreach($employeehistory as $employeejob){
                
                $currentjoblevel = jobcode::where('job_code',"=",$employeejob->fk2_job_code)->first();
                
                $employeedetails = employee::find($employeejob->fk1_employee_code);
                $joblevel = joblevel::where('job_level','=', $currentjoblevel->fk1_job_level)->first();
                $employeearray[] = array($employeedetails->employee_code, $employeedetails->first_name." ".$employeedetails->last_name, $joblevel->description, $employeejob->start_date);
                
            }
            
            //return employee history view
            return view('EmployeeAdmin.reports.history') //Display View named "edit" withing the employeeadmin directory and pass joblevels list, selected employee details and current job level.
                ->with('employeearray', $employeearray);

        }
}
        
        
         

