<?php

class ActiviteController  extends BaseController{
	
	public function index($id,$success=NULL,$script='init_activity();'){
		$lieux=[];
		$membres=[];
		$membres_cat=[];
		$cat=[];
		$lieux_cat=[];
		$periodes=[];
		$indics=[];
		$nb_cat_p=0;
		$a=NULL;
		$nb_lieu_p=0;
		if (Session::has('activity'))
			{	
			    $script='show_act_assoc();';
			    $membres = $this->get_membres();
			    $membres_cat = $this->get_membres_depuis_cat();
			    $lieux=$this->get_lieux();
			    $lieux_cat=$this->get_lieux_depuis_cat();
			    $cat=$this->get_cat();
 				$periodes = $this->getPeriodes();
 				$indics = $this->get_indics();
 				$a=DB::table('activites')
					->where('id','=',Crypt::decrypt(Session::get('activity')))
					->get();
			}
			$TousLesLieux = $this->getAllLieux();
			$ToutesLesCategories = $this->getAllCategories();
			$TousLesMembres = $this->getAllMembres();
			$TousLesIndicateurs = $this->getAllIndicateurs();
			

		return View::make('pages.projet.gestionActivites')->with(['id'=>$id,
																  'success'=>$success,
																  'lieux'=>$lieux,
																  'membres'=>$membres,
																  'membres_cat'=>$membres_cat,
																  'lieux_cat'=>$lieux_cat,
																  'script'=>$script,
																  'cat'=>$cat,
																  'j'=>0,
																  'i'=>0,
																  'act_en_cour'=>$a,
																  'periodes'=>$periodes,
																  'TousLesLieux'=>$TousLesLieux,
																  'ToutesLesCategories'=>$ToutesLesCategories,
																  'TousLesMembres'=>$TousLesMembres,
																  'indics'=>$indics,
																  'TousLesIndicateurs'=>$TousLesIndicateurs,
																  'jj'=>0
																  ]);
	}

