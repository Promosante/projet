<?php

class MesProjetsController extends BaseController{
	
	public function index(){

		$projet_participe = DB::table('lien_projets_membres')
							->leftJoin('projets','projets.id','=','lien_projets_membres.projet_id')
							->leftJoin('membres','membres.id','=','lien_projets_membres.membre_id')
							->leftJoin('lien_membres_activites','membres.id','=','lien_membres_activites.membre_id')
							->leftJoin('activites','activites.id','=','lien_membres_activites.activite_id')
							->leftJoin('users','users.id','=','membres.user_id')
							->leftJoin('users as createur','createur.id','=','projets.createur_id')
							->select('createur.login as login','projets.titre as titre','lien_membres_activites.membre_status_pour_activite as status','projets.id as id')
							->where('users.id','=',Auth::user()->id)
							->where('projets.status_createur','=','created')
							->distinct()
							->get();

		//$liste_hash_tmp = DB::table('lien_projets_membres')
		//					->leftJoin('projets','projets.id','=','lien_projets_membres.projet_id')
		//					->leftJoin('membres','membres.id','=','lien_projets_membres.membre_id')
		//					->leftJoin('lien_membres_activites','membres.id','=','lien_membres_activites.membre_id')
		//					->leftJoin('activites','activites.id','=','lien_membres_activites.activite_id')
		//					->leftJoin('users','users.id','=','membres.user_id')
		//					->leftJoin('users as createur','createur.id','=','projets.createur_id')
		//					->select('projets.id as id')
		//					->where('users.id','=',Auth::user()->id)
		//					->where('projets.status_createur','=','created')
		//					->distinct()
		//					->get(); 
							
		$liste_hash=[];
		for($i=0;$i<count($projet_participe);$i++){
			$liste_hash[$i] = Crypt::encrypt($projet_participe[$i]->id);
		}
		$projet_crees = DB::table('projets')
							->select('projets.titre as titre','projets.created_at as date')
							->where('projets.createur_id','=',Auth::user()->id)
							->where('projets.status_createur','=','created')
							->get();
	
		return View::make('pages.projet.myprojects')->with(['participe' => $projet_participe,'createur'=>$projet_crees,'i'=>0,'j'=>0,'liste_hash'=>$liste_hash]);
	}


	public function display_myprojet($num_proj){

		$projet_crees = DB::table('projets')
							->select('id')
							->where('projets.createur_id','=',Auth::user()->id)
							->where('projets.status_createur','=','created')
							->get();
		$n=count($projet_crees);
		if($num_proj>$n){
			echo "Not existing or forbidden";
			}
		else{
			$cle = $projet_crees[$num_proj-1]->id;

			Session::forget('tool');
			Session::forget('indic_creation');
			Session::forget('category');
			Session::forget('activity');
			Session::forget('hash_id_project');
			Session::put('hash_id_project',Crypt::encrypt($cle));

			$to_display = DB::table('projets')
							->select('titre','created_at','population_cible',
									'date_debut','date_fin', 'objectif', 
									'objectif_specifique','acronyme')
							->where('createur_id','=',Auth::user()->id)
							->where('id','=',$cle)
							->where('status_createur','=','created')
							->get();

			if(count($to_display)==0){
					echo "Not existing or forbidden";
				}

			else{			
					$date1 = new DateTime($to_display[0]->date_debut);
					$to_display[0]->date_debut=$date1->format('d/m/Y');

					$date2 = new DateTime($to_display[0]->date_fin);
					$to_display[0]->date_fin=$date2->format('d/m/Y');
					
					$comments = DB::table('commentaires_projets')
						->leftJoin('users','users.id','=','commentaires_projets.source_id')
						->select('commentaires_projets.contenu as contenu','users.login as login','commentaires_projets.created_at as created_at ')
						->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
						->orderBy('created_at','desc')
						->get();

					return View::make('pages.projet.mon_project')->with(['projet'=> $to_display[0],'id'=>$num_proj,'comments'=>$comments]);
				}
			}
	}

	public function action(){

		$projet_crees = DB::table('projets')
						->where('projets.createur_id','=',Auth::user()->id)
						->where('projets.status_createur','=','created')
						->get();
		$n=count($projet_crees);
		for ($i = 1; $i <$n+1; $i++) {
    		if (Input::get('msg'.$i) === ''.$i){
    			$cle = $projet_crees[$i-1]->id;
    			DB::table('projets')
    				->where('createur_id','=',Auth::user()->id)
    				->where('id','=',$cle)
    				->update(['status_createur'=>'trashed']);
    		}
    	}
		return $this->index();
	
	}
}