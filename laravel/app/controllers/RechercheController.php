<?php

class RechercheController extends BaseController{
	

	public function index($resProj=NULL,$resLieux=NULL){
		return View::make('pages.divers.recherche')->with(['resProj'=>$resProj,'resLieux'=>$resLieux,'i'=>0,'err'=>0,'succ'=>0]);
	}

	public function action(){
		
			return $this->search(Input::get('mots_cles'));
		
	}

	public function search($mots){

		$results=[];
		$results2=[];
		if(Input::get('projet_check')){
			$mot=explode(" ",$mots);
				
			$results=DB::table('projets')
					->select('titre','acronyme','objectif','id')
					->where('id','<',0);

			for($i=0; $i<count($mot); $i++){
					
				$res=DB::table('projets')
						->select('titre','acronyme','objectif','id')
						->where('titre','like','%'.$mot[$i].'%')
						->orWhere('acronyme','like','%'.$mot[$i].'%')
						->orWhere('objectif','like','%'.$mot[$i].'%');

				$results=$results->unionAll($res);
				}
 
			$results=$results
					->distinct()
					->get();

			}

		if(Input::get('lieu_check')){

			$mot=explode(" ",$mots);

			$results2=DB::table('lieux')
					->leftJoin('projets','projets.id','=','lieux.projet_id')
					->select('lieux.nom as nom','lieux.adresse as adresse','lieux.ville as ville','lieux.ressources_humaines as ressources_humaines','lieux.ressources_materielles as ressources_materielles','lieux.code_postal as code_postal','lieux.telephone as telephone','lieux.created_at as created_at','projets.titre as titre_projo')
					->where('projets.id','<',0);

			for($i=0; $i<count($mot); $i++){
					
				$res2=DB::table('lieux')
						->leftJoin('projets','projets.id','=','lieux.projet_id')
						->select('lieux.nom as nom','lieux.adresse as adresse','lieux.ville as ville','lieux.ressources_humaines as ressources_humaines','lieux.ressources_materielles as ressources_materielles','lieux.code_postal as code_postal','lieux.telephone as telephone','lieux.created_at as created_at','projets.titre as titre_projo')
						->where('nom','like','%'.$mot[$i].'%')
						->orWhere('adresse','like','%'.$mot[$i].'%')
						->orWhere('ville','like','%'.$mot[$i].'%')
						->orWhere('ressources_humaines','like','%'.$mot[$i].'%')
						->orWhere('ressources_materielles','like','%'.$mot[$i].'%');

				$results2=$results2->unionAll($res2);
				}

			$results2=$results2
					->distinct()
					->get();

			}

		return $this->index($results,$results2);
		} 
} 
		
	