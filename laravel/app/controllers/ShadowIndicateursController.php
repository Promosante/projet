<?php

class ShadowIndicateursController extends BaseController{


	public function getAllIndicateurs(){
		$results=DB::table('indicateurs')
				->select('id','nom','declinaison','domaine','destinataire')
				->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				->get();
		return $results;
	}

	public function action($id){

			if(Input::get('ajout_indic_enregistre')){
				$results=$this->getAllIndicateurs();
				$n = count($results);
				for($i=1;$i<$n+1;$i++){
					if(Input::get('checkc_'.$i)==='yes'){
						$cle=$results[$i-1]->id;
						DB::table('lien_categories_indicateurs')
					 		->insert([
					 				'categorie_id'=>Crypt::decrypt(Session::get('category')),
					 				'indicateur_id'=>$cle
					 			]);	
					 	
					}
				}
			return Redirect::back()->withInput()->with(['success'=>'Successfully added !']);
			}
		}


}