<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class joblevel extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'joblevel';
        
        /**
	 * The primary key name for this table.
	 *
	 * @var string
	 */
        public function getKeyName(){
            return "job_level";
        }
        
        /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	//protected $fillable = ['first_name', 'last_name'];

}
