<?php namespace App\Http\Controllers;

use App\employee; //Use employee model
use App\employeejobcode; //Use employeejobcode
use App\jobcode; //Use jobcode
use App\joblevel; //Use joblevel

use App\Http\Controllers\Controller; //reference controllers namespace
use App\Http\Requests\CreateJobCodeRequest; //Validation Class for Creating Job Codes
use View; //reference view class
use Carbon\Carbon; //reference carbon class

class JobCodeController extends Controller {

	public function index()
	{
		//
	}

	public function create()
	{
            
            return View('JobCodeAdmin.create'); //Display the View named "create" witihin the employeeadmin directory and pass joblevels list to the view. 
	}

	public function store(CreateJobCodeRequest $request)
	{
            
            $message = '';
            $NewJob = new joblevel; //Create new employee object
            $NewJobName = $request->role_name;
            $NewJob->description = $NewJobName;
            $NewJob->save();
            $message .= 'New Job Created';
            
            $NewRate = $request->rate;
            
            $NewJobCode = new jobcode;
            $NewJobCode->fk1_job_level = $NewJob->job_level;
            $NewJobCode->rate = $NewRate;
            $NewJobCode->start_date = Carbon::now();
            $NewJobCode->save();
            $message .= ', New Job Code Created';
           
            if($message == ''){
                $message = 'No Changes Were Made to the Database.';
            }
            
            return redirect('jobcodeadmin/show')->with('message',$message); //redirect user to employeeadmin "index" page
	}

	public function show($id)
	{
            $joblevels = joblevel::orderby('created_at','ASC')->get(); //get all employees and store in $employees variable
            return view::make('JobCodeAdmin.show')->with('joblevels',$joblevels); //Display the View named "show" within the employeeadmin directory and pass selected employee data.
	}

	public function edit($id)
	{
	    $selectedjob = joblevel::findorfail($id); //find employee with the specified ID or fail (throw an error)
            $currentjobcode = jobcode::where('fk1_job_level',"=",$selectedjob->job_level)->orderby('start_date', 'DESC')->first(); //get current jobcode for the selected employee
            return view('JobCodeAdmin.edit') //Display View named "edit" withing the employeeadmin directory and pass joblevels list, selected employee details and current job level.
                    ->with('selectedjob', $selectedjob)
                    ->with('currentjobcode', $currentjobcode);
	}

	public function update($id, CreateJobCodeRequest $request)
	{
	    $currentjobcode = jobcode::where('fk1_job_level',"=",$id)->orderby('start_date', 'DESC')->first(); //get current jobcode for the selected employee
            $selectedjob = joblevel::find($id);
            $newrate = $request->rate;
            $newname = $request->role_name;
            $message = '';
            
            if($newname != $selectedjob->description){
                $selectedjob->description = $newname;
                $selectedjob->save();
                $message = 'Job Role Name Updated';
            }
            
            if($newrate != $currentjobcode->rate){
                
                $NewJobCode = new jobcode;
                $NewJobCode->fk1_job_level = $id;
                $NewJobCode->rate = $newrate;
                $NewJobCode->start_date = Carbon::now();
                $NewJobCode->save();   
                
                $message .= 'New Job Code Created';

                $employees = employee::all();

                foreach($employees as $employee){

                    $employeejobcode = employeejobcode::where('fk1_employee_code',"=",$employee->employee_code)->orderby('start_date', 'DESC')->first();

                    if($employeejobcode->fk3_job_level == $id){

                        $NewEmpJobCode = new employeejobcode; //Create new  employeejobcode object
                        $NewEmpJobCode->fk1_employee_code = $employee->employee_code; //Assign Employee Code
                        $NewEmpJobCode->fk2_job_code = $NewJobCode->job_code; //Assign Job Code
                        $NewEmpJobCode->fk3_job_level = $id; //Assign Job Level
                        $NewEmpJobCode->start_date = Carbon::now(); //Assign Start Date
                        $NewEmpJobCode->save(); //Save Job Code
                    }

                }
                $message .=', Employee Roles Updated';
            }
            
            if($message == ''){
                $message = "No Changes Were Made to The Database";
            }
           
            return redirect('jobcodeadmin/show')->with('message', $message); //redirect user to employeeadmin "index" page
            
	}

	public function jobhistory($id){
                
            $jobhistory = jobcode::where('fk1_job_Level',"=",$id)->orderby('start_date', 'DESC')->get();

            foreach($jobhistory as $job){
                $jobdetails = joblevel::find($job->fk1_job_level);
                $jobarray[] = array($job->fk1_job_level,$job->job_code, $jobdetails->description, $job->rate, $job->start_date);
            }

            return view('JobCodeAdmin.reports.history') //Display View named "edit" withing the employeeadmin directory and pass joblevels list, selected employee details and current job level.
                ->with('jobarray', $jobarray);
            
        }

}
