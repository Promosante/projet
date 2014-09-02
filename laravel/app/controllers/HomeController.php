<?php

class HomeController extends BaseController{
	
	public function index(){
		
		$data=[];

		if(Auth::user()){
			$data = DB::table('membres')
				->select('nom','prenom')
				->where('user_id','=',Auth::user()->id)
				->get();

			
		}

		return View::make('home')->with(['data'=>$data]);
	}

}