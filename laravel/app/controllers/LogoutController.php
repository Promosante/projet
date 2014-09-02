<?php

class LogoutController extends BaseController{
	
	public function index(){
		Auth::logout();
		return Redirect::intended('home');
	}
	
}