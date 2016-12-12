<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class projectcost extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projectcost';
        
        /**
	 * The primary key name for this table.
	 *
	 * @var string
	 */
        public function getKeyName(){
            return "fk1_project_code";
        }
        
        /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
        protected $fillable = ['fk1_project_code','current_value', 'supplier_costs', 'target_profiit', 'estimated_completion'];
        
}
