function disableEnterKey(e)
{
    
    var key;
     
     if(window.event)
          key = window.event.keyCode;     //IE
     else
          key = e.which;     //firefox

     if(key == 13)
          return false;
      
     if(key == 32)
          return false;
     

}


        function Validation() {
         
            employeecount = $('#EmployeeCount').html();

            TargetProfit = parseInt($('#target1').html().replace(/\s/g, ''));
            EstimatedCompletion = parseInt($('#target2').html());

            if (isNaN(TargetProfit)){
                alert("Target Profit Must Be A Number");
                return false;
            }
            
            if (TargetProfit === null){
                alert("Target Profit Must Not Be Blank");
                return false;
            }

            if (isNaN(EstimatedCompletion)){
                alert("Estimated Completion Must Be A Number");
                return false;
            }

            //Validate inputted Hours, ensure they are all numbers.
            for (i = 1; i <= employeecount; i++){

                BudgetHours = parseInt($('#budget_' + i).html());
                ForecastHours = parseInt($('#forecast_' + i).html());

                if (isNaN(BudgetHours)){
                    alert("Budget Hours Must Be A Number");
                    return false;
                }

                if (isNaN(ForecastHours)){
                    alert("Forecast Hours Must Be A Number");
                    return false;
                }
                
                if (BudgetHours === ""){
                    alert("Budget Hours Must Not Be Blank");
                    return false;
                }
                
                if (ForecastHours === ""){
                    alert("Forecast Hours Must Not Be Blank");
                    return false;
                }                       

            }
            
            $("#SubmitButton").disabled = true;
            
            CreateInputs();
            
        }
        
        function CreateInputs() {
        
            //Get Number of Employees
            employeecount = $('#EmployeeCount').html();

            //Create submission form with all inputs
            for (i = 1; i <= employeecount; i++){

                BudgetHours = $('#budget_' + i).html();
                ForecastHours = $('#forecast_' + i).html();

                BudgetHours = "<input type='hidden' name='budget_" + i + "' value='" + BudgetHours + "'/>";
                ForecastHours = "<input type='hidden' name='forecast_" + i + "' value='" + ForecastHours + "'/>";

                $('#inputs').append(BudgetHours);
                $('#inputs').append(ForecastHours);

            }
            
            //Create form inputs got TP and EC then submit form
            TargetProfit = "<input type='hidden' name='target1' value='" + TargetProfit + "'/>";
            EstimatedCompletion = "<input type='hidden' name='target2' value='" + EstimatedCompletion + "'/>";
            employeecount = "<input type='hidden' name='employeecount' value='" + employeecount + "'/>";

            $('#inputs').append(employeecount);
            $('#inputs').append(TargetProfit);
            $('#inputs').append(EstimatedCompletion);

            $("#inputs").submit();

            }
