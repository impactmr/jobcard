<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class employee extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employee';
        
        /**
	 * The primary key name for this table.
	 *
	 * @var string
	 */
        public function getKeyName(){
            return "employee_code";
        }
        
        /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['first_name', 'last_name'];
        
        

}
