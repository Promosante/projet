<?php

class NotificationsController extends BaseController{
	
	public function index($success=NULL){

		$notifs_new = Notif::get_new_notifs();
		$notifs_old = Notif::get_read_notifs();

		return View::make('pages.divers.notifications')->with(['notifs_new'=>$notifs_new,
															   'notifs_old'=>$notifs_old,
																'i'=>0,
																'success'=>$success
																]);
	}

	public function action(){

		for($i=0;$i<Notif::get_nb_new_notifs();$i++){

			if(Input::get('marquer_lu_'.$i)){

				$notifs_new = Notif::get_new_notifs();
				$cle = $notifs_new[$i]->id;
				DB::table('notifications')
					->where('id','=',$cle)
					->update(['read_or_not'=>'read']);
				return $this->index();
			}

			if(Input::get('ok_'.$i)){
				$notifs_new = Notif::get_new_notifs();
				$cle = $notifs_new[$i]->id;
				DB::table('notifications')
					->where('id','=',$cle)
					->update(['read_or_not'=>'read']);
				return $this->index();
			}

			if(Input::get('accepter_'.$i)){
				return $this->accept($i);
			}

			if(Input::get('refuser_'.$i)){
				return $this->refuser($i);
			}
			
		}
		for($i=0;$i<count(Notif::get_read_notifs());$i++){
			if(Input::get('accepter2_'.$i)){
				return $this->accept2($i);
			}

			if(Input::get('accepter2_'.$i)){
				return $this->refuser2($i);
			}
		}
		
	}

	public function accept($i){

				$notifs_new = Notif::get_new_notifs();


				//compute keys :
				//member key
				$cle_m = DB::table('membres')
						->where('user_id','=',$notifs_new[$i]->source_id)
						->get();
				//others
				$data = $notifs_new[$i]->contenu;
				$cle_tab = explode(":",$data);
				//qulity and project key
				$cle_q=$cle_tab[1];
				$cle_p=$cle_tab[2];
				
				//processing activity key
				if(strlen($cle_tab[0])>0){
					$act_tmp = DB::table('activites')
						->where('nom','=',$cle_tab[0])
						->where('projet_id',Crypt::decrypt($cle_p))
						->get();
					$cle_a=$act_tmp[0]->id;
				}
				else{
					$cle_a=NULL;
				}
				//accept request :
				//1) link membre to project
				MembresProjets::create([
						'membre_id'=>$cle_m[0]->id,
						'projet_id'=>Crypt::decrypt($cle_p)
					 ]);
				//2) link member to activity
				MembresActivites::create([
						'membre_id'=>$cle_m[0]->id,
						'membre_status_pour_activite'=>$cle_q,
						'activite_id'=>$cle_a
						]);

				//3) Mark notification read
				$cle = $notifs_new[$i]->id;
				DB::table('notifications')
					->where('id','=',$cle)
					->update(['read_or_not'=>'answered',
							  'message'=>''.$notifs_new[$i]->message.' (vous avez accepté).']);

				//4) send notif to source into informing him
				$proj_nom =DB::table('projets')
					->where('id','=',Crypt::decrypt($cle_p))
					->get();

				Notif::send_notif_to(Auth::user()->id,$notifs_new[$i]->source_id,'info',['message'=>'Votre demande a été accepté, vous êtes associé au projet '.$proj_nom[0]->acronyme.'.']);



				return $this->index('Membre ajouté');
	}

	public function refuser($i){

		$notifs_new = Notif::get_new_notifs();
		$cle = $notifs_new[$i]->id;
			DB::table('notifications')
				->where('id','=',$cle)
				->update(['read_or_not'=>'answered',
						'message'=>''.$notifs_new[$i]->message.' (vous avez refusé).']);

		//4) send notif to source into informing him
		Notif::send_notif_to(Auth::user()->id,$notifs_new[$i]->source_id,'info',['message'=>'Votre demande a été refusé ...']);

		return $this->index('Membre refusé');
	}

	public function refuser2($i){

		$notifs_old = Notif::get_read_notifs();
		$cle = $notifs_old[$i]->id;
		DB::table('notifications')
				->where('id','=',$cle)
				->update(['read_or_not'=>'answered',
						'message'=>''.$notifs_new[$i]->message.' (vous avez refusé).']);

		//4) send notif to source into informing him
		Notif::send_notif_to(Auth::user()->id,$notifs_old[$i]->source_id,'info',['message'=>'Votre demande a été refusé ...']);

		return $this->index('Membre refusé');
	}

	public function accept2($i){

				$notifs_old = Notif::get_read_notifs();


				//compute keys :
				//member key
				$cle_m = DB::table('membres')
						->where('user_id','=',$notifs_old[$i]->source_id)
						->get();
				//others
				$data = $notifs_old[$i]->contenu;
				$cle_tab = explode(":",$data);
				//qulity and project key
				$cle_q=$cle_tab[1];
				$cle_p=$cle_tab[2];
				
				//processing activity key
				if(strlen($cle_tab[0])>0){
					$act_tmp = DB::table('activites')
						->where('nom','=',$cle_tab[0])
						->where('projet_id',Crypt::decrypt($cle_p))
						->get();
					$cle_a=$act_tmp[0]->id;
				}
				else{
					$cle_a=NULL;
				}
				//accept request :
				//1) link membre to project
				MembresProjets::create([
						'membre_id'=>$cle_m[0]->id,
						'projet_id'=>Crypt::decrypt($cle_p)
					 ]);
				//2) link member to activity
				MembresActivites::create([
						'membre_id'=>$cle_m[0]->id,
						'membre_status_pour_activite'=>$cle_q,
						'activite_id'=>$cle_a
						]);

				//3) Mark notification read
				$cle = $notifs_old[$i]->id;
				DB::table('notifications')
					->where('id','=',$cle)
					->update(['read_or_not'=>'answered',
							  'message'=>''.$notifs_old[$i]->message.' (vous avez accepté).']);

				//4) send notif to source into informing him
				$proj_nom =DB::table('projets')
					->where('id','=',Crypt::decrypt($cle_p))
					->get();

				Notif::send_notif_to(Auth::user()->id,$notifs_old[$i]->source_id,'info',['message'=>'Votre demande a été accepté, vous êtes associé au projet '.$proj_nom[0]->acronyme.'.']);



				return $this->index('Membre ajouté');
	}
}