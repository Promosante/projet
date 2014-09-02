<?php

class ProfilController extends BaseController{
	
	public function index(){
		$results = $this->getProfil();
		$date = new DateTime($results[0]->datenaissance);
		$results[0]->datenaissance=$date->format('d/m/Y');
		return View::make('pages.profil.profil')->with(['results' => $results]);
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

	public function goToEdit(){
		if(Input::get('edit')){
			return Redirect::to('editprofil');
		}
	}

	public function display_profil($id){
		$email = Auth::user()->email;
		$results = DB::select('select * from users where email = ?', array($email));
		$date = new DateTime($results[0]->datenaissance);
		$results[0]->datenaissance=$date->format('d/m/Y');
		return View::make('pages.profil.profil')->with(['results' => $results]);
	}
}