<?php

class CalendrierController extends BaseController{
	
	public function index($id,$month=NULL,$year=NULL){

		$mois_actuel = GestionDate::getMoisActuel();
		$jour_actuel = GestionDate::getJourNomActuel();
		$jour_nb_actuel = GestionDate::getJourNbActuel();
		$jour_nb_annee_actuel = GestionDate::getJourNbAnneeActuel();
		$semaine_actuel=GestionDate::getSemaineNbActuel();

		if(!isset($month)){$month=GestionDate::getMoisActuel();}
		if(!isset($year)){$year=GestionDate::getAnneeActuelle();}

		$activites = $this->get_activites($year);
		$periodes_associees = $this->get_periodes($year);
		$segments = $this->compute_graphics4($month,$year);
		$segments2 = $this->compute_graphics5($month,$year);
		$intervenants = $this->get_intervenants_associes($year);
		$segments3 = $this->compute_graphics6($month,$year);
		$evenements_associes = $this->get_eve_associes($month,$year);


		return View::make('pages.projet.Calendrier')->with(['id' => $id,
															'jour_actuel'=>$jour_actuel,
															'mois_actuel'=>$mois_actuel,
															'jour_nb_actuel'=>$jour_nb_actuel,
					 										'jour_nb_annee_actuel'=>$jour_nb_annee_actuel,
															'semaine_actuel'=>$semaine_actuel,
															'activites'=>$activites,
															'periodes_associees'=>$periodes_associees,
															'mois_sel'=>$month,
															'annee_sel'=>$year,
															'segments'=>$segments,
															'intervenants'=>$intervenants,
															'i'=>0,
															'k'=>0,
															'success'=>NULL,
															'segments2'=>$segments2,
															'segments3'=>$segments3,
															'evenements_associes'=>$evenements_associes
															]);
	}
 
 	public function get_intervenants_associes($year){

 		$activites = $this->get_activites($year);
 		$inter_associes=[];

 		for($i=0;$i<count($activites);$i++){

 			$cle=$activites[$i]->id;
 			$res =DB::table('lien_membres_activites')
 				->leftJoin('membres','membres.id','=','lien_membres_activites.membre_id')
 				->select('membres.nom as nom','membres.prenom as prenom','membres.fonction as fonction')
 				->where('lien_membres_activites.activite_id','=',$cle)
 				->where('lien_membres_activites.membre_status_pour_activite','=','Intervenant')
 				->get();
 			$inter_associes[$i] = $res;
 		}
 		return $inter_associes;
 	}

	//from activite controller
	public function get_activites($year){
		$all =$this->get_act_aux($year);
		for($i=0;$i<count($all);$i++){
			$all[$i]->date_debut=(new DateTime($all[$i]->date_debut))->format('j/n/Y');
			$all[$i]->date_fin=(new DateTime($all[$i]->date_fin))->format('j/n/Y');
		}
		return $all;
	}

	public function get_act_aux($year){
		$all = DB::table('activites')
				->select('nom','objectif','date_debut','date_fin','id')
				->where('id','<',0);

		//commence pdt a l'année $year et se termine l'année $year+1
		$aux_1 = DB::table('activites')
				->select('nom','objectif','date_debut','date_fin','id')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
				->where('date_debut','>=',$year.'-01-01')
				->where('date_debut','<',($year+1).'-01-01')
				->where('date_fin','>',($year+1).'-01-01');

		$all=$all->unionAll($aux_1);

		//termine pdt a l'année $year et a commencé l'année $year-1
		$aux_2 = DB::table('activites')
				->select('nom','objectif','date_debut','date_fin','id')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
				->where('date_fin','>=',$year.'-01-01')
				->where('date_fin','<',($year+1).'-01-01')
				->where('date_debut','<',$year.'-01-01');

		$all=$all->unionAll($aux_2);

		//commence $year-1 et termine $year+1
		$aux_3 = DB::table('activites')
				->select('nom','objectif','date_debut','date_fin','id')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
				->where('date_debut','<=',$year.'-01-01')
				->where('date_fin','>=',($year+1).'-01-01');	

		$all=$all->unionAll($aux_3);

		//commence et termine pdt $year
		$aux_4 = DB::table('activites')
				->select('nom','objectif','date_debut','date_fin','id')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
				->where('date_debut','>=',$year.'-01-01')
				->where('date_fin','<=',($year+1).'-01-01');

		$all=$all->unionAll($aux_4);

		$all=$all->distinct()->get();

		return $all;		
	}

