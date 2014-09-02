<?php

class ProjectsMembersController extends BaseController{
	
	public function index($id,$success = null){

		$res = DB::table('activites')
					->select('nom')
					->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
					->get();

		$activite_nom=[];
		$groupes = [];
		$ss_groupes=[];

		for($i=0;$i<count($res);$i=$i+1){
			$activite_nom[$i]=$res[$i]->nom;
		}

		$activite_nom[count($res)]='Non associé';

		$tous = $this->get_members();
		$TousLesParticipants = $this->get_participants();

		$groupes = $this->get_groupes();
		$ss_groupes = $this->get_ss_groupes();

		$groupe_associes = $this->get_gr_associes();
		$ss_groupes_associes = $this->get_ss_gr_associes();

		if(Session::has('line_err')){
			$line_err=Session::get('line_err');
		}
		else{
			$line_err=[];
		}


		return View::make('pages.projet.projects-members')
					->with(['results' => $tous,
							'i'=>0,
							'id'=>$id,
							'success'=>$success,
							'act'=>$activite_nom,
							'TousLesParticipants'=>$TousLesParticipants,
							'groupes'=>$groupes,
							'ssgroupes'=>$ss_groupes,
							'groupe_associes'=>$groupe_associes,
							'ss_groupes_associes'=>$ss_groupes_associes,
							'j'=>0,
							'line_err'=>$line_err
							]);
	}
 
