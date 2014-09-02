<?php

class ShadowLieuxController extends BaseController{


public function ajoute_lieux($id){

		$rules=[
		 'nom_ajout'=>'required',
		 'adresse_ajout'=>'required',
		 'ville_ajout'=>'required',
		 'cp_ajout'=>'required',
		];
		$v =Validator::make(Input::all(),$rules);
			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{
				$test=DB::table('lieux')->select('nom','adresse')
				 	->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 	->where('nom','=',Input::get('nom_ajout'))
				 	->where('adresse','=',Input::get('adresse_ajout'))
				 	->get();
				 if(count($test)>0){
				 		return Redirect::back()->withInput()->with(['errors'=>['You have to specify a different name or adress for your location.']]);
				 }
				 else{
				 	$cle_l = Lieux::create(array('projet_id'=> Crypt::decrypt(Session::get('hash_id_project')),
									   'nom'=>Input::get('nom_ajout'),
									   'adresse'=>Input::get('adresse_ajout'),
									   'ville'=>Input::get('ville_ajout'),
									   'code_postal'=>Input::get('cp_ajout')
					));
				 	DB::table('lien_categories_lieux')
				 		->insert([
				 				'categorie_id'=>Crypt::decrypt(Session::get('category')),
				 				'lieux_id'=>$cle_l->id
				 			]);	
					return  Redirect::back()->withInput()->with(['success'=>'Successfully added !']);
				}
			}
		}

		public function getAllLieux(){
		$results=DB::table('lieux')->select('id','nom','adresse','ville','code_postal')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}
		public function action($id){

			if(Input::get('ajout_lieu')){	
				return $this->ajoute_lieux($id);
			}

			if(Input::get('ajout_lieu_enregistre')){
				$results=$this->getAllLieux();
				$n = count($results);
				for($i=1;$i<$n+1;$i++){
					if(Input::get('check_'.$i)==='yes'){
						$cle=$results[$i-1]->id;
						DB::table('lien_categories_lieux')
					 		->insert([
					 				'categorie_id'=>Crypt::decrypt(Session::get('category')),
					 				'lieux_id'=>$cle
					 			]);	
					 	
					}
				}
				return Redirect::back()->withInput()->with(['success'=>'Successfully added !']);
			}
		}


}