<?php

class AdminMembresController extends BaseController{
	
	public function index($msg=NULL){

		$allMembres=$this->getAllMembres();
		$infos_en_rab = $this->getInfoEnRab();

		

		return View::make('pages.admin.membres')->with([
														'membres'=>$allMembres,
														'infoenplus'=>$infos_en_rab,
														'success'=>$msg
														]);
	}


public function getAllMembres(){

	$all=DB::table('membres')
		->get();
	return $all; 

}

public function getInfoEnRab(){

	$allMembres=$this->getAllMembres();
	$n=count($allMembres);

	for($i=0;$i<$n;$i++){
		
		if($allMembres[$i]->user_id == NULL){
			$infos_en_rab[$i]['compte'] = 'Non';
		}
		else{
			$infos_en_rab[$i]['compte'] = 'Oui';
		}

		if( count( DB::table('administrateurs')->where('compte_id','=',$allMembres[$i]->user_id)->get() ) >0 ){
			$infos_en_rab[$i]['admin'] = 'Oui';
		}
		else{
			$infos_en_rab[$i]['admin'] = 'Non';
		}
	}

	return $infos_en_rab;
}

	public function action(){

		if(Input::get('elever')){
			$membres = $this->getAllMembres();
			$n=count($membres);
			for($i=1;$i<$n+1;$i++){
				if(Input::get('check_'.$i)){
					$cle=$membres[$i-1]->user_id;
					Admin::create([
						'compte_id'=>$cle,
						'nom'=>'Another admin !'
					]);
				}
			}
			return $this->index('Effectué !');
		}
		

		if(Input::get('retrograde')){
			if( count(DB::table('administrateurs')->where('compte_id','=',Auth::user()->id)->where('id','=',1)->get())>0){
				$membres = $this->getAllMembres();
				$n=count($membres);
				for($i=1;$i<$n+1;$i++){
					if(Input::get('check_'.$i)){
						$cle=$membres[$i-1]->user_id;

						DB::table('administrateurs')
							->where('compte_id','=',$cle)
							->delete();
					}
				}
				return $this->index('Effectué !');
			}
			else{
				return Redirect::to('forbidden');
			}
		}

		if(Input::get('supprime_compte')){
			$membres = $this->getAllMembres();
			$n=count($membres);
			for($i=1;$i<$n+1;$i++){
				if(Input::get('check_'.$i)){
					$id_user = $membres[$i-1]->user_id;
					$id_membre = $membres[$i-1]->id;

					$projets= DB::table('projets')
						->where('createur_id','=',$id_user)
						->get();

					for($p=0; $p < count($projets); $p++){
						$id_projo = $projets[$i]->id;


						


					}
					
				}
			}
			return $this->index('Effectué !');
		}

	} 
}