
<?php
class AssociationsController extends BaseController{
	
	public function index($id,$success=NULL){

		$act=$this->get_act();
		$lieux = $this->get_lieux_associes();
		$periodes = $this->get_periodes_nom_associees();
		
		$intervenants = $this->get_intervenant_associes();
		$groupes_dispo = $this->get_groupes();
		$ss_groupes_dispo = $this->get_ss_groupes();

		return View::make('pages.projet.Associations')->with(['id'=>$id,'act'=>$act,
															  'lieux'=>$lieux,'periodes'=>$periodes,
															  'intervenants'=>$intervenants,
															  'success'=>$success,
															  'groupes'=>$groupes_dispo,
															  'ss_groupe'=>$ss_groupes_dispo
															  ]);
	} 

 
	public function get_act(){
		$res = DB::table('activites')
					->select('nom','id')
					->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
					->get();

		$activite_nom=[];

		for($i=0;$i<count($res);$i=$i+1){
			$activite_nom[$i]=$res[$i]->nom;
		}

		$activite_nom[count($res)]='Non associé';

		return $activite_nom;
	}

	public function action($id){
		
		if( Input::get('ajout_eve') ){
			
			return $this->new_evenement($id);
		} 

	}

	public function get_ss_groupes(){

		$results = DB::table('groupes')
			->where( 'projet_id' , '=' , Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		$res=[];

		for($i=0;$i<count($results);$i=$i+1){
			$res[$i]=[];
			$g_id = $results[$i]->id;

			$ss_g = DB::table('sous_groupes')
				->where( 'groupe_id' , '=' , $g_id )
				->get();

			for($j=0;$j<count($ss_g);$j=$j+1){
				$res[$i][$j]= $ss_g[$j]->nom;
			}
		}

		return $res;
	}

	public function get_groupes(){

		$results = DB::table('groupes')
			->where( 'projet_id' , '=' , Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		$res=[];
		for($i=0;$i<count($results);$i=$i+1){
			$res[$i]=$results[$i]->nom;
		}

		return $res;
	}


	public function new_evenement($id){

		$act_sel = Input::get('activite_ajout');
		$periode_sel = Input::get('periode_ajout_'.$act_sel);
		$lieu_sel = Input::get('lieu_ajout');
		$intervenant_sel = Input::get('interv_ajout');
		$nom_eve = Input::get('nom_de_evene');


		$infos = Input::get('infos_pratiques');
		$dated = Input::get('date_debut');
		$datef = Input::get('date_fin_eve');

		$rules=[
		 'infos_pratiques'=>'required',
		 'date_debut'=>'required',
		 'date_fin_eve'=>'required',
		 'activite_ajout'=>'required',
		 'lieu_ajout'=>'required',
		 'interv_ajout'=>'required',
		 'groupes'=>'required',
		 'nom_de_evene'=>'required|unique:evenements,nom'
		];

		$v =Validator::make(Input::all(),$rules);

		if( $v->fails() ){ 
				$messages = $v->messages()->all();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
			}
		else{

				$act= DB::table('activites')
						->select('nom','id')
						->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
						->get();

				$p=DB::table('periodes')
						->select('periodes.nom as nom','periodes.date_debut as dated','periodes.date_fin as datef','periodes.id as id')
						->where('activite_id','=',$act[$act_sel]->id)
						->get();

				$l=DB::table('lien_lieu_activite')
						->leftJoin('lieux','lieux.id','=','lien_lieu_activite.lieu_id')
						->select('lieux.id as id')
						->where('lien_lieu_activite.activite_id','=',$act[$act_sel]->id)
						->get();

				$inter =DB::table('lien_membres_activites')
		 				->leftJoin('membres','membres.id','=','lien_membres_activites.membre_id')
		 				->select('membres.nom as nom','membres.prenom as prenom','membres.fonction as fonction','membres.id as id')
		 				->where('lien_membres_activites.activite_id','=',$act[$act_sel]->id)
		 				->where('lien_membres_activites.membre_status_pour_activite','=','Intervenant')
		 				->get();

				$groupes = DB::table('groupes')
					->where( 'projet_id' , '=' , Crypt::decrypt(Session::get('hash_id_project')) )
					->get();

		 		//date evenement
				$dtd=GestionDate::convertToEngDt($dated);
				$dtf=GestionDate::convertToEngDt($datef);
				$d_var = $dtd->getTimestamp();
				$f_var = $dtf->getTimestamp();
				
				//date periode
				$d_deb = new DateTime($p[$periode_sel]->dated);
				$d_fin = new DateTime($p[$periode_sel]->datef);
				$d = $d_deb->getTimestamp(); 
				$f = $d_fin->getTimestamp();

				//cas inclusion interne
				if(!(($d_var>=$d)&&($f_var<=$f))){
					return Redirect::back()->withInput()->with(['errors'=> ['Problème d\'inclusion : les dates de l\'évènement doivent être incluse dans celles de la périodes.'] ]);
				}
				
				$groupes_sel = $groupes[ Input::get('groupes') ];
				$ssgroupes_sel = NULL;

				$ssgroupes = DB::table('sous_groupes')
							->where('groupe_id','=',$groupes_sel->id)
							->get();

				$ssgroupes_sel = $ssgroupes[Input::get('ss_groupe_affecte_'.Input::get('groupes') )];
				
				$heure_deb = Input::get('heure_debut');
				$heure_fin = Input::get('heure_fin');
				
				$horaire_deb = $dtd->format('Y-m-d').' '.$heure_deb;
				$horaire_fin = $dtf->format('Y-m-d').' '.$heure_fin;

				$e=Evenements::create([ 'periode_id' => $p[$periode_sel]->id,
									 'lieu_id'=>$l[$lieu_sel]->id,
									 'infos_pratique'=>$infos,
									 'date_debut'=>$horaire_deb,
									 'date_fin'=>$horaire_fin,
									 'nom'=>$nom_eve 
								]);

				DB::table('lien_evenements_groupes')
					->insert([
							'evenement_id'=>$e->id,
							'groupe_id'=>$groupes_sel->id
						]);

				if(isset($ssgroupes_sel)){
					DB::table('lien_evenements_sous_groupes')
						->insert([
							'evenement_id'=>$e->id,
							'sous_groupe_id'=>$ssgroupes_sel->id
						]);
				}
				
				DB::table('lien_evenement_intervenant')
					->insert([
						'evenement_id'=>$e->id,
						'intervenant_id'=>$inter[$intervenant_sel]->id
						]);

				return $this->index($id,['Saved !']);
			}
	}

	public function get_periodes_nom_associees(){
		$act = DB::table('activites')
					->select('nom','id')
					->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
					->get();
		$periodes=[];

		for($i=0;$i<count($act);$i++){

			$res=DB::table('periodes')
				->select('periodes.nom as nom','periodes.date_debut as dated','periodes.date_fin as datef','periodes.id as id')
				->where('activite_id','=',$act[$i]->id)
				->get();
			$periodes[$act[$i]->nom]=[];
			for($j=0;$j<count($res);$j++){
					$periodes[$act[$i]->nom][$j] = ' '.$res[$j]->nom.', Du '.$res[$j]->dated.' au '.$res[$j]->datef.'.';
			}
		}
		return $periodes;			
	}

	

	public function get_lieux_associes(){

		$act = DB::table('activites')
					->select('nom','id')
					->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
					->get();
		$lieux=[];

		for($i=0;$i<count($act);$i++){

			$res=DB::table('lien_lieu_activite')
				->leftJoin('lieux','lieux.id','=','lien_lieu_activite.lieu_id')
				->select('lieux.nom as nom','lieux.adresse as a')
				->where('lien_lieu_activite.activite_id','=',$act[$i]->id)
				->get();
				$lieux[ $act[$i]->nom ]=[];
				for($j=0;$j<count($res);$j++){
					$lieux[ $act[$i]->nom ][$j] = ' '.$res[$j]->nom.' '.$res[$j]->a;
			}
		}
		return $lieux;
	}

	public function get_intervenant_associes(){

		$act = DB::table('activites')
					->select('nom','id')
					->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
					->get();
		$inters=[];

		for($i=0;$i<count($act);$i++){

			$res =DB::table('lien_membres_activites')
 				->leftJoin('membres','membres.id','=','lien_membres_activites.membre_id')
 				->select('membres.nom as nom','membres.prenom as prenom','membres.fonction as fonction')
 				->where('lien_membres_activites.activite_id','=',$act[$i]->id)
 				->where('lien_membres_activites.membre_status_pour_activite','=','Intervenant')
 				->get();

				$inters[ $act[$i]->nom ]=[];
				for($j=0;$j<count($res);$j++){
					$inters[ $act[$i]->nom ][$j] = ' '.$res[$j]->nom.' '.$res[$j]->prenom.' ( '.$res[$j]->fonction.' ) ';
			}
		}
		return $inters;
	}
}