<?php

class MessagerieController extends BaseController{

	public function __construct()
	{
    	$this->beforeFilter('force.ssl');
	}
	
	public function boite_reception(){
		$results = DB::table('messages')
					->where('dest_id','=',Auth::user()->id)
					->where('dest_id_status','=','received')
					->get();
		return View::make('pages.messagerie.messagerie-br')->with(['messages' => $results,'i'=>0]);
	}

	public function boite_envoi(){
		$results = DB::table('messages')
					->where('source_id','=',Auth::user()->id)
					->where('source_id_status','=','send')
					->get();
		return View::make('pages.messagerie.messagerie-be')->with(['messages' => $results,'i'=>0]);
	}

	public function trash(){
		$result_temp = DB::table('messages')
					->where('dest_id','=',Auth::user()->id)
					->where('dest_id_status','=','trashed')
					->get();
		$results = DB::table('messages')
					->where('source_id','=',Auth::user()->id)
					->where('source_id_status','=','trashed')
					->union($result_temp)
					->get();
		return View::make('pages.messagerie.messagerie-trash')->with(['messages' => $results,'i'=>0]);
	}

	public function msg_saved(){
		$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ?', array(Auth::user()->id,'saved'));
		return View::make('pages.messagerie.messagerie-saved')->with(['messages' => $results,'i'=>0]);
	}

	public function nouveau_message(){
		return View::make('pages.messagerie.messagerie-newmsg');
	}

	public function action_br(){
		$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ?', array(Auth::user()->id,'received'));
		$n=count($results);
		if (Input::get('save')){
			for ($i = 1; $i <= $n; $i++) {
    			if (Input::get('msg'.$i) === ''.$i){
    				$cle = $results[$i-1]->id;
    				DB::update('update messages set dest_id_status = ? where id=?', array('saved',$cle));
    			}
			}
			$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ?', array(Auth::user()->id,'received'));
			return View::make('pages.messagerie.messagerie-br')->with(['messages' => $results,'i'=>0]);
		}
		if (Input::get('delete')){
			for ($i = 1; $i <= $n; $i++) {
    			if (Input::get('msg'.$i) === ''.$i){
    				$cle = $results[$i-1]->id;
    				DB::update('update messages set dest_id_status = ? where id=?', array('trashed',$cle));
    			}
			}
			$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ?', array(Auth::user()->id,'received'));
			return View::make('pages.messagerie.messagerie-br')->with(['messages' => $results,'i'=>0]);
		}
	}

	public function action_trash(){
		$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ? or source_id = ? and source_id_status = ?', array(Auth::user()->id,'trashed',Auth::user()->id,'trashed'));
		$n=count($results);
		if (Input::get('restaure')){
			for ($i = 1; $i <= $n; $i++) {
    			if (Input::get('msg'.$i) === ''.$i){
    				$cle = $results[$i-1]->id;
    				if($results[$i-1]->source_id == Auth::user()->id ){
    					DB::update('update messages set source_id_status = ? where id=?', array('send',$cle));}
    				if($results[$i-1]->dest_id == Auth::user()->id ){
    					DB::update('update messages set dest_id_status = ? where id=?', array('received',$cle));}
    			}
			}
			$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ? or source_id = ? and source_id_status = ?', array(Auth::user()->id,'trashed',Auth::user()->id,'trashed'));
			return View::make('pages.messagerie.messagerie-trash')->with(['messages' => $results,'i'=>0]);
		}
		if (Input::get('delete')){
			for ($i = 1; $i <= $n; $i++) {
    			if (Input::get('msg'.$i) === ''.$i){
    				$cle = $results[$i-1]->id;
    				if($results[$i-1]->source_id == Auth::user()->id ){
    					DB::update('update messages set source_id_status = ? where id=?', array('deleted',$cle));}
    				if($results[$i-1]->dest_id == Auth::user()->id ){
    					DB::update('update messages set dest_id_status = ? where id=?', array('deleted',$cle));}
    			}
			}
			$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ? or source_id = ? and source_id_status = ?', array(Auth::user()->id,'trashed',Auth::user()->id,'trashed'));
			return View::make('pages.messagerie.messagerie-trash')->with(['messages' => $results,'i'=>0]);
		}
	}

	public function action_msg_saved(){
		$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ?', array(Auth::user()->id,'saved'));
		$n=count($results);
		if (Input::get('delete')){
			for ($i = 1; $i <= $n; $i++) {
    			if (Input::get('msg'.$i) === ''.$i){
    				$cle = $results[$i-1]->id;
    				DB::update('update messages set dest_id_status = ? where id=?', array('trashed',$cle));
    			}
			}
			$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ?', array(Auth::user()->id,'saved'));
			return View::make('pages.messagerie.messagerie-saved')->with(['messages' => $results,'i'=>0]);
		}
	}

	public function action_envoi(){
		$results = DB::select('select * from messages where source_id = ? and source_id_status = ?', array(Auth::user()->id,'send'));
		$n=count($results);
		if (Input::get('delete')){
			for ($i = 1; $i <= $n; $i++) {
    			if (Input::get('msg'.$i) === ''.$i){
    				$cle = $results[$i-1]->id;
    				DB::update('update messages set source_id_status = ? where id=?', array('trashed',$cle));
    			}
			}
			$results = DB::select('select * from messages where source_id = ? and source_id_status = ?', array(Auth::user()->id,'send'));
			return View::make('pages.messagerie.messagerie-be')->with(['messages' => $results,'i'=>0]);
		}
	}

	public function display_msg_br($num_msg){
			$results = DB::select('select * from messages where dest_id = ? and dest_id_status = ?', array(Auth::user()->id,'received'));
			$n=count($results);
			if($num_msg>$n){
				echo "Not existing or forbidden";
			}
			else{
				return View::make('pages.messagerie.messagerie-msg')->with(['message'=> $results[$num_msg-1] ]);
			}
	}

	public function display_msg_be($num_msg){
			$results = DB::select('select * from messages where source_id = ? and source_id_status = ?', array(Auth::user()->id,'send'));
			$n=count($results);
			if($num_msg>$n){
				echo "Not existing or forbidden";
			}
			else{
				return View::make('pages.messagerie.messagerie-msg')->with(['message'=> $results[$num_msg-1] ]);
			}
	}

	public function send_message(){
		var_dump(Session::all());
			$rules=[
			 'dest'=>'required',
			 'subject'=>'required',
			 'content'=>'required'
			];
			$v =Validator::make(Input::all(),$rules);
			if( $v->fails()){ 
				$messages = $v->messages();
				return Redirect::back()->withInput()->with(['errors'=>$messages]);
			}
			else{
					$bool = User::where('login', '=', Input::get('dest'))->first();
					if( is_null ( $bool )){
						 return Redirect::back()->withInput()->with(['error_login'=> 'Unknown Login !']);
					}
					else{
						Message::create(
    						['source_id' => Auth::user()->id,
    							'source_login'=>Auth::user()->login,
    							  'dest_id' => $bool->id,
    							  'dest_login'=>Input::get('dest'),
    							  'sujet' => Input::get('subject'),
    							  'contenu' => Input::get('content'),
    							  'source_id_status' => 'send',
    							  'dest_id_status' => 'received',
							]);
						return Redirect::back()->withInput()->with(['success'=> 'Send !']);
					}
				}
		}
}