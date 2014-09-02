<?php

class AdminController extends BaseController{
	
	public function index(){
		return View::make('pages.admin.menu');
	}

	public function action(){
		
	}
}