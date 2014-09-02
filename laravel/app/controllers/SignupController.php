<?php

class SignupController extends BaseController{
	
	public function index(){
		return View::make('pages.divers.signup');
	}

	public function register(){
		
		$rules=[
		 'login'=>'required|unique:users',
		 'email'=>'required|email|unique:users,email_compte',
		 'email_membre'=>'email',
		 'password'=>'required',
		 'passwordVerif'=>'required|same:password',
		 'datenaissance'=>'date_format:j/n/Y',
		 'codepostal'=>'digits:5',
		 'nom'=>'required',
		 'prenom'=>'required'
		];
		
			$v =Validator::make(Input::all(),$rules);
			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{
				
				

				$cp =Input::get('codepostal');
				if(!$cp){$cp = 00000;}
				
				$date_naiss = Input::get('datenaissance');
				if($date_naiss){
					$dt=GestionDate::convertToEngDt($date_naiss);
				}		
				else{
					$dt = new DateTime('01/01/2000');
				}

				$u=User::create([
					'email_compte'=> Input::get('email'),
					'login'=>Input::get('login'),
					'password'=> Hash::make(Input::get('password')),
					'type_compte'=>''
					]);

				Membres::create([
					'user_id'=>$u->id,
					'nom'=>Input::get('nom'),
					'prenom'=>Input::get('prenom'),
					'structure'=>Input::get('structure'),
					'fonction'=>Input::get('fonction'),
					'date_naissance'=>$dt->format('Y-m-d'),
					'adresse'=>Input::get('adresse'),
					'codepostal'=>$cp,
					'ville'=>Input::get('ville'),
					'pays'=>Input::get('pays'),
					'email_membre'=>Input::get('email_membre'),
					]);

				return Redirect::to('home')->with(['success'=> 'Compte créé !']);;
				}
			
		}
	}