	public function getAllCategories(){
		$results=DB::table('categories_activite')
				 ->select('id','nom','descriptif')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function getAllIndicateurs(){
		$results=DB::table('indicateurs')
				->select('id','nom','declinaison','domaine','destinataire')
				->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->get();
		return $results;
	}

	public function getAllLieux(){
		$results=DB::table('lieux')
				 ->select('id','nom','adresse','ville','code_postal')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function getAllMembres(){
		$results=DB::table('membres')
				 ->join('lien_projets_membres','lien_projets_membres.membre_id','=','membres.id')
				 ->where('lien_projets_membres.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->select('membres.id as id','membres.nom as nom','membres.prenom as prenom')
				 ->distinct()
				 ->get();
		return $results;
	}

	public function get_membres(){
 		//membres specifiques
		$membres=DB::table('lien_membres_activites')
				->leftJoin('membres','lien_membres_activites.membre_id','=','membres.id')
				->leftJoin('activites','lien_membres_activites.activite_id','=','activites.id')
				->select('membres.nom as nom','membres.prenom as prenom','lien_membres_activites.membre_status_pour_activite as status','lien_membres_activites.created_at as date')
				->where('activites.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('activites.id','=', Crypt::decrypt(Session::get('activity')))
				->distinct()
				->get();
		return $membres;
	}

 	public function get_lieux(){
 		//lieux specifiques
		$lieux=DB::table('lien_lieu_activite')
				->join('lieux','lieux.id','=','lien_lieu_activite.lieu_id')
				->join('activites','activites.id','=','lien_lieu_activite.activite_id')
				->select('lieux.nom as nom','lieux.adresse as adresse','lieux.ville as ville','lieux.code_postal as code_postal','lieux.id as lieu_id')
				->where('activites.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('activites.id','=', Crypt::decrypt(Session::get('activity')))
				->get();

		return $lieux;
	}

	public function get_indics(){
 		//lieux specifiques
		$lieux=DB::table('indicateurs_specifique_activites')
				->join('indicateurs','indicateurs.id','=','indicateurs_specifique_activites.indicateur_id')
				->join('activites','activites.id','=','indicateurs_specifique_activites.activite_id')
				->select('indicateurs.id as id','indicateurs.nom as nom','indicateurs.declinaison as declinaison','indicateurs.domaine as domaine','indicateurs.destinataire as destinataire')
				->where('activites.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('activites.id','=', Crypt::decrypt(Session::get('activity')))
				->get();

		return $lieux;
	}

	public function get_lieux_depuis_cat(){
		$lieux2=DB::table('lien_activite_categories')
				->join('categories_activite','categories_activite.id','=','lien_activite_categories.categorie_id')
				->join('lien_categories_lieux','lien_categories_lieux.categorie_id','=','categories_activite.id')
				->join('lieux','lieux.id','=','lien_categories_lieux.lieux_id')
				->join('activites','activites.id','=','lien_activite_categories.activite_id')
				->select('lieux.nom as nom','lieux.adresse as adresse','lieux.ville as ville','lieux.code_postal as code_postal','lieux.id as lieu_id')
				->where('activites.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('activites.id','=', Crypt::decrypt(Session::get('activity')))
				->distinct()
				->get();
		return $lieux2;
	}

	public function get_membres_depuis_cat(){
		$membres2=DB::table('lien_activite_categories')
				->join('categories_activite','categories_activite.id','=','lien_activite_categories.categorie_id')
				->join('lien_categories_membres','lien_categories_membres.categorie_id','=','categories_activite.id')
				->join('membres','membres.id','=','lien_categories_membres.membre_id')
				->join('activites','activites.id','=','lien_activite_categories.activite_id')
				->select('membres.nom as nom','membres.prenom as prenom','lien_categories_membres.membre_status_pour_future_activite as status','lien_categories_membres.created_at as date')
				->where('activites.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('activites.id','=', Crypt::decrypt(Session::get('activity')))
				->distinct()
				->get();
		return $membres2;
	}

	public function get_cat(){
 		//lieux specifiques
		$results=DB::table('lien_activite_categories')
				->join('categories_activite','categories_activite.id','=','lien_activite_categories.categorie_id')
				->join('activites','activites.id','=','lien_activite_categories.activite_id')
				->select('categories_activite.nom as nom','categories_activite.descriptif as descriptif','categories_activite.id as id')
				->where('categories_activite.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('activites.id','=', Crypt::decrypt(Session::get('activity')))
				->distinct()
				->get();
		return $results;
	}

	public function getPeriodes(){
		$result = DB::table('periodes')
			->where('activite_id','=',Crypt::decrypt(Session::get('activity')))
			->get();
		return $result;
	}

	public function action($id){

		if(Input::get('consulter')){
			return $this->display_page($id);
		}

		if(Input::get('ajout_act')){
			return $this->new_activite($id);
		}

		if(Input::get('retirer_lieu')){
			$all=$this->get_lieux();
			for($i=1;$i<count($all)+1;$i++){
				if(Input::get('check_lieux_act'.$i)==='yes'){
					$cle=$all[$i-1]->lieu_id;
					DB::table('lien_lieu_activite')
						->where('activite_id','=',Crypt::decrypt(Session::get('activity')))
						->where('lieu_id','=',$cle)
						->delete();
				}
			}
			return $this->index($id);
		}
		
		if(Input::get('retirer_cat')){
			$all=$this->get_cat();
			for($i=1;$i<count($all)+1;$i++){
				if(Input::get('check_cats_act'.$i)==='yes'){
					$cle=$all[$i-1]->id;
					DB::table('lien_activite_categories')
						->where('activite_id','=',Crypt::decrypt(Session::get('activity')))
						->where('categorie_id','=',$cle)
						->delete();
				}
			}
			return $this->index($id);
		}

		if(Input::get('supp_act')){
			return $this->delete_act($id,Input::get('nom_supp'));
		}

		if(Input::get('refresh_act')){
			return $this->save_periodes($id);
		}

		if(Input::get('terminer_act')){
			
			Session::forget('activity');
			return $this->index($id);
		}

		$all=$this->get_activites();
		for($i=1;$i<count($all)+1;$i++){
			if(Input::get('editer_'.$i)){
				$cle=$all[$i-1]->id;
				Session::forget('activity');
				Session::put('activity',Crypt::encrypt($cle));
				return $this->index($id,NULL,'show_act_assoc();');
			}
		}

		$per = $this->getPeriodes();

		for($i=1;$i<count($per)+1;$i++){
			if(Input::get('retirer_p_'.$i )){
				$cle=$per[$i-1]->id;
				DB::table('periodes')
					->where('id','=',$cle)
					->delete();
				return $this->index($id,['Successfully deleted !']);
			}
		}

	}

	public function save_periodes($id){

		$n=count(Input::all());
		for($i=1;$i<$n+1;$i++){
			if(Input::get('nom_periode_ajout_'.$i)){

				$dated = Input::get('date_deb_periode_ajout_'.$i);
				$dtd=GestionDate::convertToEngDt($dated);

				$datef = Input::get('date_fin_periode_ajout_'.$i);
				$dtf=GestionDate::convertToEngDt($datef);

				//pas de chauvauchement ou inclusions sur les périodes !
				$pr =  $this->getPeriodes();
				
				$d = $dtd->getTimestamp();
				$f = $dtf->getTimestamp();

				$a=DB::table('activites')
					->where('id','=',Crypt::decrypt(Session::get('activity')))
					->get();

				$d_deb = (new DateTime($a[0]->date_debut))->getTimestamp();
				$d_fin = (new DateTime($a[0]->date_fin))->getTimestamp();

				if($d<$d_deb){
					return Redirect::back()->withInput()->with(['errors'=> ['Problème : la période ('.$i.' en ajout ) a une date de début inférieure à la date de début de l\'activité .'] ]);
				}

				if($f>$d_fin){
					return Redirect::back()->withInput()->with(['errors'=> ['Problème : la période ('.$i.' en ajout ) a une date de début inférieure à la date de début de l\'activité .'] ]);
				}

				Periodes::create([
					'activite_id'=>Crypt::decrypt(Session::get('activity')),
					'nom'=>Input::get('nom_periode_ajout_'.$i),
					'date_debut'=>$dtd->format('Y-m-d'),
					'date_fin'=>$dtf->format('Y-m-d')
					]);

				}
			}
		return $this->index($id,['Saved !']);
	}



	public function display_page($id){

		$all=$this->get_activites();
		
		return View::make('pages.projet.MesActivites')
				->with(['activites' => $all,'id'=>$id]);
		
	}

	public function delete_act($id,$nom){

		$all = DB::table('activites')
				->where('nom','=',$nom)
				->delete();

		return $this->index($id,['Successfully deleted !']);
	}


	public function get_activites(){
		$all = DB::table('activites')
				->select('nom','objectif','date_debut','date_fin','id')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
				->get();
		for($i=0;$i<count($all);$i++){
			$all[$i]->date_debut=(new DateTime($all[$i]->date_debut))->format('j/n/Y');
			$all[$i]->date_fin=(new DateTime($all[$i]->date_fin))->format('j/n/Y');
		}
		
		return $all;
	}


	public function new_activite($id){
		
		$rules=[
		 'nom_ajout'=>'required|unique:activites,nom',
		 'date_deb_ajout'=>'required|date_format:j/n/Y', 
		 'date_fin_ajout'=>'required|date_format:j/n/Y',
		 'objectif_ajout'=>'required'
		];

		$v =Validator::make(Input::all(),$rules);
		if( $v->fails()){ 
			$messages = $v->messages()->all();
			return Redirect::back()->withInput()->with(['errors'=>$messages]);
			}
		else{
			$dated = Input::get('date_deb_ajout');
			$dtd=GestionDate::convertToEngDt($dated);

			$datef = Input::get('date_fin_ajout');
			$dtf=GestionDate::convertToEngDt($datef);

			$date=new DateTime( date("Y-m-d") );

			

			if($dtd->getTimestamp() < $date->getTimestamp() ){
				return Redirect::back()->withInput()->with(['errors'=> ['La date de début de l\'activité doit être supérieure à la date actuelle !'] ]);
			}

			if($dtd->getTimestamp() > $dtf->getTimestamp() ){
				return Redirect::back()->withInput()->with(['errors'=> ['La date de début de l\'activité doit être inférieure à la date de fin !'] ]);
			}

			$cle_a=Activite::create([
				'nom'=> Input::get('nom_ajout'),
				'objectif'=>Input::get('objectif_ajout'),
				'date_debut'=>$dtd->format('Y-m-d'),
				'date_fin'=>$dtf->format('Y-m-d'),
				'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
				]);

			Session::forget('activity');
			Session::put('activity',Crypt::encrypt($cle_a->id));



			return $this->index($id,['Successfully created !'],'show_act_assoc();');
			}
	}

}