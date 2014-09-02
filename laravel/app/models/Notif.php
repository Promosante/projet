<?php

class Notif extends Eloquent {

    protected $table = 'notifications';

    protected $guarded = array('id','updated_at','created_at');



    public static function get_nb_new_notifs(){

    	$notifs = DB::table('notifications')
				->where('dest_id','=',Auth::user()->id)
				->where('read_or_not','=','not')
				->get();

		$nb_notifs = count($notifs);

		return $nb_notifs;
    }

    public static function get_new_notifs(){

    	$notifs = DB::table('notifications')
				->where('dest_id','=',Auth::user()->id)
				->where('read_or_not','=','not')
				->get();
		return $notifs;
    }

    public static function get_read_notifs(){

    	$notifs = DB::table('notifications')
				->where('dest_id','=',Auth::user()->id)
				->where('read_or_not','=','read');

      $notifs2 = DB::table('notifications')
        ->where('dest_id','=',Auth::user()->id)
        ->where('read_or_not','=','answered')
        ->union($notifs)
        ->get();

		return $notifs2;
    }

   public static function send_notif_to($id_source,$id_dest,$type,$datas,$proj = NULL){
   		
   		if($type==='demande_assos_projet'){

   			$nom_source = DB::table('users')
   				->join('membres','membres.user_id','=','users.id')
   				->select('users.login as login','membres.nom as nom','membres.prenom as prenom')
   				->where('users.id','=',$id_source)
   				->get();

   			$acro_projet = DB::table('projets')
   				->where('id','=',Crypt::decrypt($proj))
   				->get();

			   $message = "L'utilisateur ".$nom_source[0]->login." (".$nom_source[0]->nom." ".$nom_source[0]->prenom.") souhaite participer au projet ".$acro_projet[0]->acronyme." en tant que ".$datas['qualite']." pour l'activité ".$datas['activite'].".";

        $contenu="".$datas['activite'].":".$datas['qualite'].":".$proj;

   			Notif::create([
   					'source_id'=>$id_source,
   					'dest_id'=>$id_dest,
   					'type'=>$type,
   					'contenu'=>$contenu,
   					'read_or_not'=>'not',
   					'message'=>$message
   				]);
   		}
      if($type==='info'){
        Notif::create([
            'source_id'=>$id_source,
            'dest_id'=>$id_dest,
            'type'=>$type,
            'contenu'=>$datas['message'],
            'read_or_not'=>'not',
            'message'=>$datas['message']
          ]);

      }

   }

}