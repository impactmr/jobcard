<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class employeejobcode extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employeejobcode';
        
        /**
	 * The primary key name for this table.
	 *
	 * @var string
	 */
        public function getKeyName(){
            return "fk1_employee_code";
        }
        
        
        /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
        
	//protected $fillable = ['first_name', 'last_name'];

}
