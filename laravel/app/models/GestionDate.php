<?php

class GestionDate {
	

	public static function getMoisActuel(){
		$date=date("F");
		return GestionDate::convertMonth($date);
	}
	public static function getAnneeActuelle(){
		$date=date("Y");
		return $date;
	}
	public static function getJourNomActuel(){
		$date=date("l");
		return GestionDate::convertDay($date);
	}

	public static function getJourNbActuel(){
		$date=date("d");
		return $date;
	}

	public static function getJourNbAnneeActuel(){
		$date=date("z");
		return $date;
	}

	public static function getSemaineNbActuel(){
		$date=date("W");
		return $date;

	}
	public static function convertToEngDt($str){
		$var=explode('/',$str);
		//jj/mm/aaaa -> mm/jj/aaaa
		$date_eng = $var[1].'/'.$var[0].'/'.$var[2];
		return new DateTime($date_eng);
	}

	public static function convertMonth($str){
		$tab_mois_fr = ['January'=>'Janvier',
					'February'=>'Fevrier',
					'March'=>'Mars',
					'April'=>'Avril',
					'May'=>'Mai',
					'June'=>'Juin',
					'July'=>'Juillet',
					'August'=>'Aout',
					'September'=>'Septembre',
					'October'=>'Octobre',
					'November'=>'Novembre',
					'December'=>'Décembre'
						];
		return $tab_mois_fr[$str];
	}

	public static function convertDay($str){

		$tab_jours_fr = ['Monday'=>'Lundi',
						 'Tuesday'=>'Mardi',
						 'Wednesday'=>'Mercredi',
						 'Thursday'=>'Jeudi',
						 'Friday'=>'Vendredi',
						 'Saturday'=>'Samedi',
						 'Sunday'=>'Dimanche'
						];
		return $tab_jours_fr[$str];
	}

	public static function get_Nb_premierJ_mois_dans_annee($month){
			$y = date("Y");
			$tab_fr = [
					'Janvier'=>(new DateTime('01/01/'.$y))->format('z'),
					'Fevrier'=>(new DateTime('02/01/'.$y))->format('z'),
					'Mars'=>(new DateTime('03/01/'.$y))->format('z'),
					'Avril'=>(new DateTime('04/01/'.$y))->format('z'),
					'Mai'=>(new DateTime('05/01/'.$y))->format('z'),
					'Juin'=>(new DateTime('06/01/'.$y))->format('z'),
					'Juillet'=>(new DateTime('07/01/'.$y))->format('z'),
					'Aout'=>(new DateTime('08/01/'.$y))->format('z'),
					'Septembre'=>(new DateTime('09/01/'.$y))->format('z'),
					'Octobre'=>(new DateTime('10/01/'.$y))->format('z'),
					'Novembre'=>(new DateTime('11/01/'.$y))->format('z'),
					'Decembre'=>(new DateTime('12/01/'.$y))->format('z')
					];
			return $tab_fr[$month];
	}
		public static function get_Nb_Mois($month){
					$tab_fr = [
							'Janvier'=>1,
							'Fevrier'=>2,
							'Mars'=>3,
							'Avril'=>4,
							'Mai'=>5,
							'Juin'=>6,
							'Juillet'=>7,
							'Aout'=>8,
							'Septembre'=>9,
							'Octobre'=>10,
							'Novembre'=>11,
							'Decembre'=>12
							];
				return $tab_fr[$month];
			}

	public static function get_Nb_dernierJ_mois_dans_annee($month){
			$y = date("Y");
			$tab_fr = [
					'Janvier'=>(new DateTime('01/'.date("t",01).'/'.$y))->format('z'),
					'Fevrier'=>(new DateTime('02/'.date("t",02).'/'.$y))->format('z'),
					'Mars'=>(new DateTime('03/'.date("t",03).'/'.$y))->format('z'),
					'Avril'=>(new DateTime('04/'.date("t",04).'/'.$y))->format('z'),
					'Mai'=>(new DateTime('05/'.date("t",05).'/'.$y))->format('z'),
					'Juin'=>(new DateTime('06/'.date("t",06).'/'.$y))->format('z'),
					'Juillet'=>(new DateTime('07/'.date("t",07).'/'.$y))->format('z'),
					'Aout'=>(new DateTime('08/'.date("t",08).'/'.$y))->format('z'),
					'Septembre'=>(new DateTime('09/'.date("t",09).'/'.$y))->format('z'),
					'Octobre'=>(new DateTime('10/'.date("t",10).'/'.$y))->format('z'),
					'Novembre'=>(new DateTime('11/'.date("t",11).'/'.$y))->format('z'),
					'Decembre'=>(new DateTime('12/'.date("t",12).'/'.$y))->format('z')
					];
			return $tab_fr[$month];
	}

	public static function get_Timestamp_dernier_jour_du_mois($month,$y){
			
			$tab_fr = [
					'Janvier'=>(new DateTime('01/'.date("t",01).'/'.$y))->getTimestamp(),
					'Fevrier'=>(new DateTime('02/'.date("t",02).'/'.$y))->getTimestamp(),
					'Mars'=>(new DateTime('03/'.date("t",03).'/'.$y))->getTimestamp(),
					'Avril'=>(new DateTime('04/'.date("t",04).'/'.$y))->getTimestamp(),
					'Mai'=>(new DateTime('05/'.date("t",05).'/'.$y))->getTimestamp(),
					'Juin'=>(new DateTime('06/'.date("t",06).'/'.$y))->getTimestamp(),
					'Juillet'=>(new DateTime('07/'.date("t",07).'/'.$y))->getTimestamp(),
					'Aout'=>(new DateTime('08/'.date("t",08).'/'.$y))->getTimestamp(),
					'Septembre'=>(new DateTime('09/'.date("t",09).'/'.$y))->getTimestamp(),
					'Octobre'=>(new DateTime('10/'.date("t",10).'/'.$y))->getTimestamp(),
					'Novembre'=>(new DateTime('11/'.date("t",11).'/'.$y))->getTimestamp(),
					'Decembre'=>(new DateTime('12/'.date("t",12).'/'.$y))->getTimestamp()
					];
			return $tab_fr[$month];
	}

	public static function get_Timestamp_premier_jour_du_mois($month,$y){
			$y = date("Y");
			$tab_fr = [
					'Janvier'=>(new DateTime('01/01/'.$y))->getTimestamp(),
					'Fevrier'=>(new DateTime('02/01/'.$y))->getTimestamp(),
					'Mars'=>(new DateTime('03/01/'.$y))->getTimestamp(),
					'Avril'=>(new DateTime('04/01/'.$y))->getTimestamp(),
					'Mai'=>(new DateTime('05/01/'.$y))->getTimestamp(),
					'Juin'=>(new DateTime('06/01/'.$y))->getTimestamp(),
					'Juillet'=>(new DateTime('07/01/'.$y))->getTimestamp(),
					'Aout'=>(new DateTime('08/01/'.$y))->getTimestamp(),
					'Septembre'=>(new DateTime('09/01/'.$y))->getTimestamp(),
					'Octobre'=>(new DateTime('10/01/'.$y))->getTimestamp(),
					'Novembre'=>(new DateTime('11/01/'.$y))->getTimestamp(),
					'Decembre'=>(new DateTime('12/01/'.$y))->getTimestamp()
					];
			return $tab_fr[$month];
	}

	public static function get_Nb_Year($day){
		return (new DateTime($day))->format('z');
	}
}