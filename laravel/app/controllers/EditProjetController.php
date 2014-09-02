<?php
class EditProjetController extends BaseController{
	
	public function index($id){
		$results=DB::table('projets')
					->join('users','users.id','=','projets.createur_id')
					->where('users.id','=',Auth::user()->id)
					->where('projets.status_createur','=','created')
					->get();

		$proj = $results[$id-1];
		$date1 = new DateTime($proj->date_debut);
		$proj->date_debut=$date1->format('d/m/Y');
		$date2 = new DateTime($proj->date_fin);
		$proj->date_fin=$date2->format('d/m/Y');
		return View::make('pages.projet.projects-edit')->with(['results' => $proj,'id'=>$id]);
	}

	public function edit($id){
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

				DB::table('projets')
					->where('id','=',Crypt::decrypt(Session::get('hash_id_project')))
					->update([
					'titre'=> Input::get('nomprojet'),
					'acronyme'=> Input::get('acronyme'),
					'objectif'=> Input::get('objectif'),
					'objectif_specifique'=> Input::get('objectif_specifique'),
					'population_cible'=> Input::get('population_cible'),
					'date_debut'=>$date_deb,
		 			'date_fin'=>$date_fin,
				]);
			return Redirect::to('my-projects/'.$id)->with(['success'=> 'Successfully updated !']);
			}

	}

	public function post_comment($id){

		if(Input::get('ajout_com')){

			$msg = Input::get('comment');

			CommentsProjet::create([
				'contenu'=>$msg,
				'source_id'=>Auth::user()->id,
				'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
				]);

			return Redirect::back();
		}
	}
}