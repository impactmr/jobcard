<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\employee;

use Illuminate\Http\Request;

//This controller handles all other pages

class PagesController extends Controller {

	public function index()
	{
		return view('home');
	}
        

}
