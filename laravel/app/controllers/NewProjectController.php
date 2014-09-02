<?php

class NewProjectController extends BaseController{
	
	public function index(){
		return View::make('pages.projet.newproject');
	}

	public function createnew(){
		
		$rules=[
		 'nomprojet'=>'required',
		 'acronyme'=>'required',
		 'objectif'=>'required',
		 'objectif_specifique'=>'required',
		 'population_cible'=>'required',
		 'date_debut'=>'required|date_format:j/n/Y',
		 'date_fin'=>'required|date_format:j/n/Y'
		];
		$v =Validator::make(Input::all(),$rules);
		if( $v->fails()){ 
			$messages = $v->messages();
			return Redirect::back()->withInput()->with(['errors'=>$messages]);
		}
		else{
				$date_deb = new DateTime(Input::get('date_debut'));
				$date_fin = new DateTime(Input::get('date_fin'));

				$param=[
					'titre'=> Input::get('nomprojet'),
					'acronyme'=> Input::get('acronyme'),
					'createur_id' => Auth::user()->id,
					'objectif'=> Input::get('objectif'),
					'objectif_specifique'=> Input::get('objectif_specifique'),
					'population_cible'=> Input::get('population_cible'),
					'date_debut'=>$date_deb,
		 			'date_fin'=>$date_fin,
		 			'status_createur'=>'created'
					];

				Projets::create($param);

				$ind=DB::table('projets')
					->where('createur_id','=',Auth::user()->id)
					->get();
				$index=count($ind);
			return Redirect::to('my-projects/'.$index)->with(['success'=> 'Successfully created !']);
			}

	}
}