	public function get_periodes($year){
		$all =$this->get_act_aux($year);

		$periodes=[];
		for($i=0;$i<count($all);$i++){

			$act_id=$all[$i]->id;

			$periode_buf = DB::table('periodes')
				->where('activite_id','=',$act_id)
				->get();
			$periodes[$i]=$periode_buf;
		}
		
		return $periodes;
	}

	public function get_eve_associes($month,$year){
		$result=[];
		$activites  = $this->get_act_aux($year);
		for($i=0;$i<count($activites);$i++){
			$result[$i]=[];
			$periodes =DB::table('periodes')
						->where('activite_id','=', $activites[$i]->id)
						->get();
			for($j=0;$j<count($periodes);$j++){
				$result[$i][$j]=[];
				$evenements =DB::table('evenements')
						->leftJoin('lieux','lieux.id','=','evenements.lieu_id')
						->select('evenements.date_fin as date_fin','evenements.date_debut as date_debut','lieux.nom as nom','lieux.adresse as adresse')
						->where('periode_id','=', $periodes[$j]->id)
						->get();
				for($k=0;$k<count($evenements);$k++){		
					$result[$i][$j][$k] = $evenements[$k];
					
				}
			}
		}
		return $result;
	}


	public function compute_graphics4($month,$year){
		$result=[];
		$premier_jour = GestionDate::get_Timestamp_premier_jour_du_mois($month,$year);
		$dernier_jour = GestionDate::get_Timestamp_dernier_jour_du_mois($month,$year);

		//nombre de jours dans le mois
		$denom = $dernier_jour - $premier_jour ;

		$activites  = $this->get_act_aux($year);

		for($i=0;$i<count($activites);$i++){
			$result[$i]=[];

			$debut_a =  (new DateTime( $activites[$i]->date_debut ))->getTimestamp();
			$fin_a =  (new DateTime($activites[$i]->date_fin))->getTimestamp();
			
				//calcul premier blanc
				$p_blanc = (($debut_a - $premier_jour )*100)/$denom;
				//calcul premier blanc
				//calcul dernier blanc
				$d_blanc = (($dernier_jour  - $fin_a   )*100)/$denom;

				if($p_blanc>100){$p_blanc=100;}
				if( ($p_blanc<0) && ($fin_a<$premier_jour) ){$p_blanc=100;}
				if( ($p_blanc<0) && ($fin_a>$premier_jour) ){$p_blanc=0;}

				if($d_blanc>100){$d_blanc=0;}

				if(($d_blanc<0) && ($debut_a<$dernier_jour)){$d_blanc=0;}
				if(($d_blanc<0) && ($debut_a>$dernier_jour)){$d_blanc=100;}

				$taille = 100 - $p_blanc - $d_blanc;

				if($taille>100){$taille=100;}
				if($taille<0){$taille=100;}

				$result[$i][0] = $p_blanc;
				$result[$i][1] = $taille;
				$result[$i][2] = $d_blanc;
			}
		return $result;
	}


	public function compute_graphics5($month,$year){
		$result=[];
		$premier_jour = GestionDate::get_Timestamp_premier_jour_du_mois($month,$year);
		$dernier_jour = GestionDate::get_Timestamp_dernier_jour_du_mois($month,$year);

		//nombre de jours dans le mois
		$denom = $dernier_jour - $premier_jour;

		$activites  = $this->get_act_aux($year);

		for($i=0;$i<count($activites);$i++){
			$result[$i]=[];
			$periodes =DB::table('periodes')
						->where('activite_id','=', $activites[$i]->id)
						->get();

			for($j=0;$j<count($periodes);$j++){

				$result[$i][$j]=[];

				$debut_p =  ( new DateTime($periodes[$j]->date_debut  ))->getTimestamp();
				$fin_p =  ( new DateTime($periodes[$j]->date_fin ))->getTimestamp();
			
				//calcul premier blanc
				$p_blanc = (($debut_p - $premier_jour )*100)/$denom;
				//calcul premier blanc
				//calcul dernier blanc
				$d_blanc = (($dernier_jour  - $fin_p   )*100)/$denom;

				if($p_blanc>100){$p_blanc=100;}
				if( ($p_blanc<0) && ($fin_p<$premier_jour) ){$p_blanc=100;}
				if( ($p_blanc<0) && ($fin_p>$premier_jour) ){$p_blanc=0;}

				if($d_blanc>100){$d_blanc=0;}

				if(($d_blanc<0) && ($debut_p<$dernier_jour)){$d_blanc=0;}
				if(($d_blanc<0) && ($debut_p>$dernier_jour)){$d_blanc=100;}

				$taille = 100 - $p_blanc - $d_blanc;

				if($taille>100){$taille=100;}
				if($taille<0){$taille=100;}

				$result[$i][$j][0] = $p_blanc;
				$result[$i][$j][1] = $taille;
				$result[$i][$j][2] = $d_blanc;
			}
		}
		return $result;
	}


