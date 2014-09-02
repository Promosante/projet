<?php

class NotationController extends BaseController{
	
	public function index($id,$success=NULL){


		$expertises = $this->get_expertises();
		$experts_associes = $this->get_experts_prevu_par_exp();
		$periodes_associees=$this->get_periodes_definies();
		$notes_par_exp = $this->get_notes_par_expertises_par_cat();
		$moyennes = $this->get_moyennes_notes_par_expertises_par_cat();

		return View::make('pages.projet.notation')->with([
												'success'=>$success,
												'id'=>$id,
												'expertises'=>$expertises,
												'experts_associes'=>$experts_associes,
												'periodes_associees'=>$periodes_associees,
												'notes_par_exp'=>$notes_par_exp,
												'moyennes'=>$moyennes
												]);
	}

	public function get_expertises(){

		$res=DB::table('expertises')
			->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		return $res;
	}

	public function get_experts_prevu_par_exp(){

		$exp = $this->get_expertises();
		$res=[];
		for($i=0;$i<count($exp);$i++){
			$res[$i]=[];
			$res[$i]=DB::table('lien_experts_expertises')
					->leftJoin('membres','membres.id','=','lien_experts_expertises.membre_id')
					->select('membres.nom as nom','membres.prenom as prenom','membres.fonction as fonction','membres.structure as structure','membres.ville as ville')
					->where('expertise_id','=',$exp[$i]->id)
					->get();
		}
		return $res;
	}

	public function get_periodes_definies(){
		$exp=$this->get_expertises();
		$res=[];
		for($i=0;$i<count($exp);$i++){
			$res[$i]=[];
			$res[$i]=DB::table('expertises_periodes')
					->where('expertise_id','=',$exp[$i]->id)
					->get();
		}
		return $res;
	}

	public function get_notes_par_expertises_par_cat(){

		$exp=DB::table('expertises')
			->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		$res=[];

		for($i=0;$i<count($exp);$i++){
			$res[$i]=[];
			$res[$i]['qt_p']=[];
			$res[$i]['ql_p']=[];
			$res[$i]['qt_r']=[];
			$res[$i]['ql_r']=[];

			$notes = DB::table('resultats_expertise')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
				->where('expertise_id','=',$exp[$i]->id)
				->get();

			for($j=0;$j<count($notes);$j++){
				$res[$i]['qt_p'][$j]=$notes[$j]->note_quant_part;
				$res[$i]['ql_p'][$j]=$notes[$j]->note_qual_part;
				$res[$i]['qt_r'][$j]=$notes[$j]->note_quant_real;
				$res[$i]['ql_r'][$j]=$notes[$j]->note_qual_real;
			}
		}

		return $res;
	}

	public function get_moyennes_notes_par_expertises_par_cat(){

		$exp=DB::table('expertises')
			->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		$res=[];
		$moy = [];

		for($i=0;$i<count($exp);$i++){
			$res[$i]=[];
			$res[$i]['qt_p']=[];
			$res[$i]['ql_p']=[];
			$res[$i]['qt_r']=[];
			$res[$i]['ql_r']=[];

			
			$moy[$i]['qt_p']=0;
			$moy[$i]['ql_p']=0;
			$moy[$i]['qt_r']=0;
			$moy[$i]['ql_r']=0;

			$notes = DB::table('resultats_expertise')
				->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
				->where('expertise_id','=',$exp[$i]->id)
				->get();

			for($j=0;$j<count($notes);$j++){
				$res[$i]['qt_p'][$j]=$notes[$j]->note_quant_part;
				$res[$i]['ql_p'][$j]=$notes[$j]->note_qual_part;
				$res[$i]['qt_r'][$j]=$notes[$j]->note_quant_real;
				$res[$i]['ql_r'][$j]=$notes[$j]->note_qual_real;
			}
			$denom_qt_p=0;
			$somme_qt_p=0;

			$denom_ql_p=0;
			$somme_ql_p=0;

			$denom_qt_r=0;
			$somme_qt_r=0;

			$denom_ql_r=0;
			$somme_ql_r=0;

			for($j=0;$j<count($notes);$j++){

				if(is_numeric($res[$i]['qt_p'][$j] ) ){
					$denom_qt_p++;
					$somme_qt_p = $somme_qt_p + (int) $res[$i]['qt_p'][$j];
				}
				if(is_numeric($res[$i]['ql_p'][$j] ) ){
					$denom_ql_p++;
					$somme_ql_p = $somme_ql_p + (int) $res[$i]['ql_p'][$j];
				}
				if(is_numeric($res[$i]['qt_r'][$j] ) ){
					$denom_qt_r++;
					$somme_qt_r = $somme_qt_r + (int) $res[$i]['qt_r'][$j];
				}
				if(is_numeric($res[$i]['ql_r'][$j] ) ){
					$denom_ql_r++;
					$somme_ql_r = $somme_ql_r + (int) $res[$i]['ql_r'][$j];
				}
			}

			if($denom_qt_p>0){
				$moy[$i]['qt_p']=($somme_qt_p*100)/$denom_qt_p;
			}
			else{
				$moy[$i]['qt_p']=-100;
			}

			if($denom_ql_p>0){
				$moy[$i]['ql_p']=($somme_ql_p*100)/$denom_ql_p;
			}
			else{
				$moy[$i]['ql_p']=-100;
			}

			if($denom_qt_r>0){
				$moy[$i]['qt_r']=($somme_qt_r*100)/$denom_qt_r;
			}
			else{
				$moy[$i]['qt_r']=-100;
			}
			
			if($denom_ql_r>0){
				$moy[$i]['ql_r']=($somme_ql_r*100)/$denom_ql_r;
			}
			else{
				$moy[$i]['ql_r']=-100;
			}

			$moy[$i]['qt_p']=$moy[$i]['qt_p']/100;
			$moy[$i]['ql_p']=$moy[$i]['ql_p']/100;
			$moy[$i]['qt_r']=$moy[$i]['qt_r']/100;
			$moy[$i]['ql_r']=$moy[$i]['ql_r']/100;

		}

		return $moy;
	}

}