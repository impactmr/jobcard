<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateEmployeeRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true; //anyone can make the request (switch to false to secure and specify users)
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
                    'first_name' => 'required|min:2',
                    'last_name' => 'required|min:2',
                    'joblevel' => 'required'
		];
	}

}