	public function compute_graphics6($month,$year){
		$result=[];
		$activites  = $this->get_act_aux($year);

		for($i=0;$i<count($activites);$i++){
			$result[$i]=[];
			$periodes =DB::table('periodes')
						->where('activite_id','=', $activites[$i]->id)
						->get();

			for($j=0;$j<count($periodes);$j++){

				$result[$i][$j]=[];
				$evenements =DB::table('evenements')
						->where('periode_id','=', $periodes[$j]->id)
						->get();

				for($k=0;$k<count($evenements);$k++){		
					
					$dernier_jour = (new DateTime($periodes[$j]->date_fin))->getTimestamp();
					$premier_jour = (new DateTime($periodes[$j]->date_debut))->getTimestamp();
					
					$denom = $dernier_jour - $premier_jour;

					$debut_e =  ( new DateTime($evenements[$k]->date_debut  ))->getTimestamp();
					$fin_e =  ( new DateTime($evenements[$k]->date_fin ))->getTimestamp();
				
					//calcul premier blanc
					$p_blanc = (($debut_e - $premier_jour )*100)/$denom;
					//calcul premier blanc
					//calcul dernier blanc
					$d_blanc = (($dernier_jour  - $fin_e   )*100)/$denom;

					if($p_blanc>100){$p_blanc=100;}
					if( ($p_blanc<0) && ($fin_e<$premier_jour) ){$p_blanc=100;}
					if( ($p_blanc<0) && ($fin_e>$premier_jour) ){$p_blanc=0;}

					if($d_blanc>100){$d_blanc=0;}

					if(($d_blanc<0) && ($debut_e<$dernier_jour)){$d_blanc=0;}
					if(($d_blanc<0) && ($debut_e>$dernier_jour)){$d_blanc=100;}

					$taille = 100 - $p_blanc - $d_blanc;

					if($taille>100){$taille=100;}
					if($taille<0){$taille=100;}

					$result[$i][$j][$k][0] = $p_blanc;
					$result[$i][$j][$k][1] = $taille;
					$result[$i][$j][$k][2] = $d_blanc;
				}
			}
		}
		return $result;
	}




	public function action($id){
		if(Input::get('janvier')) {
			return $this->index($id,'Janvier',Input::get('annee_sel'));
		}
		if(Input::get('fevrier')) {
			return $this->index($id,'Fevrier',Input::get('annee_sel'));
		}
		if(Input::get('mars')) {
			return $this->index($id,'Mars',Input::get('annee_sel'));
		}
		if(Input::get('avril')) {
			return $this->index($id,'Avril',Input::get('annee_sel'));
		}
		if(Input::get('mai')) {
			return $this->index($id,'Mai',Input::get('annee_sel'));
		}
		if(Input::get('juin')) {
			return $this->index($id,'Juin',Input::get('annee_sel'));
		}
		if(Input::get('juillet')) {
			return $this->index($id,'Juillet',Input::get('annee_sel'));
		}
		if(Input::get('aout')) {
			return $this->index($id,'Aout',Input::get('annee_sel'));
		}
		if(Input::get('septembre')) {
			return $this->index($id,'Septembre',Input::get('annee_sel'));
		}
		if(Input::get('octobre')) {
			return $this->index($id,'Octobre',Input::get('annee_sel'));
		}
		if(Input::get('novembre')) {
			return $this->index($id,'Novembre',Input::get('annee_sel'));
		}
		if(Input::get('decembre')) {
			return $this->index($id,'Decembre',Input::get('annee_sel'));
		}
		if(Input::get('annee_moins')){
			return $this->index($id,'Janvier',Input::get('annee_sel')-1);
		}
		if(Input::get('annee_plus')){
			return $this->index($id,'Janvier',Input::get('annee_sel')+1);
		}
	}
}