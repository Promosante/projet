<?php

class ShadowMembresCController extends BaseController{


	public function getAllMembres(){
		$results=DB::table('membres')
				 ->join('lien_projets_membres','lien_projets_membres.membre_id','=','membres.id')
				 ->where('lien_projets_membres.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->select('membres.id as id')
				 ->distinct()
				 ->get();
		return $results;
	}

	public function action($id){

			if(Input::get('ajout_membres_enregistres')){
				$results=$this->getAllMembres();
				$n = count($results);
				for($i=1;$i<$n+1;$i++){
					if(Input::get('check_membre_shad_'.$i)==='yes'){
						$cle=$results[$i-1]->id;

						MembresCategories::create([
					 				'categorie_id'=>Crypt::decrypt(Session::get('category')),
					 				'membre_id'=>$cle,
					 				'membre_status_pour_future_activite'=>'a voir'
					 			]);	
					}
				}
				return Redirect::back()->withInput()->with(['success'=>'Successfully added !']);
			}

			if(Input::get('ajout_membre_shad_cat')){
				$rules=[
				'nom_ajout'=>'required',
				'prenom_ajout'=>'required',
				'adresse_ajout'=>'required',
				'ville_ajout'=>'required',
				'cp_ajout'=>'required'
				];

			$v =Validator::make(Input::all(),$rules);

			if( $v->fails()){ 
				$messages = $v->messages()->all();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{
				$qualite=Input::get('qualite_ajout');

				$m=Membres::create([
						'nom'=>Input::get('nom_ajout'),
						'prenom'=>Input::get('prenom_ajout'),
						'adresse'=>Input::get('adresse_ajout'),
						'ville'=>Input::get('ville_ajout'),
						'codepostal'=>Input::get('cp_ajout')
					]);

				$nom_qual ='NC';
				if($qualite=='E'){ $nom_qual='Expert'; }
				if($qualite=='I'){ $nom_qual='Intervenant';}			
				if($qualite=='C'){ $nom_qual='Collaborateur'; }
				if($qualite=='P'){ $nom_qual='Participant'; }

				MembresProjets::create([
						'membre_id'=>$m->id,
						'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
					 ]);

				MembresCategories::create([
						'membre_id'=>$m->id,
						'membre_status_pour_future_activite'=>$nom_qual,
						'categorie_id'=>Crypt::decrypt(Session::get('category'))
						]);

				return Redirect::back()->with(['success'=>'Ajouté !']);
				}
			}

		}


}