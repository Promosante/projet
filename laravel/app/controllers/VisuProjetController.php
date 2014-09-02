<?php

class VisuProjetController extends BaseController{
	
	public function index($hash){

		$membre_id=DB::table('membres')
			->join('users','users.id','=','membres.user_id')
			->where('users.id','=',Auth::user()->id)
			->select('membres.id')
			->get();

		//infos projets
		$projet_datas=DB::table('projets')
				->select('projets.titre as titre','projets.acronyme as acronyme','projets.objectif as objectif','projets.objectif_specifique as objectif_specifique'
						,'projets.population_cible as population_cible','projets.date_debut as date_debut','projets.date_fin as date_fin')
				->where('id','=',Crypt::decrypt($hash))
				->get();

		//infos status visiteur
		$bool_membre = DB::table('lien_projets_membres')
				->where('projet_id','=',Crypt::decrypt($hash))
				->where('membre_id','=',$membre_id[0]->id)
				->get();

		//commentaires
		$comments = DB::table('commentaires_projets')
				->leftJoin('users','users.id','=','commentaires_projets.source_id')
				->select('commentaires_projets.contenu as contenu','users.login as login','commentaires_projets.created_at as created_at ')
				->where('projet_id','=',Crypt::decrypt($hash))
				->orderBy('created_at','desc')
				->get();


		if(count($bool_membre)>0){
			$status = DB::table('lien_membres_activites')
					->where('membre_id','=',$membre_id[0]->id)
					->get();
			$status_tab=[];
			for($i=0;$i<count($status);$i++){
				$status_tab[$i]=$status[$i]->membre_status_pour_activite;
			}
			$status_tab=array_unique($status_tab);	
		}
		else{	$status_tab=[]; }

		$test=DB::table('projets')
			->where('createur_id','=',Auth::user()->id)
			->where('id','=',Crypt::decrypt($hash))
			->get();

		if(count($test)>0){
			$status_tab[ count($status_tab) ]='Créateur';
		}

		$activites_datas=DB::table('activites')
				->select('activites.nom as nom','activites.id as id')
				->where('activites.projet_id','=',Crypt::decrypt($hash))
				->get();

		$act_lieux=[];
		
		for($i=0;$i<count($activites_datas);$i++){
			$cle_a = $activites_datas[$i]->id;
			$act_lieux[$i]=$this->get_lieux($cle_a,$hash);
		}

		//choix des activites dispo (demande d'association)
		$activite_nom=$this->getAct($hash);

		$categories_cr=[];
		$activites_cr=[];
		$periodes_cr=[];
		$evenements_cr=[];
		$indicateurs_i=[];
		$rep_indics_i=[];
		$rep_user_i=[];
		$indicateurs_p=[];
		$rep_indics_p=[];
		$choix_act_interv_indic=[];
		$expertises=[];
		$periodes_expertises=[];
		$ensemble_evenement=[];
		$indics_infos_exp =[];
		$rep_indics_infos_exp=[];
		$rep_indics_exp=[];
		$results_exp=[];
		$eve_fiche_syn=[];
		//choix pour le cr
		for($i=0;$i<count($status_tab);$i++){

			if($status_tab[$i]=='Intervenant'){
				$categories_cr=$this->get_cat_activites_cr($hash);
				$activites_cr=$this->get_activites_cr($hash);
				$periodes_cr=$this->get_periodes_cr($hash);
				$evenements_cr = $this->get_evenements_cr($hash);
				$indicateurs_i = $this->get_indicateurs_interv($hash);
				$rep_indics_i = $this->get_reponses_indic_interv($hash);
				$rep_user_i = $this->get_rep_indics($hash);
				$eve_fiche_syn = $this->get_evenement_dispo_for_me();
			}

			if($status_tab[$i]=='Participant'){
				$indicateurs_p = $this->get_indicateurs_participants($hash);
				$rep_indics_p = $this->get_reponses_indic_participants($hash);
			}
			if($status_tab[$i]=='Expert'){
				$expertises = $this->get_expertise_for_me($hash);
				$periodes_expertises = $this->get_periodes_exp($hash);
				$ensemble_evenement = $this->get_evenement_correspondant_expertise($hash);
				$indics_infos_exp = $this->get_indicateurs_infos_correspondant_expertise($hash);
				$rep_indics_infos_exp=$this->get_indicateurs_reponses_infos_correspondant_expertise($hash);
				$rep_indics_exp = $this->get_indicateurs_data_correspondant_expertise($hash);
				$results_exp = $this->get_result_expertise($hash);
			}
			
		}
	

		return View::make('pages.projet.VisuProjet')->with(['projet'=>$projet_datas[0],
															'status'=>$status_tab,
															'activites'=>$activites_datas,
															'act_lieux'=>$act_lieux,
															'act'=>$activite_nom,
															'i'=>0,
															'comments'=>$comments,
															'hash'=>$hash,
															'categories_cr'=>$categories_cr,
															'activites_cr'=>$activites_cr,
															'periodes_cr'=>$periodes_cr,
															'evenements_cr'=>$evenements_cr,
															'indicateurs'=>$indicateurs_i,
															'rep_indics'=>$rep_indics_i,
															'rep_user_indics'=>$rep_user_i,
															'indicateurs_p'=>$indicateurs_p,
															'rep_indics_p'=>$rep_indics_p,
															'expertises'=>$expertises,
															'periodes_expertises'=>$periodes_expertises,
															'ensemble_evenement'=>$ensemble_evenement,
															'indics_infos_exp'=>$indics_infos_exp,
															'rep_indics_infos_exp'=>$rep_indics_infos_exp,
															'rep_indics_exp'=>$rep_indics_exp,
															'results_exp'=>$results_exp,
															'eve_fiche_syn'=>$eve_fiche_syn
															]);
	}

public function get_lieux2($cle_a,$hash){
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


public function getAct($hash){
		$res = DB::table('activites')
					->select('nom')
					->where('projet_id','=',Crypt::decrypt($hash))
					->get();
					
		$activite_nom=[];

		for($i=0;$i<count($res);$i=$i+1){
			$activite_nom[$i]=$res[$i]->nom;
		}

		$activite_nom[count($res)]='Non associé';
		return $activite_nom;
}


public function get_lieux($cle_a,$hash){
 		//adapted from activites controller
		$lieux=DB::table('lien_lieu_activite')
				->join('lieux','lieux.id','=','lien_lieu_activite.lieu_id')
				->join('activites','activites.id','=','lien_lieu_activite.activite_id')
				->select('lieux.nom as nom','lieux.adresse as adresse','lieux.ville as ville','lieux.code_postal as code_postal','lieux.id as lieu_id')
				->where('activites.projet_id','=', Crypt::decrypt($hash))
				->where('activites.id','=', $cle_a)
				->get();

		return $lieux;
	}

public function get_cr_depose($hash){


	$destinationPath = 'app/cr_upload/';

	

	if( file_exists( $destinationPath.$filename ) ){
		
	}
	else{
		
	}
		



}

public function get_cat_activites_cr($hash){

	$cat=DB::table('categories_activite')
		->where('projet_id','=',Crypt::decrypt($hash))
		->get();

	$res=[];
	for($i=0;$i<count($cat);$i++){
		$res[$i]=$cat[$i]->nom;
	}

	$res[count($cat)] = 'Non associé';

	return $res;
}

public function get_reponses_indic_interv($hash){
	$indics = $this->get_indicateurs_interv($hash);
	$res=[];
	for($i=0;$i<count($indics);$i++){
		$cle=$indics[$i]->id;
		$res[$i] = DB::table('reponses_indicateurs')
					->where('indicateur_id','=',$cle)
					->get();
	}
	return $res;
}

public function get_reponses_indic_participants($hash){
	$indics = $this->get_indicateurs_participants($hash);
	$res=[];
	for($i=0;$i<count($indics);$i++){
		$cle=$indics[$i]->id;
		$res[$i] = DB::table('reponses_indicateurs')
					->where('indicateur_id','=',$cle)
					->get();
	}
	return $res;
}

public function get_indicateurs_interv($hash){
		$id_membre = DB::table('users')
			->leftJoin('membres','membres.user_id','=','users.id')
			->where('users.id','=',Auth::user()->id)
			->get();

		$res = DB::table('indicateurs')
			->leftJoin('indicateurs_specifique_activites','indicateurs_specifique_activites.indicateur_id','=','indicateurs.id')
			->leftJoin('activites','indicateurs_specifique_activites.activite_id','=','activites.id')
			->leftJoin('lien_membres_activites','lien_membres_activites.activite_id','=','activites.id')
			->leftJoin('periodes','periodes.activite_id','=','activites.id')
			->leftJoin('evenements','evenements.periode_id','=','periodes.id')
			->leftJoin('lien_evenement_intervenant','lien_evenement_intervenant.evenement_id','=','evenements.id')
			->select('indicateurs.question as question','activites.nom as act_nom','indicateurs.nom as nom','indicateurs.declinaison as declinaison','indicateurs.domaine as domaine','indicateurs.id as id','evenements.nom as nom_eve')
			->where('lien_evenement_intervenant.intervenant_id','=',$id_membre[0]->id)
			->where('lien_membres_activites.membre_status_pour_activite','=','Intervenant')
			->where('indicateurs.destinataire','=','intervenant')
			->distinct()
			->get();

		return $res;
		}

public function get_indicateurs_participants($hash){
		$id_membre = DB::table('users')
			->leftJoin('membres','membres.user_id','=','users.id')
			->where('users.id','=',Auth::user()->id)
			->get();

		$res = DB::table('indicateurs')
			->leftJoin('indicateurs_specifique_activites','indicateurs_specifique_activites.indicateur_id','=','indicateurs.id')
			->leftJoin('activites','indicateurs_specifique_activites.activite_id','=','activites.id')
			->leftJoin('lien_membres_activites','lien_membres_activites.activite_id','=','activites.id')
			->select('indicateurs.question as question','activites.nom as act_nom','indicateurs.nom as nom','indicateurs.declinaison as declinaison','indicateurs.domaine as domaine','indicateurs.id as id')
			->where('lien_membres_activites.membre_id','=',$id_membre[0]->id)
			->where('lien_membres_activites.membre_status_pour_activite','=','Participant')
			->where('indicateurs.destinataire','=','participant')
			->distinct()
			->get();
		return $res;
		}

public function get_activites_cr($hash){

	$act_dispo = DB::table('activites')
			->where('projet_id','=',Crypt::decrypt($hash))
			->get();

	$res=[];

	for($i=0;$i<count($act_dispo);$i++){
		$res[$i]=$act_dispo[$i]->nom;
	}
	$res[count($act_dispo)] = 'Non associé';

	return $res;
}


public function get_periodes_cr($hash){

	$act_dispo = DB::table('activites')
			->where('projet_id','=',Crypt::decrypt($hash))
			->get();

	$res=[];

	for($i=0;$i<count($act_dispo);$i++){
		$res[$i]=[];
		$p_dispo = DB::table('periodes')
			->where('activite_id','=',$act_dispo[$i]->id)
			->get();
		for($j=0;$j<count($p_dispo);$j++){
			$res[$i][$j] = $p_dispo[$j]->nom.' (activite '.$act_dispo[$i]->nom.').';
		}
		$res[$i][count($p_dispo)] = 'Non associé';
	}
	return $res;
}
public function get_evenement_dispo_for_me(){

	$m=DB::table('membres')
		->where('user_id','=',Auth::user()->id)
		->get();

	$eve=DB::table('lien_evenement_intervenant')
		->leftJoin('evenements','evenements.id','=','lien_evenement_intervenant.evenement_id')
		->select('evenements.nom as nom','evenements.date_debut as date_debut','evenements.date_fin as date_fin')
		->where('lien_evenement_intervenant.intervenant_id','=',$m[0]->id)
		->get();

	$res=[];
	for($i=0;$i < count($eve);$i++){
		$res[$i] = 'evenement '.$i.' : '.$eve[$i]->nom.' du '.(new DateTime($eve[$i]->date_debut))->format('m/d/Y').' au '.(new DateTime($eve[$i]->date_fin))->format('m/d/Y').'.';
	}
	return $res;
}

public function get_evenements_cr($hash){

	$act_dispo = DB::table('activites')
			->where('projet_id','=',Crypt::decrypt($hash))
			->get();

	$res=[];
	for($i=0;$i<count($act_dispo);$i++){
		$res[$i]=[];
		$p_dispo = DB::table('periodes')
			->where('activite_id','=',$act_dispo[$i]->id)
			->get();
		for($j=0;$j<count($p_dispo);$j++){
			$res[$i][$j] = [];
			$eve_dispo = DB::table('evenements')
				->where('periode_id','=',$p_dispo[$j]->id)
				->get();
			for($k=0;$k<count($eve_dispo);$k++){
				$res[$i][$j][$k] = $eve_dispo[$k]->nom.'(periode '.$p_dispo[$j]->nom.')';
			}
			$res[$i][$j][count($eve_dispo)] = 'Non associé';
		}
	}
	return $res;
}



public function action($hash){

		if(Input::get('participer')){
			return $this->requete_participe($hash);
		}

		if(Input::get('ajout_com')){

			$msg = Input::get('comment');

			CommentsProjet::create([
					'contenu'=>$msg,
					'source_id'=>Auth::user()->id,
					'projet_id'=>Crypt::decrypt($hash)
					]);

			return Redirect::back();
		}

		if(Input::get('sauver_indics')){
			return $this-> sauve_indics_interv($hash);
		}

		if(Input::get('upload_cr')){
			return $this->sauve_cr_interv($hash);
		}
		$expertises = $this->get_expertise_for_me($hash);
		for($i=0;$i<count($expertises);$i++){
			if(Input::get('sauver_exp_'.$i)){
				return $this->sauver_exp($hash);
			}
		}

	}

public function sauve_cr_interv($hash){

		$destinationPath = '';
    	$filename        = '';

    	if ( Input::hasFile('fichier') ) {
       		$file            = Input::file('fichier');
        	$destinationPath = 'app/cr_upload/';
        	$extension = Input::file('fichier')->getClientOriginalExtension();
			
			if( Input::get('cr_check_projet') == 'yes' ){
				$path_info = 'cr_user_'.Auth::user()->id.'_projet_'.Crypt::decrypt($hash).'_toutleprojet';
			}
			//categorie
			if(Input::get('cr_cat_sel')){

				$cat=$this->get_cat_activites_cr($hash);
				
				$index=Input::get('cr_cat_sel');

				if( $cat[$index] == 'Non associé' ){

				}
				else{
					$path_info = 'cr_user_'.Auth::user()->id.'_projet_'.Crypt::decrypt($hash).'_cat_'.$cat[$index];
				}
			}
			//activite
			$act=$this->get_activites_cr($hash);
			if(Input::get('cr_act_sel')){
				
				$index=Input::get('cr_act_sel');

				if( $act[$index] == 'Non associé' ){

				}
				else{
					$path_info = 'cr_user_'.Auth::user()->id.'_projet_'.Crypt::decrypt($hash).'_act_'.$index;
				}
			}
			//periodes
			$per=$this->get_periodes_cr($hash);
			for($i=0;$i<count($act);$i++){
				if(Input::get('cr_p_sel_'.$i)){
					
					$index=Input::get('cr_p_sel_'.$i);
					if( $per[$i][$index] == 'Non associé' ){

					}
					else{
						$path_info = 'cr_user_'.Auth::user()->id.'_projet_'.Crypt::decrypt($hash).'_act_'.$i.'_per_'.$index;
					}
				}
			}
			$eve = $this->get_evenements_cr($hash);
			for($i=0;$i<count($act);$i++){
				for($j=0;$j<count($per);$j++){

					if(Input::get('cr_p_sel_'.$i.'_'.$j)){
					
						$index=Input::get('cr_p_sel_'.$i.'_'.$j);
						if( $eve[$i][$j][$index] == 'Non associé' ){

						}
						else{
							$path_info = 'cr_user_'.Auth::user()->id.'_projet_'.Crypt::decrypt($hash).'_act_'.$i.'_per_'.$j.'_eve_'.$index;
						}
					}
				}
			}

        	if(!isset($path_info)){
        		$path_info = 'cr_user_'.Auth::user()->id.'_projet_'.Crypt::decrypt($hash).'_toutleprojet';
        	}

			$filename =  $path_info. '.' . $extension;	
        	if (file_exists($destinationPath.$filename)) {
					unlink($destinationPath.$filename);
				}
			$uploadSuccess   = $file->move($destinationPath, $filename);

			if($uploadSuccess){
				return Redirect::back()->with(['success'=>'Successfully uploaded']);
			}
			else{
				return Redirect::back()->with(['error'=>'upload failed']);
			}
    	}
    	return Redirect::back()->with(['error'=>'upload failed, no input']);

	}

	public function sauve_indics_interv($hash){

		$indics = $this->get_indicateurs_interv($hash);
		$rep_indics = $this->get_reponses_indic_interv($hash);

		for($i=0 ; $i < count($indics); $i++ ){
			for($j=0 ; $j < count($rep_indics[$i]); $j++ ){

				$a = DB::table('activites')
					->leftJoin('periodes','periodes.activite_id','=','activites.id')
					->leftJoin('evenements','evenements.periode_id','=','periodes.id')
					->select('evenements.id as id')
					->where('activites.nom','=',$indics[$i]->act_nom)
					->where('evenements.nom','=',$indics[$i]->nom_eve)
					->where('activites.projet_id','=',Crypt::decrypt($hash))
					->get();

				$test_maj=DB::table('reponses_indic_users')
						->where('reponse_indic_id','=',$rep_indics[$i][$j]->id)
						->where('evenement_id','=',$a[0]->id)
						->get();

				$m=DB::table('membres')
					->where('user_id','=',Auth::user()->id)
					->get();		

				

				if(Input::get('check_'.$i.'_'.$j)=='yes'){
						$contenu = 'yes';
					}
				else{
					$contenu = 'no';
					}
				if(Input::get('rep_'.$i.'_'.$j)){
						$contenu = Input::get('rep_'.$i.'_'.$j);
					}
				
				if(count($test_maj)==0){
					DB::table('reponses_indic_users')
						->insert([
							'reponse_indic_id'=>$rep_indics[$i][$j]->id,
							'membre_id'=>$m[0]->id,
							'evenement_id'=>$a[0]->id,
							'contenu'=>$contenu
							]);
				}
				else{
					DB::table('reponses_indic_users')
						->where('reponse_indic_id','=',$rep_indics[$i][$j]->id)
						->where('membre_id','=',$m[0]->id)
						->where('evenement_id','=',$a[0]->id)
						->update([
							'contenu'=>$contenu
							]);
				}
			}
		}
		return Redirect::back()->with(['success'=>'Successfully saved !']);
	}
	
	public function get_rep_indics($hash){
		$indics = $this->get_indicateurs_interv($hash);
		$rep_indics = $this->get_reponses_indic_interv($hash);
		$res=[];
		for($i=0 ; $i < count($indics); $i++ ){
			$res[$i]=[];
			$a = DB::table('activites')
					->leftJoin('periodes','periodes.activite_id','=','activites.id')
					->leftJoin('evenements','evenements.periode_id','=','periodes.id')
					->select('evenements.id as id')
					->where('activites.nom','=',$indics[$i]->act_nom)
					->where('evenements.nom','=',$indics[$i]->nom_eve)
					->where('activites.projet_id','=',Crypt::decrypt($hash))
					->get();

			for($j=0 ; $j < count($rep_indics[$i]); $j++ ){
				$cle = $rep_indics[$i][$j]->id;
				$res[$i][$j] = DB::table('reponses_indic_users')
								->where('reponse_indic_id','=',$rep_indics[$i][$j]->id)
								->where('evenement_id','=',$a[0]->id)
								->get();
			}
		}
		return $res;
	}

	public function get_all_evenement_interv(){

		$id_membre = DB::table('users')
			->leftJoin('membres','membres.user_id','=','users.id')
			->where('users.id','=',Auth::user()->id)
			->get();

		$res=DB::table('lien_evenement_intervenant')
			->where('intervenant_id','=',$id_membre[0]->id);
	}



public function get_expertise_for_me($hash){
	$id_membre = DB::table('users')
			->leftJoin('membres','membres.user_id','=','users.id')
			->where('users.id','=',Auth::user()->id)
			->get();

	$expertise = DB::table('lien_experts_expertises')
		->leftJoin('expertises','lien_experts_expertises.expertise_id','=','expertises.id')
		->leftJoin('membres','membres.id','=','membre_id')
		->leftJoin('lien_projets_membres','lien_projets_membres.membre_id','=','membres.id')
		->select('expertises.niveau_exp as niveau_exp','expertises.periode_exp as periode_exp','expertises.id as id','expertises.quant_part as quant_part','expertises.quant_real as quant_real','expertises.qual_real as qual_real','expertises.qual_part as qual_part')
		->where('membres.id','=',$id_membre[0]->id)
		->where('lien_experts_expertises.membre_id','=',$id_membre[0]->id )
		->where('lien_projets_membres.projet_id','=',Crypt::decrypt($hash) )
		->distinct()
		->get();
	return $expertise;
}

public function get_periodes_exp($hash){

	$expertises = $this->get_expertise_for_me($hash);
	$res=[];

	for($i=0;$i<count($expertises);$i++){
		$res[$i] = DB::table('expertises_periodes')
			->where('expertise_id','=',$expertises[$i]->id)
			->get();
	}
	return $res;
}

public function get_activites_exp($hash){
	$expertises = $this->get_expertise_for_me($hash);
	$res=[];

	for($i=0;$i<count($expertises);$i++){
		if($expertises[$i]->niveau_exp == 'activite'){
			$res[$i] = DB::table('lien_expertises_actoucat')
				->leftJoin('activites','activites.id','=','lien_expertises_actoucat.activite_id')
				->where('lien_expertises_actoucat.expertise_id','=',$expertises[$i]->id)
				->get();
		}
		if($expertises[$i]->niveau_exp == 'tout_le_projet'){
			$res[$i] = DB::table('activites')
				->where('projet_id','=',Crypt::decrypt($hash))
				->get();
		}
	}
	return $res;
}
public function get_categorie_exp($hash){
	$expertises = $this->get_expertise_for_me($hash);
	$res=[];

	for($i=0;$i<count($expertises);$i++){
		if($expertises[$i]->niveau_exp == 'categorie'){
			$res[$i] = DB::table('lien_expertises_actoucat')
				->leftJoin('categories_activite','categories_activite.id','=','lien_expertises_actoucat.categorie_id')
				->where('lien_expertises_actoucat.expertise_id','=',$expertises[$i]->id)
				->get();
		}
		else{
			$res[$i] = [];
		}
	}
	return $res;
}


public function get_evenement_correspondant_expertise($hash){
	$expertises = $this->get_expertise_for_me($hash);
	$all_activite = $this->get_activites_exp($hash);
	$all_periode = $this->get_periodes_exp($hash);
	$all_categorie = $this->get_categorie_exp($hash);
	$evenement_par_exp_puis_periodes_puis_activites = [];

	for($i=0;$i<count($expertises);$i++){
		//recup dates de deb et fin + activite associee (en vue de parcourir evenement et de recup indicateurs)
		$periodes_associees = $all_periode[$i];
		if($expertises[$i]->niveau_exp == 'activite' || $expertises[$i]->niveau_exp == 'tout_le_projet'){
			$activites_associees = $all_activite[$i];
		}

		if($expertises[$i]->niveau_exp == 'categorie'){
			$cat = $all_categorie[$i];
			$activites_associees = DB::table('lien_activite_categories')
						->leftJoin('activites','activites.id','=','lien_activite_categories.activite_id')
						->select('activites.id as id','activites.nom as nom','activites.date_debut as date_debut','activites.date_fin as date_fin')
						->where('lien_activite_categories.categorie_id','=',$cat[0]->id)
						->get();
		}

		//memoriser les evenement de chaque catégorie par période
		$evenement_par_exp_puis_periodes_puis_activites[$i]=[];
		
		if($expertises[$i]->periode_exp=='periodes'){
		//parcourt periodes definies
			for($j=0;$j<count($periodes_associees);$j++){
				$timestamp_date_debut_periode = (new DateTime($periodes_associees[$j]->date_debut))->getTimestamp();
				$timestamp_date_fin_periode = (new DateTime($periodes_associees[$j]->date_fin))->getTimestamp();
				$d_f_per = $timestamp_date_fin_periode;
				$d_d_per = $timestamp_date_debut_periode;
				$evenement_par_exp_puis_periodes_puis_activites[$i][$j] = [];
				//on cherche parmis les periodes associees les evenements inclus dans les periodes
				for($k=0;$k<count($activites_associees);$k++){
					$periodes_de_l_activite = DB::table('periodes')
							->where('activite_id','=',$activites_associees[$k]->id)
							->get();

					$evenement_par_exp_puis_periodes_puis_activites[$i][$j][$k]=[];
					for($l=0;$l<count($periodes_de_l_activite);$l++){
						$evenements_de_la_periode = DB::table('evenements')
								->where('periode_id','=',$periodes_de_l_activite[$l]->id)
								->get();
						for($e=0;$e<count($evenements_de_la_periode);$e++){
								$timestamp_date_debut_evenement =  (new DateTime($evenements_de_la_periode[$e]->date_debut))->getTimestamp();
								$timestamp_date_fin_evenement = (new DateTime($evenements_de_la_periode[$e]->date_debut))->getTimestamp();
								$d_f_eve = $timestamp_date_fin_evenement;
								$d_d_eve = $timestamp_date_debut_evenement;
								//evenement inclu
								if(($d_d_per <= $d_d_eve)&&($d_f_per >= $d_f_eve)){
									$evenement_par_exp_puis_periodes_puis_activites[$i][$j][$k][$e] = $evenements_de_la_periode[$e];
								}
						}
					}	
				}
			}
		}
		if($expertises[$i]->periode_exp=='tout_projet'){
		//si periode = tt le projo
		$evenement_par_exp_puis_periodes_puis_activites[$i][0] = [];
		//on cherche parmis les periodes associees les evenements inclus dans les periodes
		for($k=0;$k<count($activites_associees);$k++){
			$periodes_de_l_activite = DB::table('periodes')
					->where('activite_id','=',$activites_associees[$k]->id)
					->get();
			$evenement_par_exp_puis_periodes_puis_activites[$i][0][$k]=[];
			for($l=0;$l<count($periodes_de_l_activite);$l++){
				$evenements_de_la_periode = DB::table('evenements')
						->where('periode_id','=',$periodes_de_l_activite[$l]->id)
						->get();
				for($e=0;$e<count($evenements_de_la_periode);$e++){
						//evenement inclu
							$evenement_par_exp_puis_periodes_puis_activites[$i][0][$k][$e] = $evenements_de_la_periode[$e];
					}
				}	
			}

		}
	}
	return $evenement_par_exp_puis_periodes_puis_activites;
}

public function get_indicateurs_infos_correspondant_expertise($hash){
	$evenements = $this->get_evenement_correspondant_expertise($hash);
	$indics_associees=[];
	for($i=0;$i<count($evenements);$i++){
		//expertise
		$indics_associees[$i]=[];
		for($j=0;$j<count($evenements[$i]);$j++){
			//periodes
			$indics_associees[$i][$j]=[];
			for($k=0;$k<count($evenements[$i][$j]);$k++){
				//activites
				$indics_associees[$i][$j][$k]=[];
				for($l=0;$l<count( $evenements[$i][$j][$k] );$l++){
					//evenements
					$indics_associees[$i][$j][$k]=[];

					$res = DB::table('reponses_indic_users')
									->leftJoin('reponses_indicateurs','reponses_indic_users.reponse_indic_id','=','reponses_indicateurs.id')
									->leftJoin('indicateurs','indicateurs.id','=','reponses_indicateurs.indicateur_id')
									->select('indicateurs.declinaison as declinaison','indicateurs.domaine as domaine','indicateurs.destinataire as destinataire','indicateurs.question as question')
									->where('reponses_indic_users.evenement_id','=',$evenements[$i][$j][$k][$l]->id)
									->distinct()
									->get();

					$indics_associees[$i][$j][$k]=$res;	
								
				}
			}
		}
	}
	return $indics_associees;
}
public function get_indicateurs_reponses_infos_correspondant_expertise($hash){
	$evenements = $this->get_evenement_correspondant_expertise($hash);
	$indics_associees=[];
	for($i=0;$i<count($evenements);$i++){
		//expertise
		$indics_associees[$i]=[];
		for($j=0;$j<count($evenements[$i]);$j++){
			//periodes
			$indics_associees[$i][$j]=[];
			for($k=0;$k<count($evenements[$i][$j]);$k++){
				//activites
				$indics_associees[$i][$j][$k]=[];
				for($l=0;$l<count( $evenements[$i][$j][$k] );$l++){
					//evenements
					$indics_associees[$i][$j][$k]=[];

					$res = DB::table('reponses_indic_users')
									->leftJoin('reponses_indicateurs','reponses_indic_users.reponse_indic_id','=','reponses_indicateurs.id')
									->leftJoin('indicateurs','indicateurs.id','=','reponses_indicateurs.indicateur_id')
									->select('indicateurs.declinaison as declinaison','indicateurs.domaine as domaine','indicateurs.destinataire as destinataire','indicateurs.question as question','indicateurs.id as id')
									->where('reponses_indic_users.evenement_id','=',$evenements[$i][$j][$k][$l]->id)
									->distinct()
									->get();

					for($r=0;$r<count($res);$r++){
						$indics_associees[$i][$j][$k][$r]=[];

						$res2=DB::table('reponses_indicateurs')
							->where('indicateur_id','=',$res[$r]->id)
							->get();


						$indics_associees[$i][$j][$k][$r]=$res2;
					}
								
				}
			}
		}
	}
	return $indics_associees;
}

public function get_indicateurs_data_correspondant_expertise($hash){
	$evenements = $this->get_evenement_correspondant_expertise($hash);
	$indics_associees=[];
	for($i=0;$i<count($evenements);$i++){
		//expertise
		$indics_associees[$i]=[];
		for($j=0;$j<count($evenements[$i]);$j++){
			//periodes
			$indics_associees[$i][$j]=[];
			for($k=0;$k<count($evenements[$i][$j]);$k++){
				//activites
				$indics_associees[$i][$j][$k]=[];
				for($l=0;$l<count( $evenements[$i][$j][$k] );$l++){
					//evenements
					$indics_associees[$i][$j][$k]=[];

					$res = DB::table('reponses_indic_users')
									->leftJoin('reponses_indicateurs','reponses_indic_users.reponse_indic_id','=','reponses_indicateurs.id')
									->leftJoin('indicateurs','indicateurs.id','=','reponses_indicateurs.indicateur_id')
									->select('indicateurs.declinaison as declinaison','indicateurs.domaine as domaine','indicateurs.destinataire as destinataire','indicateurs.question as question','indicateurs.id as id')
									->where('reponses_indic_users.evenement_id','=',$evenements[$i][$j][$k][$l]->id)
									->distinct()
									->get();

					for($r=0;$r<count($res);$r++){
						$indics_associees[$i][$j][$k][$r]=[];
						$res2=DB::table('reponses_indicateurs')
							->where('indicateur_id','=',$res[$r]->id)
							->get();
						for($q=0;$q<count($res2);$q++){

							$res3 =DB::table('reponses_indic_users')
								->where('reponse_indic_id','=',0);
							for($ll=0;$ll<count( $evenements[$i][$j][$k] );$ll++){
									$res_temp=DB::table('reponses_indic_users')
										->where('reponse_indic_id','=',$res2[$q]->id)
										->where('evenement_id','=',$evenements[$i][$j][$k][$ll]->id);
									$res3=$res3->unionAll($res_temp);
								}
							$res3=$res3->get();
							$indics_associees[$i][$j][$k][$r][$q] = $res3;
						}
					}
								
				}
			}
		}
	}
	return $indics_associees;
}

public function get_result_expertise($hash){
	$expertises = $this->get_expertise_for_me($hash);
	$all_activite = $this->get_activites_exp($hash);
	$all_periode = $this->get_periodes_exp($hash);
	$res=[];
	for($i=0;$i<count($expertises);$i++){
			$res[$i]=[];
			$exp_id=$expertises[$i]->id;
			$periodes_associees = $all_periode[$i];
				if($expertises[$i]->niveau_exp == 'activite' || $expertises[$i]->niveau_exp == 'tout_le_projet'){
					$activites_associees = $all_activite[$i];
				}
				if($expertises[$i]->niveau_exp == 'categorie'){
					$cat = $all_categorie[$i];
					$activites_associees = DB::table('lien_activite_categories')
								->leftJoin('activites','activites.id','=','lien_activite_categories.activite_id')
								->select('activites.id as id','activites.nom as nom','activites.date_debut as date_debut','activites.date_fin as date_fin')
								->where('lien_activite_categories.categorie_id','=',$cat[0]->id)
								->get();
				}

			for($j=0;$j<count($periodes_associees);$j++){
				$per_id=$periodes_associees[$j]->id;
				$res[$i][$j]=[];
				for($k=0;$k<count($activites_associees);$k++){
					$res[$i][$j][$k]=[];

					$act_id=$activites_associees[$k]->id;

					$m=DB::table('membres')
							->where('user_id','=',Auth::user()->id)
							->get();

					$notes=DB::table('resultats_expertise')
							->where('expert_id','=',$m[0]->id)
							->where('projet_id','=',Crypt::decrypt($hash) )
							->where('expertise_id','=',$exp_id)
							->where('periode_id','=',$per_id)
							->where('activite_id','=',$act_id)
							->get();

					if(count($notes)>0){
						$res[$i][$j][$k]['qt_p']=$notes[0]->note_quant_part;
						$res[$i][$j][$k]['ql_p']=$notes[0]->note_qual_part;
						$res[$i][$j][$k]['qt_r']=$notes[0]->note_quant_real;
						$res[$i][$j][$k]['ql_r']=$notes[0]->note_qual_real;	}
					else{
						$res[$i][$j][$k]['qt_p']='';
						$res[$i][$j][$k]['ql_p']='';
						$res[$i][$j][$k]['qt_r']='';
						$res[$i][$j][$k]['ql_r']='';	
					}
				}
			}
		}
	return $res;
}

public function sauver_exp($hash){
	$expertises = $this->get_expertise_for_me($hash);
	$all_activite = $this->get_activites_exp($hash);
	$all_periode = $this->get_periodes_exp($hash);

	for($i=0;$i<count($expertises);$i++){
		if(Input::get('sauver_exp_'.$i)){
			$exp_id=$expertises[$i]->id;
			$periodes_associees = $all_periode[$i];
				if($expertises[$i]->niveau_exp == 'activite' || $expertises[$i]->niveau_exp == 'tout_le_projet'){
					$activites_associees = $all_activite[$i];
				}
				if($expertises[$i]->niveau_exp == 'categorie'){
					$cat = $all_categorie[$i];
					$activites_associees = DB::table('lien_activite_categories')
								->leftJoin('activites','activites.id','=','lien_activite_categories.activite_id')
								->select('activites.id as id','activites.nom as nom','activites.date_debut as date_debut','activites.date_fin as date_fin')
								->where('lien_activite_categories.categorie_id','=',$cat[0]->id)
								->get();
				}

			for($j=0;$j<count($periodes_associees);$j++){
				$per_id=$periodes_associees[$j]->id;

				for($k=0;$k<count($activites_associees);$k++){
					$act_id=$activites_associees[$k]->id;

					if(Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantpart')||Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualpart')||Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantreal')||Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualreal')){
						
						if(Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantpart')){
							$quantpart = Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantpart');
						}
						else{
							$quantpart ='None';
						}
						if(Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualpart')){
							$qualpart = Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualpart');
						}
						else{
							$qualpart ='None';
						}
						if(Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantreal')){
							$quantreal = Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantreal');
						}
						else{
							$quantreal ='None';
						}
						if(Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualreal')){
							$qualreal = Input::get('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualreal');
						}
						else{
							$qualreal ='None';
						}
						$m=DB::table('membres')
							->where('user_id','=',Auth::user()->id)
							->get();

						$test_maj=DB::table('resultats_expertise')
							->where('expert_id','=',$m[0]->id)
							->where('projet_id','=',Crypt::decrypt($hash) )
							->where('expertise_id','=',$exp_id)
							->where('periode_id','=',$per_id)
							->where('activite_id','=',$act_id)
							->get();
						if(count($test_maj)>0){
							DB::table('resultats_expertise')
								->where('expert_id','=',$m[0]->id)
								->where('projet_id','=',Crypt::decrypt($hash) )
								->where('expertise_id','=',$exp_id)
								->where('periode_id','=',$per_id)
								->where('activite_id','=',$act_id)
								->update([
										'note_quant_part'=>$quantpart,
										'note_qual_part'=>$qualpart,
										'note_quant_real'=>$quantreal,
										'note_qual_real'=>$qualreal
									]);
						}
						else{
							DB::table('resultats_expertise')
								->insert([
										'expert_id'=>$m[0]->id,
										'projet_id'=>Crypt::decrypt($hash),
										'expertise_id'=>$exp_id,
										'periode_id'=>$per_id,
										'activite_id'=>$act_id,
										'note_quant_part'=>$quantpart,
										'note_qual_part'=>$qualpart,
										'note_quant_real'=>$quantreal,
										'note_qual_real'=>$qualreal
									]);
						}
					}
				}
			}
		}
	}
	return Redirect::back();
}

public function requete_participe($hash){

		$activite_nom=$this->getAct($hash);

		//qualite
		$qualite_selectionnee = 'NC';
		if(Input::get('qualite_ajout')=='E'){$qualite_selectionnee = 'Expert';}
		if(Input::get('qualite_ajout')=='C'){$qualite_selectionnee = 'Collaborateur';}
		if(Input::get('qualite_ajout')=='I'){$qualite_selectionnee = 'Intervenant';}
		if(Input::get('qualite_ajout')=='P'){$qualite_selectionnee = 'Participant';}

		//activite
		$act_index = Input::get('activite_ajout');
		if($act_index<count($activite_nom)-1){
			$act=$activite_nom[$act_index];
		}
		else{
			$act=NULL;
		}
		//createur id
		$createur_id = DB::table('projets')
				->select('createur_id')
				->where('id','=',Crypt::decrypt($hash))
				->get();

		$datas=['activite'=>$act,'qualite'=>$qualite_selectionnee];

		Notif::send_notif_to(Auth::user()->id,$createur_id[0]->createur_id,'demande_assos_projet', $datas,$hash);
			
		return Redirect::to('home')->with(['success'=>'Votre demande a été prise en compte']);
	}
	}

