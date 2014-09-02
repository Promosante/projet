<?php

class GestionExpertiseController extends BaseController{
	
	public function index($id,$success=NULL){

		$categories_dispo = $this->get_categories();
		$les_activites = $this->get_activites();
		$les_experts = $this->get_experts();
		
		$expertises = $this->get_expertises();
		$experts_associes = $this->get_experts_prevu_par_exp();
		$periodes_associees=$this->get_periodes_definies();

		return View::make('pages.projet.gestionExpertise')->with([
										'id'=>$id,
										'categories'=>$categories_dispo,
										'les_activites'=>$les_activites,
										'les_experts'=>$les_experts,
										'success'=>$success,
										'expertises'=>$expertises,
										'experts_associes'=>$experts_associes,
										'periodes_associees'=>$periodes_associees
										]);
	}

	public function action($id){
		if(Input::get('terminer_exp')){
			$niveau='';
			$periode='';
			if(Input::get('check_tout_le_projo')==='yes'){
			 $niveau='tout_le_projet'; 
			}
			if(Input::get('check_categories')==='yes'){ 
				$niveau='categorie';
				$cat_index = Input::get('sel_cat'); 
			}
			if(Input::get('check_activites')==='yes'){
			 	$niveau='activite'; 
			}
			if(Input::get('check_duree_projo')==='yes'){
				$periode='tout_projet';
			}
			if(Input::get('check_periode')==='yes'){
				$periode='periodes';
			}
			$qual_p = 'no';
			$qual_r = 'no';
			$quan_p = 'no';
			$quan_r = 'no';
			if(Input::get('check_quantite_real')==='yes'){
				$quan_r='yes';
			}
			if(Input::get('check_quantite_part')==='yes'){
				$quan_p='yes';
			}
			if(Input::get('check_qualite_part')==='yes'){
				$qual_p ='yes';
			}
			if(Input::get('check_qualite_real')==='yes'){
				$qual_r ='yes';
			}

			$e=Expertise::create([
				'niveau_exp'=>$niveau,
				'periode_exp'=>$periode,
				'projet_id'=>Crypt::decrypt(Session::get('hash_id_project')),
				'quant_part'=>$quan_p,
				'quant_real'=>$quan_r,
				'qual_part'=>$qual_p,
				'qual_real'=>$qual_r
				]);

			$cat=$this->get_categories();
			if($niveau=='categorie'){
				DB::table('lien_expertises_actoucat')
					->insert([
						'expertise_id'=>$e->id,
						'categorie_id'=>$cat[$cat_index]->id
						]);
			}
			$act = $this->get_activites();
			if($niveau=='activite'){
				for($i=1;$i<count($act)+1;$i++){
					if(Input::get('check_activites_'.$i)=='yes'){
						DB::table('lien_expertises_actoucat')
							->insert([
								'expertise_id'=>$e->id,
								'activite_id'=>$act[$i-1]->id
							]);
					}
				}
			}

			if($periode=='periodes'){
				$n=count(Input::all());
				for($i=1;$i<$n+1;$i++){
					if(Input::get('nom_periode_ajout_'.$i)){

						$dated = Input::get('date_deb_periode_ajout_'.$i);
						$dtd=GestionDate::convertToEngDt($dated);

						$datef = Input::get('date_fin_periode_ajout_'.$i);
						$dtf=GestionDate::convertToEngDt($datef);
						DB::table('expertises_periodes')
							->insert([
								'expertise_id'=>$e->id,
								'nom'=>Input::get('nom_periode_ajout_'.$i),
								'date_debut'=>$dtd->format('Y-m-d'),
								'date_fin'=>$dtf->format('Y-m-d')
							]);
					}
				}
			}
			$experts = $this->get_experts();
			for($i=1;$i<count($experts)+1;$i++){
					if(Input::get('check_experts_'.$i)=='yes'){

						DB::table('lien_experts_expertises')
							->insert([
								'expertise_id'=>$e->id,
								'membre_id'=>$experts[$i-1]->id
							]);
					}
				}
			
			return $this->index($id,'Successfully created !');

		}
	}

	public function get_categories(){

		$act = DB::table('categories_activite')
			->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		$res=[];
		for($i=0;$i<count($act);$i++){
			$res[$i]=$act[$i]->nom;
		}
		return $res;
	}

	public function get_periodes_definies(){
		$exp=$this->get_expertises();
		$res=[];
		for($i=0;$i<count($exp);$i++){
			$res[$i]=[];
			$res[$i]=DB::table('expertises_periodes')
					->where('expertise_id','=',$exp[$i]->id)
					->get();
		}
		return $res;
	}

	public function get_expertises(){

		$res=DB::table('expertises')
			->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		return $res;
	}

	public function get_experts_prevu_par_exp(){

		$exp = $this->get_expertises();
		$res=[];
		for($i=0;$i<count($exp);$i++){
			$res[$i]=[];
			$res[$i]=DB::table('lien_experts_expertises')
					->leftJoin('membres','membres.id','=','lien_experts_expertises.membre_id')
					->select('membres.nom as nom','membres.prenom as prenom','membres.fonction as fonction','membres.structure as structure','membres.ville as ville')
					->where('expertise_id','=',$exp[$i]->id)
					->get();
		}
		return $res;
	}
	

	public function get_activites(){

		$act = DB::table('activites')
			->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		return $act;
	}

	public function get_periodes(){

		$act = DB::table('periodes')
			->leftJoin('activites','activites.id','=','periodes.activite_id')
			->select('periodes.id as id','periodes.date_debut as date_d','periodes.date_fin as date_f','activites.nom as activite_mere','periodes.nom as nom')
			->where('activites.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		return $act;
	}

	public function get_experts(){

		$exp = DB::table('lien_membres_activites')
			->leftJoin('membres','membres.id','=','lien_membres_activites.membre_id')
			->leftJoin('lien_projets_membres','lien_projets_membres.membre_id','=','membres.id')
			->select('membres.nom as nom','membres.prenom as prenom','membres.fonction as fonction','membres.structure as structure','membres.ville as ville','membres.id as id')
			->where('lien_projets_membres.projet_id','=', Crypt::decrypt(Session::get('hash_id_project')) )
			->where('lien_membres_activites.membre_status_pour_activite','=','Expert')
			->distinct()
			->get();

		return $exp;
	}
}