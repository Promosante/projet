<?php

class LoginController extends BaseController{
	
	

	public function index(){

		return View::make('pages.divers.login')->with(['err'=>0,'msg'=>'']);
	}

	public function login(){
		$rules=[
		 'login'=>'required',
		 'password'=>'required',
		];

		$v =Validator::make(Input::all(),$rules);
		if( $v->fails()){ 
			$messages = $v->messages()->all();
			$msg = '';
			for($i=0;$i<count($messages);$i++){
				$msg=$msg.$messages[$i].'<br>';
			}
			return View::make('pages.divers.login')->with(['err'=>1,'msg'=> $msg]);
		}
		else{	
				if (Auth::attempt(array('login' => Input::get('login'), 'password' => Input::get('password'))))
				{
    				return Redirect::intended('home');
				}
				else{
					return View::make('pages.divers.login')->with(['err'=>1,'msg'=> 'Login fails !']);
				}
			}
	}
}