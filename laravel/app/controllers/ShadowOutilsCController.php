<?php

class ShadowOutilsCController extends BaseController{


		public function getAllOutils(){
		$results=DB::table('outils')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function action($id){


			if(Input::get('ajout_outils_enregistre')){
				$results=$this->getAllOutils();
				$n = count($results);
				for($i=1;$i<$n+1;$i++){
					if(Input::get('check_o_'.$i)==='yes'){
						$cle=$results[$i-1]->id;
						DB::table('lien_categories_outils')
					 		->insert([
					 				'categorie_id'=>Crypt::decrypt(Session::get('category')),
					 				'outil_id'=>$cle
					 			]);	
					 	
					}
				}
				return Redirect::back()->withInput()->with(['success'=>'Successfully added !']);
			}
		}


}