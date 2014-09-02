<?php

class CompteRenduController extends BaseController{
	
	public function index($id){

		$list = $this->get_list_fich();

		return View::make('pages.projet.DeposerCompteRendu')->with(['id'=>$id,
																	'list'=>$list
																	]);
	}

	public function get_list_fich(){
		$list=[];
		$cpt=0;
		if($dossier = opendir('app/cr_upload/') )
		{
			while(false !== ($fichier = readdir($dossier)))
			{
				if($fichier!='.'&&$fichier!='..'){
					$elements = explode( "_" , $fichier );
					//id projet après le 4eme tiret
					$id_proj_fichier = $elements[4];

					if($id_proj_fichier == Crypt::decrypt(Session::get('hash_id_project')) ){
						$list[$cpt]=$fichier;
						$cpt++;
					}
				}
			}
		}
		return $list;
	}
	
	public function action(){
		$list=$this->get_list_fich();
		for($i=0;$i<count($list);$i++){
			if(Input::get('consulter_'.$i)){
				$file_path = 'app/cr_upload/'.$list[$i];
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

	
}

