<?php

class ProjectsTrashController extends BaseController{
	
	public function index(){

		$projet_supp = DB::table('projets')
							->select('projets.titre as titre','projets.created_at as date')
							->where('projets.createur_id','=',Auth::user()->id)
							->where('projets.status_createur','=','trashed')
							->get();
		return View::make('pages.projet.projects-trash')->with(['projets' => $projet_supp,'i'=>0]);
	}


	public function action(){

		$projet_supp = DB::table('projets')
					->where('projets.createur_id','=',Auth::user()->id)
					->where('projets.status_createur','=','trashed')
					->get();
		$n=count($projet_supp);

			for ($i = 1; $i <= $n; $i++) {
    			if (Input::get('msg'.$i) === ''.$i){
    				$cle = $projet_supp[$i-1]->id;
    				
    				DB::table('projets')
    					->where('createur_id','=',Auth::user()->id)
    					->where('id','=',$cle)
    					->update(['status_createur'=>'created']);
    			}
    		}

			return $this->index();
		
	}
}