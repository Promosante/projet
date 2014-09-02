<?php

class ProjectsLieuxController extends BaseController{
	
	public function index($id,$success=NULL){

		$results=$this->getLieux();
		return View::make('pages.projet.gestionLieux')
				->with(['results'=>$results,'i'=>0,'id'=>$id,'success'=>$success]);
	}


	public function getLieux(){
		$results=DB::table('lieux')
				->select('id','nom','adresse','ville','code_postal','ressources_humaines',
					'ressources_materielles','telephone','created_at')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();
		return $results;
	}

	public function action($id){

		if(Input::get('ajout_lieu')){	
				return $this->ajoute_lieux($id);
			}

		if(Input::get('supp_lieu')){
			$results=$this->getLieux();
			$n=count($results);
			for($i=1;$i<$n+1;$i++){
				if(Input::get('check_lieu_'.$i)==='yes'){
					$cle=$results[$i-1]->id;
					DB::table('lieux')
						->where('id','=',$cle)
						->delete();
				}
			}
			return $this->index($id);
		}
		if(Input::get('down_lieu')){
			return $this->download_csv($id);
		}

		if(Input::get('upload_csv')){
				return $this->upload_csv($id);
			}
	}

	public function upload_csv($id){

		$destinationPath = '';
    	$filename        = '';

    	if (Input::hasFile('fichier')) {
       		$file            = Input::file('fichier');
        	$destinationPath = public_path().'/csv_temp/';
        	$extension = Input::file('fichier')->getClientOriginalExtension();
			$filename = str_random(20) . '.' . $extension;	
        	if (file_exists($destinationPath.$filename)) {
					unlink($destinationPath.$filename);
				}
			$uploadSuccess   = $file->move($destinationPath, $filename);

        	if($uploadSuccess){
        		$fic = fopen($destinationPath.$filename, 'rb');
        		$i=0;
        		while (($ligne = fgetcsv($fic,0)) !== FALSE) {
        			$ligne_temp=[];
        			$j=0;
        			if($i>0){
	        			//recupère ligne
					  	foreach ($ligne as $champ) {
					   		$ligne_temp[$j]=$champ;
					   		$j++;
					  	} 
					  	//validité ligne
					  	$rules=['0'=>'required',
					  			'1'=>'required',
					  			'2'=>'required',
					  			'3'=>'required',
					  			];

					  	$v =Validator::make($ligne_temp,$rules);
						if( $v->fails()){
							fclose($fic); 
							$messages = $v->messages();
							return Redirect::back()->withInput()->with(['errors'=>$messages,'line_err'=>'This error happened on line '.($i+1)]);
							}
						else{
							
							Lieux::create([
								'nom'=>$ligne_temp[0],
								'adresse'=>$ligne_temp[1],
								'ville'=>$ligne_temp[2],
								'code_postal'=>$ligne_temp[3],
								'telephone'=>$ligne_temp[4],
								'ressources_humaines'=>$ligne_temp[5],
								'ressources_materielles'=>$ligne_temp[6],
								'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
								]);
						}
					}
				$i++;
				}
				unlink($destinationPath.$filename);
        		return $this->index($id,'Successfully added !');
        	}
    	}
    }

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
						Lieux::create(array('projet_id'=> Crypt::decrypt(Session::get('hash_id_project')),
									   'nom'=>Input::get('nom_ajout'),
									   'adresse'=>Input::get('adresse_ajout'),
									   'ville'=>Input::get('ville_ajout'),
									   'code_postal'=>Input::get('cp_ajout'),
									   'ressources_humaines'=>Input::get('ress_h_ajout'),
									   'ressources_materielles'=>Input::get('ress_m_ajout'),
									   'telephone'=>Input::get('tel_ajout')
					));
					return $this->index($id,'Successfully added !');
				}
				
			}
	}


	public function download_csv($id){

		$file_path = 'app/CSV/Lieux_'.Auth::user()->login.'_proj_numb_'.$id.'.csv';

		$list = array(
			array('nom', 'adresse', 'ville', 'code_postal')
		);

		$results=DB::table('lieux')->select('nom','adresse','ville','code_postal')
				 ->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')))
				 ->get();

		if (file_exists($file_path)) {
			unlink($file_path);
		}

		$fp = fopen($file_path, 'w');

		$l=0;
		foreach ($results as $lieu) {
				$l=$l+1;
				$list[$l]=array($lieu->nom,$lieu->adresse,$lieu->ville,$lieu->code_postal);
		}
		foreach ($list as $fields) {
			fputcsv($fp, $fields,';');
		}

		fclose($fp);

		if (file_exists($file_path)) {
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
  		  	exit;
		}
	}

}