<?php

class CategorieActiviteController  extends BaseController{
	


	public function index($id,$script='init_categorie();',$success=NULL,$p_max_lieu=0){	
		
		$lieux=[];
		$outils=[];
		$indics=[];
		$membres=[];

		if (Session::has('category'))
			{	
			    $script='show_cat_assoc();';

			    $lieux=$this->get_lieux();
			    $outils = $this->get_outils();
			    $indics = $this->get_indics();
			    $membres = $this->get_membres();
				$p_max_lieu = ceil(count($lieux)/5);
			}

			$TousLesLieux=$this->getAllLieux(); 
			$TousLesOutils=$this->getAllOutils();
			$TousLesIndicateurs=$this->getAllIndicateurs();
			$TousLesMembres=$this->getAllMembres();

		return View::make('pages.projet.gestionCategorie')->with(['id'=>$id,'success'=>$success,
																'lieux'=>$lieux,
																'outils'=>$outils,
																'indics'=>$indics,
																'lieu_max_p'=>$p_max_lieu,
																'TousLesLieux'=>$TousLesLieux,
																'TousLesOutils'=>$TousLesOutils,
																'TousLesIndicateurs'=>$TousLesIndicateurs,
																'TousLesMembres'=>$TousLesMembres,
																'script'=>$script,
																'membres'=>$membres,
																'i'=>0,'j'=>0,'k'=>0,'l'=>0,'jj'=>0,
																'll'=>0]);
	} 
	
