<?php

class ShadowCategoriesController extends BaseController{


	public function getAllCategories(){
		$results=DB::table('categories_activite')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function action($id){

			if(Input::get('ajout_cat_enregistres')){
				$results=$this->getAllCategories();
				$n = count($results);

				for($i=1;$i<$n+1;$i++){
					if(Input::get('check_categorie_shad_'.$i)==='yes'){
						$cle=$results[$i-1]->id;
						Db::table('lien_activite_categories')
							->insert([
								'activite_id'=>Crypt::decrypt(Session::get('activity')),
								'categorie_id'=>$cle
								]);
					}
				}
			}
			return Redirect::back()->withInput()->with(['success'=>'Successfully added !']);
		}


}