@extends('layout.projet_layout')
@section('projet-content')

  {{Form::open(array('url'=> URL::route('outils.action',$id)))}}
    <h2>Gestion des outils<span class="glyphicon glyphicon-wrench pull-right"></span></h2>

    @if($success)
                <div class="alert alert-success">
                    {{$success}}
                </div>
    @endif

    @if(Session::has('errors'))
                <div class="alert alert-danger">
                    @foreach (Session::get('errors')->all() as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                    
                </div>
     @endif
     
    <div class="row">
         {{Form::submit('Consulter mes outils',['class'=>'btn btn-primary btn-lg col-md-6 col-sm-6 col-xs-12','style'=>'width:100%;margin-top:25px','id'=>'ajout_q','name'=>'consulter'])}}
    </div>
    <div class="row">
          <div class="col-md-7">
            <h3 style="margin-top:35px">Creation de questionnaires</h3>
           </div> 
     </div>
     <div class="row">
        {{Form::label('titre_q','Titre',['class'=>'form-label','style'=>'margin-top:15px'])}}
        {{Form::text('titre_q', 'Titre' ,['class'=>'form-control'])}}
        <hr>
     </div>
     

     <div class="row">
          <div id="question_container">

          </div>
     </div>

     <div class="row">
          <div class="col-md-3 col-md-offset-8">
              <div class="btn btn-info" onclick="javascript:add_question();">
                Ajouter une question
              </div>
              {{Form::submit('Enregistrer',['class'=>'btn btn-success col-md-6 col-sm-6 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'save_q'])}}
              {{Form::submit('generer pdf',['class'=>'btn btn-success col-md-6 col-sm-6 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'pdf'])}}
           </div> 
     </div>



<script>

nb_q=0;
nb_r = new Array();

$(function(){
  $('#nb_q').hide();
})

function add_question(){

  var obj = document.getElementById('question_container');
  var n = nb_q;
  var str = ' <div class="row" id="q_'+n+'"><input class="form-control" name="question_'+n+'[] "type="text" value="Question '+n+' " style="margin-top:25px"/><br><div class="row" id="r_container'+n+'"></div><div class="btn btn-info" style="margin-top:10px" onclick="javascript:add_QCM('+n+');">Ajouter un QCM</div><div class="btn btn-danger" style="margin-left:10px;margin-top:10px" onclick="javascript:delete_QCM(\'q_'+n+'\');" ><span class="glyphicon glyphicon-remove"></span></div></div>' ;
  
  $(obj).append( str );
  $('#nb_q').attr('value',nb_q);
  nb_r[n]=0;
  nb_q++;
}

function add_QCM(q_source){

  var obj = document.getElementById('r_container'+q_source);
  var n = nb_r[q_source];
  var str= ' <div class="col-md-4" id="r_container'+q_source+'reponse_'+n+'"><input class="form-control" name="q_'+q_source+'_reponse_'+n+'[] "type="text" value="QCM '+n+' " style="margin-top:10px"/><div class="btn btn-danger btn-sm" onclick="javascript:delete_QCM(\'r_container'+q_source+'reponse_'+n+'\');" ><span class="glyphicon glyphicon-remove"></span></div></div>';
  $(obj).append( str );
  nb_r[q_source]++;
}

function delete_QCM(q_id){
  var obj = document.getElementById(q_id);
  $(obj).remove();
}


</script>
{{Form::close()}}
@stop