	public function getAllLieux(){
		$results=DB::table('lieux')->select('id','nom','adresse','ville','code_postal')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function getAllOutils(){
		$results=DB::table('outils')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function getAllMembres(){
		$results=DB::table('membres')
				 ->join('lien_projets_membres','lien_projets_membres.membre_id','=','membres.id')
				 ->where('lien_projets_membres.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->distinct()
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

	public function get_lieux(){

		$lieux=DB::table('lien_categories_lieux')
				->join('lieux','lieux.id','=','lien_categories_lieux.lieux_id')
				->join('categories_activite','categories_activite.id','=','lien_categories_lieux.categorie_id')
				->select('lieux.nom as nom','lieux.adresse as adresse','lieux.ville as ville','lieux.code_postal as code_postal','lieux.id as lieu_id')
				->where('categories_activite.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('categories_activite.id','=', Crypt::decrypt(Session::get('category')))
				->get();
		return $lieux;
	}

	public function get_indics(){

		$indics=DB::table('lien_categories_indicateurs')
				->join('indicateurs','indicateurs.id','=','lien_categories_indicateurs.indicateur_id')
				->join('categories_activite','categories_activite.id','=','lien_categories_indicateurs.categorie_id')
				->select('indicateurs.nom as nom','indicateurs.declinaison as declinaison','indicateurs.domaine as domaine')
				->where('categories_activite.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('categories_activite.id','=', Crypt::decrypt(Session::get('category')))
				->get();
		return $indics;
	}

	public function get_membres(){

		$results=DB::table('lien_categories_membres')
				 ->join('membres','lien_categories_membres.membre_id','=','membres.id')
				 ->where('lien_categories_membres.categorie_id','=', Crypt::decrypt(Session::get('category')))
				 ->select('membres.nom as nom','membres.prenom as prenom','membres.adresse as adresse','membres.ville as ville','lien_categories_membres.membre_status_pour_future_activite as status')
				 ->distinct()
				 ->get();
		return $results;
	}

	public function get_outils(){

		$outils=DB::table('lien_categories_outils')
				->join('outils','outils.id','=','lien_categories_outils.outil_id')
				->join('categories_activite','categories_activite.id','=','lien_categories_outils.categorie_id')
				->select('outils.nom as nom','outils.id as id')
				->where('categories_activite.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->where('categories_activite.id','=', Crypt::decrypt(Session::get('category')))
				->get();
		return $outils;
	}

	public function action($id){

		if(Input::get('ajout_categorie')){
			return $this->creer_cat($id);
		}

		if(Input::get('retirer_lieu')){

			$lieux = $this->get_lieux();
			$n = count($lieux);
			for($i=1;$i<$n+1;$i++){
				if(Input::get('check_lieu_'.$i)==='yes'){
					$cle = $lieux[$i-1]->lieu_id;
					DB::table('lien_categories_lieux')
						->where('lieux_id','=',$cle)
						->where('categorie_id','=',Crypt::decrypt(Session::get('category')))
						->delete();
				}
			}
			return $this->index($id);
		}
		
		if(Input::get('supp_outils')){

			$outils = $this->get_outils();
			$n = count($outils);
			for($i=1;$i<$n+1;$i++){
				if(Input::get('check_outils_'.$i)==='yes'){
					$cle = $outils[$i-1]->id;
					DB::table('lien_categories_outils')
						->where('outil_id','=',$cle)
						->where('categorie_id','=',Crypt::decrypt(Session::get('category')))
						->delete();
				}
			}
			return $this->index($id);
		}

		if(Input::get('terminer')){
			Session::forget('category');
			return $this->index($id);
		}

		
		if(Input::get('consulter')){
			return $this->show_categorie($id);
		}

		if(Input::get('supp_cat')){

			$rules=[
		 	'nom_supp'=>'required|exists:categories_activite,nom',
			];

			$v =Validator::make(Input::all(),$rules);
			if( $v->fails()){
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{
				$categorie=DB::table('categories_activite')
						->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
						->where('nom','=',Input::get('nom_supp'))
						->get();
				if(Session::has('category')){
					if($categorie[0]->id == Crypt::decrypt(Session::get('category')) ){
						Session::forget('category');
						DB::table('categories_activite')
							->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
							->where('nom','=',Input::get('nom_supp'))
							->delete();
						return $this->index($id,'init_categorie();','Successfully deleted !');
					}
					else{	DB::table('categories_activite')
								->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
								->where('nom','=',Input::get('nom_supp'))
								->delete();
						return $this->index($id,'show_cat_assoc();','Successfully deleted !');
					}
				}
				else{
					DB::table('categories_activite')
						->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
						->where('nom','=',Input::get('nom_supp'))
						->delete();
					return $this->index($id,'show_cat_assoc();','Successfully deleted !');
				}
			}
		}
	$categories=DB::table('categories_activite')
					->where('categories_activite.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
					->get();

	for($i=1;$i<count($categories)+1;$i++){
		if(Input::get('editer_'.$i)){
			Session::forget('category');
			Session::put('category',Crypt::encrypt($categories[$i-1]->id));
			return $this->index($id);
		}
	}

}

	public function show_categorie($id,$success=NULL,$p_categorie=1,$p_max_categorie=0){	

		$categories=DB::table('categories_activite')
					->where('categories_activite.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
					->get();

		$lieux_assoc=[];
		$q=0;
		foreach($categories as $cat){
			$q++;
			$lieux_tmp=DB::table('lieux')
					->join('lien_categories_lieux','lien_categories_lieux.lieux_id','=','lieux.id')
					->where('lien_categories_lieux.categorie_id','=',$cat->id)
					->get();
			$lieux_assoc[$q]=$lieux_tmp;
		}	
		return View::make('pages.projet.MesCategories')
					->with(['id'=>$id,
							'cat'=>$categories,'i'=>0,'lieux_assoc'=>$lieux_assoc]);
	} 

	public function creer_cat($id){
		$rules=[
		 'nom_ajout_cat'=>'required',
		 'description_ajout'=>'required'
		];

		$v =Validator::make(Input::all(),$rules);
		if( $v->fails()){ 
			$messages = $v->messages()->all();
			return Redirect::back()->withInput()->with(['errors'=>$messages]);
			}
		else{
			
			$cle_c=Categorie::create([
				'projet_id'=> Crypt::decrypt(Session::get('hash_id_project')),
				'nom'=> Input::get('nom_ajout_cat'),
				'descriptif'=> Input::get('description_ajout')
				]);

			$script = 'show_cat_assoc();';

			Session::forget('category');
			Session::put('category',Crypt::encrypt($cle_c->id));
			return $this->index($id,$script,'successfully created !');
			}
	}

	
}