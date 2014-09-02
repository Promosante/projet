@extends('layout.projet_layout')
@section('projet-content')

  {{Form::open(array('url'=> URL::route('indicateurs.action',$id)))}}
    <h2>Gestion des indicateurs<span class="glyphicon glyphicon-asterisk pull-right"></span></h2>

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
         {{Form::submit('Consulter mes indicateurs',['class'=>'btn btn-primary btn-lg col-md-6 col-sm-6 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'consulter'])}}
    </div>
 <div id="new_indic_container">
    <div class="row">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Ajouter un indicateur : </h4>
              <hr>
           </div> 
     </div>
       
     <div class="row"> 
        <div class="col-md-6">
            {{Form::label('description_ajout','Description',['class'=>'form-label'])}}
            {{Form::textarea('description_ajout', 'Description' ,['class'=>'form-control'])}}

        </div>
        <div class="col-md-5">
            {{Form::label('nom_ajout','Nom de l\'indicateur',['class'=>'form-label'])}}
            {{Form::text('nom_ajout', 'Nom' ,['class'=>'form-control'])}}
           
            
            {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'ajout_indic'])}}
        </div>

    </div>
  </div>

<div id="outils_container">
    <hr>
    <div class="row" style="margin-top:20px"> 
        {{Form::label('question_ajout','Question',['class'=>'form-label','style'=>'margin-top:15px'])}}
        {{Form::text('question_ajout', 'Question' ,['class'=>'form-control','style'=>'margin-top:15px'])}}
    </div>
    <div class="row" id="reponse_id_container">
        <div class="btn btn-success" style="margin-top:15px;" onclick="javascript:ajoute_reponse();">Ajouter une reponse</div>
        <br>

          

    </div>
    <div class="row">
          <div class="row" style="margin-top:20px"> 
              {{Form::label('domaine_ajout','Domaine',['class'=>'form-label','style'=>'margin-top:15px'])}}
          </div>
 
          <div class="row"> 
                <div class="col-md-6">
                    <h5>Participation</h5>
                    {{ Form::checkbox('participation_ajout', 'yes',true,['id'=>'participation_ajout']) }}
                 </div>
                <div class="col-md-6">
                  <h5>Réalisation</h5>
                  {{ Form::checkbox('realisation_ajout', 'yes',false,['id'=>'realisation_ajout']) }}
                </div>
          </div>

          <div class="row"> 
              {{Form::label('domaine_ajout','Déclinaison',['class'=>'form-label','style'=>'margin-top:15px'])}}
          </div>

          <div class="row"> 
                <div class="col-md-6">
                    <h5>Quantité</h5>
                    {{ Form::checkbox('quantite_ajout', 'yes',true,['id'=>'quantite_ajout']) }}
                 </div>
                <div class="col-md-6">
                  <h5>Qualité</h5>
                  {{ Form::checkbox('qualite_ajout', 'yes',false,['id'=>'qualite_ajout']) }}
                </div>
          </div>

           <div class="row"> 
              {{Form::label('destinataire_ajout','Destinataires',['class'=>'form-label','style'=>'margin-top:15px'])}}
          </div>

          <div class="row"> 
                <div class="col-md-6">
                    <h5>Participant</h5>
                    {{ Form::checkbox('participant_ajout', 'yes',true,['id'=>'participant_ajout']) }}
                 </div>
                <div class="col-md-6">
                  <h5>Intervenant</h5>
                  {{ Form::checkbox('intervenant_ajout', 'yes',false,['id'=>'intervenant_ajout']) }}
                </div>
          </div>

          <div class="row">
              <div class="col-md-6">
                  <h4 style="margin-top:35px">Associer des outils  <div id="hide_outils_p_indic" class="btn btn-danger" style="margin-left:15px"><span id="logo_outils_p_indic" class="glyphicon glyphicon-eye-close"></span></div></h4> 
              </div>
          </div>
          <div class="row" id="content_outils_p_indic"> 
                  <div class="row">
                              <div class="col-md-4">

                                    <a class="btn btn-primary col-sm-2 col-xs-12" 
                                        onclick="javascript:toggle_slide();"
                                          style="width:100%;margin-top:25px">
                                          Ajouter un outils
                                  </a>   
                              </div>
                              <div class="col-md-4">
                                  {{Form::submit('Retirer outil(s)',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'retirer_outils'])}}   
                              </div>
                  </div>
                    <div class="row"> 
                        <div class="panel panel-success" style="margin-top:20px">
                                  <div class="panel-heading" style="font-size:20px"><strong>Outils attribués :</strong> </div>
                            <div class="panel-body">
                           
                                    <div class="table-responsive">  
                                            <table id="simpleTable" class="table table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th></th> 
                                                        <th data-sort="string"><p class="btn btn-default trick" id="tri_nom" onclick="javascript:refresh_result('tri_nom','page_','ligne',{{ceil(count($outils)/5)+1}},{{count($outils)}},5);" style="width:100%;">Nom</span></p></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                               <?php define('i',0); ?>
                                               @foreach ($outils as $o)
                                               <?php $i=$i+1; ?>
                                                  <tr id="outils_{{$i}}" name="ligne" onclick="javascript:hilight_line({{$i}},'outils_','check_outils_','success outils_line','outils_line')" class="outils_line">
                                                    <td>{{$i}} {{ Form::checkbox('check_outils_'.$i, 'yes',false,['id'=>'check_outils_'.$i]) }}</td>
                                                    <td>{{ $o->nom }}</td>
                                                  </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                          @for($p=1; $p < ceil(count($outils)/5)+1;$p=$p+1)
                                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_','ligne',{{$p}},{{ceil(count($outils)/5)+1}},{{count($outils)}},5);" id="page_{{$p}}">{{$p}}</p>
                                          @endfor

                              </div>
                        </div>
                    </div>
          </div>
 
          <div class="col-md-6">
            {{Form::submit('Terminer',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'terminer'])}}
        </div>
        <div class="col-md-6">

        </div>
  </div>
        
</div>

<div class="row">
    <div class="row" style="margin-top:10px;">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Supprimer un indicateur</h4>
              <hr>
           </div> 
     </div>

     <div class="row"> 
        <div class="col-md-5">
            {{Form::label('nom_supp','Nom de la catégorie (exact)',['class'=>'form-label'])}}
            {{Form::text('nom_supp', 'Nom' ,['class'=>'form-control'])}}
        </div>
        
        <div class="col-md-2">
            {{Form::submit('Supprimer',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'supp_lieu'])}}
        </div>
    </div>
</div>

<div id="hidden_outils_stuff">
    <div class="btn btn-success btn-lg" onclick="ok_unlight_this();">Un-shade this ! </div>
</div>

{{Form::close()}}
@include('pages.projet.Shadow_outilsI')
{{ HTML::script('js/gest_indic.js'); }}
<script>
{{$script}};
ok_unlight_this();
</script>
@stop