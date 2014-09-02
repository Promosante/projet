<?php

class EditProfilController extends BaseController{
	
	public function index(){
		$results = $this->getProfil();
		$date = new DateTime($results[0]->datenaissance);
		$results[0]->datenaissance=$date->format('d/m/Y');
		return View::make('pages.profil.editprofil')->with(['results' => $results]);
	}

	public function getProfil(){
		$results = DB::table('membres')
				->join('users','users.id','=','membres.user_id')
				->select('membres.nom as nom','membres.prenom as prenom','membres.structure as structure','membres.fonction as fonction',
					'membres.date_naissance as datenaissance','membres.adresse as adresse ','membres.codepostal as codepostal','membres.ville as ville',
					'membres.pays as pays','membres.email_membre as email','membres.created_at as created_at','membres.updated_at as updated_at','users.login as login')
				->where('user_id','=',Auth::user()->id)
				->get();
		return $results;
	}

	public function edit(){

		if(Input::get('goedit')){
			$rules=[
			 'nom'=>'required',
			 'prenom'=>'required',
			 'datenaissance'=>'date_format:j/n/Y',
			];
			
			$v =Validator::make(Input::all(),$rules);
			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
			}
			else{

				$date = Input::get('datenaissance');
				if(isset($date)){
					$date = (new DateTime($date))->format('Y-d-m');
				}
				else{
					$date = (new DateTime('01/01/2000'))->format('Y-d-m');
				}
				$param=[
					 'nom'=>Input::get('nom'),
					 'prenom'=>Input::get('prenom'),
					 'structure'=>Input::get('structure'),
					 'fonction'=>Input::get('fonction'),
					 'date_naissance'=>$date,
					 'adresse'=>Input::get('adresse'),
					 'codepostal'=>Input::get('codepostal'),
					 'ville'=>Input::get('ville'),
					 'pays'=>Input::get('pays')
					];

				DB::table('membres')
					->where('user_id','=',Auth::user()->id)
					->update($param);

				return Redirect::to('profil')->with(['success'=> 'Successfully updated !']);
			}
		}

		
	}
}