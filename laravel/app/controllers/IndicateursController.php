<?php

class IndicateursController extends BaseController{
	
	public function index($id,$success=NULL,$script='init_indic();'){
		$outils_assoc=[];
		
		if(Session::has('indic_creation')){
			$script='show_indic_assos();';
			$outils_assoc = $this->get_outils_assoc();
		}
		$outils = $this->getAllOutils();
		

		return View::make('pages.projet.gestionIndicateurs')->with(['id'=>$id,'outils'=>$outils_assoc,'TousLesOutils'=>$outils,
															'script'=>$script,'success'=>$success,'i'=>0,'k'=>0]);
	}
 
	public function get_rep_aux_questions(){
		$indics = DB::table('indicateurs')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
				->get();
		$reponses=[];
		for($i=0;$i<count($indics);$i++){
			$cle=$indics[$i]->id;
			$reponses[$i] = DB::table('reponses_indicateurs')
					->where('indicateur_id','=',$cle)
					->get();
		}
		return $reponses;
	}


	public function action($id){
		
		if(Input::get('consulter')){

			$indics = DB::table('indicateurs')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
				->get();
			$reponses_associees = $this->get_rep_aux_questions();
			return View::make('pages.projet.MesIndicateurs')->with(['id'=>$id,
																	'indics'=>$indics,
																	'reponses'=>$reponses_associees
																	]);
		}

		if(Input::get('ajout_indic')){
			return $this->ajoute_indic($id);
		}

		if(Input::get('terminer')){
			return $this->terminer($id);
		}


		$zz = DB::table('indicateurs')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
				->get();
		$n=count($zz);

		for($i=0;$i<$n;$i++){
			if(Input::get('supprime_$i')){
				$cle=$zz[$i]->id;

				DB::table('reponses_indicateurs')
						->where('indicateur_id','=',$cle)
						->delete();
				DB::table('indicateurs')
					->where('id','=',$cle)
					->delete();

				return $this->index($id,'Successfully deleted !');
			}
		}
		
		if(Input::get('retirer_outils')){
			$o = $this->get_outils_assoc();
			$nn = count($o);
			for($i=0;$i<$nn;$i++){
				if(Input::get('check_outils_'.$i)){

					DB::table('lien_outils_indicateurs')
						->where('outil_id','=',$o[$i-1]->id)
						->delete();
				}
			}
			return Redirect::back();
		}
	}

	public function get_outils_assoc(){
		$outils = DB::table('outils')
				->join('lien_outils_indicateurs','lien_outils_indicateurs.outil_id','=','outils.id')
				->where( 'indicateur_id' , '=' , Crypt::decrypt(Session::get('indic_creation')) )
				->get();

		return $outils;
	}

	public function terminer($id){
		if(Input::get('participation_ajout')==='yes'){
				$domaine='participation';
			}
			else{
				$domaine='realisation';
			}

			if(Input::get('quantite_ajout')==='yes'){
				$declinaison='quantite';
				}
			else{
				$declinaison='qualite';
			}

			if(Input::get('participant_ajout')){
				$destinataires = 'participant';
			}
			else{
				$destinataires ='intervenant';
			}

			$rules=[
				 'question_ajout'=>'required'	 
				];

			$v =Validator::make(Input::all(),$rules);
			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{
				
				DB::table('indicateurs')
					->where('id','=',Crypt::decrypt(Session::get('indic_creation')))
					->update([  'declinaison'=>$declinaison,
								'domaine'=>$domaine,
								'destinataire'=>$destinataires,
								'question'=>Input::get('question_ajout')
					]);

				

				$n = count(Input::all());

				for($ii=0;$ii<$n;$ii++){
					if(Input::get('reponse_'.$ii.'_ajout')){

						if(Input::get('reponse_'.$ii.'_QCM')==='yes'){

							ReponsesIndic::create([
								'indicateur_id'=>Crypt::decrypt(Session::get('indic_creation')),
								'contenu'=>Input::get('reponse_'.$ii.'_ajout'),
								'type'=>'qcm'
							]);
						}
						if(Input::get('reponse_'.$ii.'_libre')==='yes'){
							ReponsesIndic::create([
								'indicateur_id'=>Crypt::decrypt(Session::get('indic_creation')),
								'contenu'=>Input::get('reponse_'.$ii.'_ajout'),
								'type'=>'libre'
							]);
						}
					}	
				}
				
				Session::forget('indic_creation');
				return $this->index($id);
			} 
	}

	public function getAllOutils(){
		$results=DB::table('outils')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function ajoute_indic($id){

		$nom=Input::get('nom_ajout');
		$descr = Input::get('description_ajout');

		$rules=[
		 'nom_ajout'=>'required|unique:indicateurs,nom',
		 'description_ajout'=>'required',
		 
		];
		$v =Validator::make(Input::all(),$rules);
		if( $v->fails()){ 
			$messages = $v->messages();
			return Redirect::back()->withInput()->with(['errors'=>$messages]);
		}
		else{
			$cle=Indicateurs::create([
				'projet_id'=>Crypt::decrypt(Session::get('hash_id_project')),
				'nom'=>$nom
				]);
			Session::forget('indic_creation');
			Session::put('indic_creation',Crypt::encrypt($cle->id));
			return $this->index($id,'Successfully created !','show_indic_assos();');
		}
	}

}