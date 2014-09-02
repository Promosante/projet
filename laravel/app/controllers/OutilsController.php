<?php

class OutilsController extends BaseController{
	
	public function index($id,$success=NULL){

		return View::make('pages.projet.gestionOutils')->with(['id'=>$id,'success'=>$success]);
	}

	public function action($id){

		if(Input::get('ajout_outils')){
			if(Input::get('questionnaire')==='yes'){

				$rules=['nom_ajout'=>'required|unique:outils,nom'];

				$v =Validator::make(Input::all(),$rules);

				if( $v->fails()){ 
					$messages = $v->messages();
					return Redirect::back()->withInput()->with(['errors'=>$messages]);
					}
				else{
					$o=Outils::create([
						'nom'=>Input::get('nom_ajout'),
						'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
						]);

					Session::forget('tool');
					Session::put('tool',Crypt::encrypt($o->id));

					return $this->AccueilQuestionnaire($id,'Successfully added !');
					}
			}
		}

		if(Input::get('pdf')){
			return $this->generer_pdf_questionnaire($id);
		}

		if(Input::get('save_q')){
			return $this->sauver_questionnaire($id);
		}
		if(Input::get('consulter')){
			return $this->show_mes_outils($id);
		}

		$buff = DB::table('outils')
			->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
			->get();

		for($i=0;$i<count($buff);$i++){

			if(Input::get('supprime_'.$i)){

				$b=DB::table('questionnaires')
					->where('outil_id','=',$buff[$i]->id)
					->get();

				
				if( count($b>0) ) {
					$id_questionnaire = $b[0]->id;

					$b2=DB::table('questions')
						->where('questionnaire_id','=',$id_questionnaire)
						->get();

					for($j=0;$j<count($b2);$j++){

						$id_question = $b2[$j]->id;

						DB::table('reponses')
							->where('question_id','=',$id_question)
							->delete();
					}

					DB::table('questions')
						->where('questionnaire_id','=',$id_questionnaire)
						->delete();

					DB::table('questionnaires')
						->where('id','=',$id_questionnaire)
						->delete();

					DB::table('outils')
						->where('id','=',$buff[$i]->id)
						->delete();

					return Redirect::back()->with(['success'=> 'Successfully deleted !']);
				}
				else{
					DB::table('outils')
						->where('id','=',$buff[$i]->id)
						->delete();
					return Redirect::back()->with(['success'=> 'Successfully deleted !']);	
				}
			}

			if(Input::get('pdf_'.$i)){

				$q=DB::table('questionnaires')
					->where('outil_id','=',$buff[$i]->id)
					->get();

				return $this->generer_pdf_questionnaire_2($id,$q[0]->id);
			}

		}
		

	} 

	public function AccueilQuestionnaire($id){
		return View::make('pages.projet.creationQuestionnaire')->with(['id'=>$id,'success'=>NULL]);
	}


	public function show_mes_outils($id){

		$result = DB::table('outils')
			->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
			->get();

		$infos=[];

		for($i=0;$i<count($result);$i++){

			$buff=DB::table('questionnaires')
				->where('outil_id','=',$result[$i]->id)
				->get();

			if(count($buff)>0){
				$infos[$i][0]='questionnaire';
				$infos[$i][1]=$buff;
			}
			else{
				$infos[$i][0]='NC';
				$infos[$i][1]=$buff;
			}
		}


		return View::make('pages.projet.MesOutils')->with(['id'=>$id,'success'=>NULL,
														'outils'=>$result,'infos'=>$infos]);
	}

	public function generer_pdf_questionnaire($id){

		$questions=[];
		$reponses=[];

		$i_i=0;
		$j_j=0;

		$n=count(Input::all());

		for($i=0;$i<$n;$i++){
			if(Input::get('question_'.$i)){
				$questions[$i_i]=Input::get('question_'.$i);
				
				$reponses[$i_i]=[];
				for($j=0;$j<$n;$j++){
					if(Input::get('q_'.$i.'_reponse_'.$j)){
						$reponses[$i_i][$j_j] = Input::get('q_'.$i.'_reponse_'.$j);
						echo '<script>console.log("'.$reponses[$i_i][$j_j][0].'");</script>';
						$j_j++;
					}
				}
				$j_j=0;
				$i_i++;
			}
		}


		require($_SERVER['DOCUMENT_ROOT'].'/PDF_stuff/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',16);
		for($i=0;$i<count($questions); $i++){
			$pdf->MultiCell(0,10,$questions[$i][0],0);
			if(count($reponses[$i])==0){
				$pdf->MultiCell(0,30,'',0);
			}
		}

		$pdf->Output("app/pdf/test.pdf","F");

		$file_path = "app/pdf/test.pdf";
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file_path));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: '.filesize($file_path));
		ob_clean();
		flush();
		readfile($file_path);

	}
	public function generer_pdf_questionnaire_2($id,$q_id=NULL){
		

		$reponses=[];
		$questions = DB::table('questions')
			->where('questionnaire_id','=',$q_id)
			->get();

		for($i=0;$i<count($questions);$i++){
			$cle_q = $questions[$i]->id;
			$reponses[$i]=[];

			$r=DB::table('reponses')
				->where('question_id','=',$cle_q )
				->get();

			$reponses[$i]=$r;

		}
		require($_SERVER['DOCUMENT_ROOT'].'/PDF_stuff/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',16);
		for($i=0;$i<count($questions); $i++){
			$pdf->MultiCell(0,10,$questions[$i]->question,0);
			if(count($reponses[$i])==0){
				$pdf->MultiCell(0,30,'',0);
			}
			else{
				for($j=0;$j<count($reponses[$i]); $j++){
					$pdf->MultiCell(0,10,$reponses[$i][$j]->reponse,0);
				}
			}
		}

		$pdf->Output("app/pdf/test.pdf","F");

		$file_path = "app/pdf/test.pdf";
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file_path));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: '.filesize($file_path));
		ob_clean();
		flush();
		readfile($file_path);
	}

	public function sauver_questionnaire($id){
		
		$questions=[];
		$reponses=[];
		$i_i=0;
		$j_j=0;

		$n=count(Input::all());
		for($i=0;$i<$n;$i++){
			if(Input::get('question_'.$i)){
				$questions[$i_i]=Input::get('question_'.$i);
				$reponses[$i_i]=[];
				for($j=0;$j<$n;$j++){
					if(Input::get('q_'.$i.'_reponse_'.$j)){
						$reponses[$i_i][$j_j] = Input::get('q_'.$i.'_reponse_'.$j);
						$j_j++;
					}
				}
				$j_j=0;
				$i_i++;
			}
		}

		$q=Questionnaire::create([
				'outil_id'=>Crypt::decrypt(Session::get('tool')),
				'titre'=>Input::get('titre_q')
			]);
		for($i=0;$i<count($questions);$i++){
			$qq=Questions::create([
					'questionnaire_id'=>$q->id,
					'question'=>$questions[$i][0]
				]);
			for($j=0;$j<count($reponses[$i]);$j++){
				Reponses::create([
						'question_id'=>$qq->id,
						'reponse'=>$reponses[$i][$j][0]
						]);
				}
		}
		return $this->index($id,'Questionnaire créé !');
	}

}