	public function action($id){
		
			if(Input::get('membre_ajout')){
					return $this->ajout_membre($id);
			}

			if(Input::get('membre_modif')){
					return $this->modif_membre($id);
			}

			if(Input::get('membre_supp')){
					return $this->supp_membre($id);
			}
			if(Input::get('genere_comptes')){
				return $this->genere_comptes($id);
			}
			if(Input::get('down_csv')){

				return $this->down_csv($id);
			}
			if(Input::get('membre_non_inscrit_ajout')){

				return $this->ajoute_un_nouveau($id);
			}

			if(Input::get('new_groupe')){
				return $this->create_groupe($id);
			}

			if(Input::get('new_ss_groupe')){
				return $this->create_ss_groupe($id);
			}
			if(Input::get('affecter')){
				return $this->affecte($id);
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
					  			'4'=>'required'
					  			];

					  	$v =Validator::make($ligne_temp,$rules);
						if( $v->fails()){
							fclose($fic); 
							$messages = $v->messages();
							return Redirect::back()->withInput()->with(['errors'=>$messages,'line_err'=>'This error happened on line '.($i+1)]);
							}
						else{
							$m=Membres::create([
								'nom'=>$ligne_temp[0],
								'prenom'=>$ligne_temp[1],
								'adresse'=>$ligne_temp[2],
								'ville'=>$ligne_temp[3],
								'codepostal'=>$ligne_temp[4]
							]);
							MembresProjets::create([
								'membre_id'=>$m->id,
								'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
					 			]);

							$a=DB::table('activites')
								->where('nom','=',$ligne_temp[5])
								->where( 'projet_id','=',Crypt::decrypt(Session::get('hash_id_project')) )
								->get();

							$nom_qual ='NC';
							if($ligne_temp[6]=='Expert'){ $nom_qual='Expert'; }
							if($ligne_temp[6]=='Intervenant'){ $nom_qual='Intervenant';}			
							if($ligne_temp[6]=='Collaborateur'){ $nom_qual='Collaborateur'; }
							if($ligne_temp[6]=='Participant'){ $nom_qual='Participant'; }

							if(count($a)==1){
								MembresActivites::create([
									'membre_id'=>$m->id,
									'membre_status_pour_activite'=>$nom_qual,
									'activite_id'=>$a[0]->id
									]);
							}
							else{
								MembresActivites::create([
									'membre_id'=>$m->id,
									'membre_status_pour_activite'=>$nom_qual,
									'activite_id'=>NULL
									]);
							}
						}
					}
				$i++;
				}
				unlink($destinationPath.$filename);
        		return $this->index($id,['Successfully added !']);
        	}
    	}
	}

	public function create_groupe($id){

		$rules=['nom_create_groupe'=>'required'];

		$v =Validator::make(Input::all(),$rules);

		if( $v->fails()){ 
			$messages = $v->messages();
			return Redirect::back()->withInput()->with(['errors'=>$messages]);
			}
		else{

			Groupes::create([
						'nom'=>Input::get('nom_create_groupe'),
						'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
					]);

			return $this->index($id,['Groupe créé !']);
		}
	}

	public function affecte($id){

		$part = $this->get_participants();
		$n = count($part);
		$groupes = DB::table('groupes')
			->where( 'projet_id' , '=' , Crypt::decrypt(Session::get('hash_id_project')) )
			->get();
		


		for($i=1;$i<$n+1;$i++){

			if(Input::get('check_participant_shad_'.$i)){ 
				$membre_id = $part[$i-1]->id;
				$id_groupe = $groupes[ Input::get('groupe_affecte') ]->id;

				$ss_g = DB::table('sous_groupes')
					->where( 'groupe_id' , '=' , $id_groupe)
					->get();

				if( count( DB::table('lien_membres_groupes')->where('membre_id','=',$membre_id)->where('groupe_id','=',$id_groupe)->get() )==0 ){
					DB::table('lien_membres_groupes')
						->insert([
							'membre_id'=>$membre_id,
							'groupe_id'=>$id_groupe
						]);
				}
				$index_ss_g = Input::get('ss_groupe_affecte_'.($i-1));
				$id_ss_groupe = $ss_g[$index_ss_g]->id;

				if( count( DB::table('lien_membres_sous_groupes')->where('membre_id','=',$membre_id)->where('sous_groupe_id','=',$id_ss_groupe)->get() )==0 ){
					DB::table('lien_membres_sous_groupes')
						->insert([
							'membre_id'=>$membre_id,
							'sous_groupe_id'=>$id_ss_groupe
						]);
				}
			}
			return $this->index($id,['Effectué ! ']);
		}
		
	}

	public function create_ss_groupe($id){

		$rules=['sous_groupe_nom'=>'required'];

		$v =Validator::make(Input::all(),$rules);

		if( $v->fails()){ 
			$messages = $v->messages();
			return Redirect::back()->withInput()->with(['errors'=>$messages]);
			}
		else{

			$g = DB::table('groupes')
					->where( 'projet_id' , '=' , Crypt::decrypt(Session::get('hash_id_project')) )
					->get();

			$index_groupe = Input::get('groupe_pour_ssgroupes_creation');

			$id_groupe = $g[$index_groupe]->id;

			SSgroupes::create([
						'nom'=>Input::get('sous_groupe_nom'),
						'groupe_id'=>$id_groupe
					]);

			return $this->index($id,['Sous groupe créé !']);
		}
	}
 
	public function get_groupes(){

		$results = DB::table('groupes')
			->where( 'projet_id' , '=' , Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		$res=[];
		for($i=0;$i<count($results);$i=$i+1){
			$res[$i]=$results[$i]->nom;
		}

		return $res;
	}

	public function get_ss_groupes(){

		$results = DB::table('groupes')
			->where( 'projet_id' , '=' , Crypt::decrypt(Session::get('hash_id_project')) )
			->get();

		$res=[];

		for($i=0;$i<count($results);$i=$i+1){
			$res[$i]=[];
			$g_id = $results[$i]->id;

			$ss_g = DB::table('sous_groupes')
				->where( 'groupe_id' , '=' , $g_id )
				->get();

			for($j=0;$j<count($ss_g);$j=$j+1){
				$res[$i][$j]= $ss_g[$j]->nom;
			}
		}

		return $res;
	}

	public function supp_membre($id){
		$tous = $this->get_members();
		for ($i = 1; $i <= count($tous); $i++) {
    			if (Input::get('check_'.$i) === 'yes'){
    				$cle = $tous[$i-1]->id;
    				DB::table('lien_user_activite')
    					->where('id','=',$cle)
    					->delete();
    			}
    		}
    	return $this->index($id,['Successfully deleted !']);

	}

public function down_csv($id){
	$tous = $this->get_members();
	$file_path = 'app/CSV/Membres_'.Auth::user()->login.'_proj_numb_'.$id.'.csv';
	$list = array(
				array('login','activité','qualité','date')
			);
	$list[1]=array('', '', '', '','','');

	if (file_exists($file_path)) {
					unlink($file_path);
				}

	$fp = fopen($file_path, 'w');
	$n=count($tous);

	for($i=2;$i<$n+2;$i++) {
		$list[$i]=array($tous[$i-2]->login,$tous[$i-2]->activite,$tous[$i-2]->status,$tous[$i-2]->date);
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
	}
	return $this->index($id);
}

public function genere_comptes($id){

			$qualite=Input::get('qualite_genere');
			$activites=Input::get('activite_genere');

			$rules=['nb_comptes'=>'required|numeric|min:1|max:200'];

			$v =Validator::make(Input::all(),$rules);

			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{

				$file_path = 'app/CSV/Membres_'.Auth::user()->login.'_proj_numb_'.$id.'_generated_members.csv';
				
				$list = array(
					array('login', 'password', 'titre du projet', 'acronyme du projet','activité','qualité')
				);
				$list[1]=array('', '', '', '','','');
				$n = Input::get('nb_comptes');				

				if (file_exists($file_path)) {
					unlink($file_path);
				}

				$fp = fopen($file_path, 'w');

				$length = 10;
				

				for($i=2;$i<$n+2;$i++) {

					$stop=1;
					while($stop){
						$randomLogin = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
						if(count(DB::table('users')->where('login','=',$randomLogin)->get())==0){
							$stop=0;
						}
					}
					$fake_email = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length+5);
					$fake_email=$fake_email.'@'.$fake_email;
					$randomPass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length-2);
					$u = User::create([
							'login'=>$randomLogin,
							'password'=>Hash::make($randomPass),
							'email'=>$fake_email
						]);


					//attribution activité
					$temp_act = NULL;
					$id_act = NULL;

				
					$all = DB::table('activites')
						->select('nom')
						->get();
					//evite NC	
					if($activites<>count($all)){
						$temp_act = DB::table('activites')
								->select('id','nom')
								->where('nom','=',$all[$activites]->nom)
								->get();
						$id_act=$temp_act[0]->id;
					}	   
					

					//atribution categorie
					if($qualite=='N'){
							$qual_mem='NC';
						}

					if($qualite=='E'){
							$qual_mem='Expert';
						}

					if($qualite=='I'){
							$qual_mem='Intervenant';
						}

					if($qualite=='C'){
							$qual_mem='Collaborateur';
						}

					if($qualite=='P'){
							$qual_mem='Participant';
						}

					MembresProjets::create([
									'user_id'=>$u->id, 
									'activite_id'=>$id_act,
									'projet_id'=> Crypt::decrypt(Session::get('hash_id_project')),
									'user_status_pour_activite'=>$qual_mem,
									]);

					$proj = DB::table('projets')
							->select('titre','acronyme')
							->where('id','=',Crypt::decrypt(Session::get('hash_id_project')))
							->get();

					if($activites<>count($all)){
						$list[$i]=array($randomLogin,$randomPass,$proj[0]->titre,$proj[0]->acronyme,$all[$activites]->nom,$qual_mem);
					}
					else{
						$list[$i]=array($randomLogin,$randomPass,$proj[0]->titre,$proj[0]->acronyme,'NC',$qual_mem);
					}
					
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
				}
				return $this->index($id);
			}
	}


	public function modif_membre($id){

			$tous = $results = DB::table('membres')
				->leftJoin('lien_projets_membres','membres.id','=','lien_projets_membres.membre_id')
				->leftJoin('projets','projets.id','=','lien_projets_membres.projet_id')
				->leftJoin('lien_membres_activites','lien_membres_activites.membre_id','=','membres.id')
				->leftJoin('activites','activites.id','=','activite_id')
				->leftJoin('users','users.id','=','membres.user_id')
				->select('users.login as login','membres.nom as nom','membres.prenom as prenom','activites.nom as activite','lien_membres_activites.membre_status_pour_activite as status','lien_membres_activites.created_at as date','membres.id as id','lien_membres_activites.id as lien_id')
				->where('lien_projets_membres.projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
				->distinct()
				->get();

			$nom_qual ='NC';
			$qualite=Input::get('qualite_modif');
			if($qualite=='E'){ $nom_qual='Expert'; }
			if($qualite=='I'){ $nom_qual='Intervenant';}			
			if($qualite=='C'){ $nom_qual='Collaborateur'; }
			if($qualite=='P'){ $nom_qual='Participant'; }


			$activites=Input::get('activite_modif');
			$id_act=NULL;
			$all = DB::table('activites')
				->select('nom')
				->where('projet_id','=', Crypt::decrypt(Session::get('hash_id_project')) )
				->get();

			if($activites<>count($all)){
				$temp_act = DB::table('activites')
						->select('id')
						->where('nom','=',$all[$activites]->nom)
						->get();
				$id_act=$temp_act[0]->id;
			}	 

			for ($i = 1; $i < count($tous)+1; $i++) {
    			if (Input::get('check_'.$i) === 'yes'){				
    				$cle_m = $tous[$i-1]->id;
    				$cle_l = $tous[$i-1]->lien_id;
					DB::table('lien_membres_activites')
						->where('membre_id','=',$cle_m)
						->where('id','=',$cle_l)
						->update([
							'membre_status_pour_activite'=>$nom_qual,
							'activite_id'=>$id_act
							]);
					}
    			}
			return $this->index($id,['Successfully modified !']);
	}


	public function get_members(){

		$results = DB::table('membres')
				->leftJoin('lien_projets_membres','membres.id','=','lien_projets_membres.membre_id')
				->leftJoin('projets','projets.id','=','lien_projets_membres.projet_id')
				->leftJoin('lien_membres_activites','lien_membres_activites.membre_id','=','membres.id')
				->leftJoin('activites','activites.id','=','activite_id')
				->leftJoin('users','users.id','=','membres.user_id')
				->select('users.login as login','membres.nom as nom','membres.prenom as prenom','activites.nom as activite','lien_membres_activites.membre_status_pour_activite as status','lien_membres_activites.created_at as date','membres.id as id')
				->where('lien_projets_membres.projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
				->distinct()
				->get();

		return $results;
		
	}

	public function get_participants(){
		$results = DB::table('membres')
				->leftJoin('lien_projets_membres','membres.id','=','lien_projets_membres.membre_id')
				->leftJoin('projets','projets.id','=','lien_projets_membres.projet_id')
				->leftJoin('lien_membres_activites','lien_membres_activites.membre_id','=','membres.id')
				->leftJoin('activites','activites.id','=','activite_id')
				->select('membres.nom as nom','membres.prenom as prenom','activites.nom as activite','lien_membres_activites.created_at as date','membres.id as id')
				->where('lien_projets_membres.projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
				->where('lien_membres_activites.membre_status_pour_activite','=','Participant')
				->distinct()
				->get();

		return $results;
	}

	public function get_gr_associes(){

		$participants = $this->get_participants();
		$n=count($participants);
		$res = [];

		for($i=0;$i<$n;$i++){
			$id_membre = $participants[$i]->id;
			$res[$i]=[];

			$g_temp = DB::table('lien_membres_groupes')
				->leftJoin('groupes','groupes.id','=','lien_membres_groupes.groupe_id')
				->select('groupes.nom as nom')
				->where('membre_id','=',$id_membre)
				->get();


			$nn=count($g_temp);

			for($j=0;$j<$nn;$j++){
				$res[$i][$j] = $g_temp[$j]->nom;
			}

		}
		return $res;
	}

	public function get_ss_gr_associes(){

		$participants = $this->get_participants();
		$n=count($participants);
		$res = [];

		for($i=0;$i<$n;$i++){
			$id_membre = $participants[$i]->id;
			$res[$i]=[];

			$ssg_temp = DB::table('lien_membres_sous_groupes')
					->leftJoin('sous_groupes','sous_groupes.id','=','lien_membres_sous_groupes.sous_groupe_id')
					->select('sous_groupes.nom as nom')
					->where('lien_membres_sous_groupes.membre_id','=',$id_membre)
					->get();

			$nn=count($ssg_temp);
			//parcourt groupes
			for($j=0;$j<$nn;$j++){
				$res[$i][$j] = $ssg_temp[$j]->nom;
			}

		}
		return $res;
	}

	public function ajout_membre($id){

			$login=Input::get('login_ajout');
			$qualite=Input::get('qualite_ajout');
			$activites=Input::get('activite_ajout');

			$rules=['login_ajout'=>'required|exists:users,login'];

			$v =Validator::make(Input::all(),$rules);

			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{
				

				$id_membre=DB::table('membres')
					->join('users','users.id','=','membres.user_id')
					->select('membres.id')
					->where('users.login','=',$login) 
					->get();

				//attribution qualité
				$nom_qual ='NC';
				if($qualite=='E'){ $nom_qual='Expert'; }
				if($qualite=='I'){ $nom_qual='Intervenant';}			
				if($qualite=='C'){ $nom_qual='Collaborateur'; }
				if($qualite=='P'){ $nom_qual='Participant'; }

				$id_act=NULL;

				$all = DB::table('activites')
					->select('nom')
					->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
					->get();
				//evite NC	
				if($activites<>count($all)){
					$temp_act = DB::table('activites')
							->select('id')
							->where('nom','=',$all[$activites]->nom)
							->get();
					$id_act=$temp_act[0]->id;
				}	   

				//attribution categorie

				MembresProjets::create([
						'membre_id'=>$id_membre[0]->id,
						'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
					 ]);

				MembresActivites::create([
						'membre_id'=>$id_membre[0]->id,
						'membre_status_pour_activite'=>$nom_qual,
						'activite_id'=>$id_act
						]);

				return $this->index($id,['Ajouté !']);
				}
		}

	public function ajoute_un_nouveau($id){

			$rules=[
				'nom_non_insc_ajout'=>'required',
				'prenom_non_insc_ajout'=>'required',
				'adresse_non_insc_ajout'=>'required',
				'ville_non_insc_ajout'=>'required',
				'cp_non_insc_ajout'=>'required'
			];

			$v =Validator::make(Input::all(),$rules);

			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
				}
			else{
				$qualite=Input::get('qualite_non_insc_ajout');
				$activites=Input::get('activite_non_insc_ajout');

				$m=Membres::create([
						'nom'=>Input::get('nom_non_insc_ajout'),
						'prenom'=>Input::get('prenom_non_insc_ajout'),
						'adresse'=>Input::get('adresse_non_insc_ajout'),
						'ville'=>Input::get('ville_non_insc_ajout'),
						'codepostal'=>Input::get('cp_non_insc_ajout')
					]);

				$nom_qual ='NC';
				if($qualite=='E'){ $nom_qual='Expert'; }
				if($qualite=='I'){ $nom_qual='Intervenant';}			
				if($qualite=='C'){ $nom_qual='Collaborateur'; }
				if($qualite=='P'){ $nom_qual='Participant'; }



				$id_act=NULL;
				$all = DB::table('activites')
					->where('projet_id','=',Crypt::decrypt(Session::get('hash_id_project')))
					->select('nom')
					->get();
				//evite NC	
				if($activites<>count($all)){
					$temp_act = DB::table('activites')
							->select('id')
							->where('nom','=',$all[$activites]->nom)
							->get();
					$id_act=$temp_act[0]->id;
				}	   

				//attribution categorie

				MembresProjets::create([
						'membre_id'=>$m->id,
						'projet_id'=>Crypt::decrypt(Session::get('hash_id_project'))
					 ]);

				MembresActivites::create([
						'membre_id'=>$m->id,
						'membre_status_pour_activite'=>$nom_qual,
						'activite_id'=>$id_act
						]);

				return $this->index($id,['Ajouté !']);
			}
	}
	
}