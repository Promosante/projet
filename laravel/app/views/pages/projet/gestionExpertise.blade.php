@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('GestionExpertise.action',$id)))}}
<h2>Gestion de l'expertise<span class="glyphicon glyphicon-briefcase pull-right"></span></h2>
@if($success)
     <div class="alert alert-success">
        {{$success}}
      </div>
@endif
<h3 style="margin-top:35px">Niveau d'expertise</h3>
<hr>
<h4  style="margin-top:20px">  {{ Form::checkbox('check_tout_le_projo', 'yes',true,['id'=>'check_tout_le_projo','class'=>'check_control']) }} Ensemble du projet</h4>
<h4  style="margin-top:20px"> {{ Form::checkbox('check_categories', 'yes',false,['id'=>'check_categories','class'=>'check_control']) }} Par catégorie d'activité </h4>
	
	<h5 style="margin-left:40px"> Choisir une catégorie : {{Form::select('sel_cat',$categories,0,['style'=>'max-width:100%;margin-top:15px;' ]) }}</h5>

<h4  style="margin-top:20px">{{ Form::checkbox('check_activites', 'yes',false,['id'=>'check_activites','class'=>'check_control']) }} Par activités</h4>


<h5 style="margin-left:40px"> Choisir une ou plusieures activités : </h5>
  
   			<div class="hidden">
               {{$ligneName='ligne_participant';}}
               {{$ligneId='membre_participant_';}}
               {{$NbPerPage=15;}}
               {{$ligneClass='membre_participant_line';}}
               {{$checkNameAndId='check_activites_';}}
               {{$Nb_pages=ceil(count($les_activites)/$NbPerPage)+1;}}
               {{$Nb_El=count($les_activites);}}
               {{$pageId='page_participant_membres';}}
             </div>
              
                      <div class="panel panel-info" style="margin-top:20px;margin-left:40px">
                        <div class="panel-heading" style="font-size:20px"><strong>Activités :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_part" onclick="javascript:refresh_result('tri_nom_part','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_obj" onclick="javascript:refresh_result('tri_obj','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Objectifs</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($les_activites as $a)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      	<td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      	<td>{{ $a->nom }}</td>
                                   		<td>{{ $a->objectif }}</td>
                                    </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                            </div>
                          @for($p=1; $p < $Nb_pages;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('{{$pageId}}','{{$ligneName}}',{{$p}},{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" id="{{$pageId.$p}}">{{$p}}</p>
                             @endfor

                          </div>
                      </div>
                      <hr>
<h3 style="margin-top:35px">Période d'expertise</h3><hr>
<h4  style="margin-top:20px">  {{ Form::checkbox('check_duree_projo', 'yes',true,['id'=>'check_duree_projo','class'=>'check_control2']) }} Toute la durée du projet</h4>
<h4  style="margin-top:20px">  {{ Form::checkbox('check_periode', 'yes',false,['id'=>'check_periode','class'=>'check_control2']) }} La ou les périodes :</h4>
  
   			<div id="periodes">

        </div>
        <div class="btn btn-success" style="margin-top:20px" onclick="javascript:add_periode();">
            Ajouter une periode 
        </div>

<hr>
<h3 style="margin-top:35px">Notes</h3><hr>
<h4  style="margin-top:20px">{{ Form::checkbox('check_quantite_real', 'yes',true,['id'=>'check_quantite_real','class'=>'check_control']) }} Quantité de réalisation</h4>
<h4  style="margin-top:20px">{{ Form::checkbox('check_qualite_real', 'yes',true,['id'=>'check_qualite_real','class'=>'check_control']) }} Qualité de réalisation</h4>
<h4  style="margin-top:20px">{{ Form::checkbox('check_quantite_part', 'yes',true,['id'=>'check_quantite_part','class'=>'check_control']) }} Quantité de participation</h4>
<h4  style="margin-top:20px">{{ Form::checkbox('check_qualite_part', 'yes',true,['id'=>'check_qualite_part','class'=>'check_control']) }} Qualité de participation</h4>

<hr>
<h3 style="margin-top:35px">Solliciter des experts</h3><hr>
			<div class="hidden">
               {{$ligneName='ligne_experts';}}
               {{$ligneId='ligne_experts_is';}}
               {{$NbPerPage=15;}}
               {{$ligneClass='_experts_line';}}
               {{$checkNameAndId='check_experts_';}}
               {{$Nb_pages=ceil(count($les_experts)/$NbPerPage)+1;}}
               {{$Nb_El=count($les_experts);}}
               {{$pageId='page_experts';}}
             </div>
              
                      <div class="panel panel-info" style="margin-top:20px;margin-left:40px">
                        <div class="panel-heading" style="font-size:20px"><strong>Experts :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                    <tr>
                                        <th></th> 
                                        <th data-sort="string"><p class="btn btn-default trick" id="tri_nom" onclick="javascript:refresh_result('tri_nom','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                  		<th data-sort="string"><p class="btn btn-default trick" id="tri_prenom" onclick="javascript:refresh_result('tri_prenom','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Prenom</p></th>
                                  		<th data-sort="string"><p class="btn btn-default trick" id="tri_structure" onclick="javascript:refresh_result('tri_structure','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Structure</p></th>
                                  		<th data-sort="string"><p class="btn btn-default trick" id="tri_fonction" onclick="javascript:refresh_result('tri_fonction','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Fonction</p></th>
                                  		<th data-sort="string"><p class="btn btn-default trick" id="tri_ville" onclick="javascript:refresh_result('tri_ville','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Ville</p></th>
                                  	</tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($les_experts as $e)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      	<td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      	<td>{{ $e->nom }}</td>
                                   		<td>{{ $e->prenom }}</td>
                                   		<td>{{ $e->structure }}</td>
                                   		<td>{{ $e->fonction }}</td>
                                   		<td>{{ $e->ville }}</td>
                                    </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                            </div>
                          @for($p=1; $p < $Nb_pages;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('{{$pageId}}','{{$ligneName}}',{{$p}},{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" id="{{$pageId.$p}}">{{$p}}</p>
                             @endfor

                          </div>
                      </div>
{{Form::submit('Terminer',['class'=>'btn btn-success','style'=>'margin-top:25px;width:100%','name'=>'terminer_exp'])}}

<hr>
@if(count($expertises)>0)
<h4>Expertises définies :</h4>
@endif
<div class="hidden">{{$i=0;}}</div>
@foreach($expertises as $e)
  <div class="alert alert-warning" style="margin-top:10px">
    <h4>Expertise n° {{$i+1}}</h4>
    {{Form::submit('Supprimer',['class'=>'btn btn-danger pull-right','style'=>'margin-top:15px','name'=>'supprimer_'.$i])}}
     @if( $e->niveau_exp == 'tout_le_projet' )
         <h4>Le niveau d'expertise : tout le projet</h4>
      @endif
    @if( $e->niveau_exp == 'categorie' )
        <h4>Le niveau d'expertise : pour une catégorie d'activités.</h4>
    @endif
     @if( $e->niveau_exp == 'activite' )
        <h4>Le niveau d'expertise : pour une ou plusieurs activités.</h4>
    @endif
    @if( $e->periode_exp == 'tout_projet' )
        <h4>La période d'expertise : </h4>
         <h5 style="margin-left:15px"> tout le projet </h5>
    @endif
     @if( $e->periode_exp == 'periodes' )
        <h4>Périodes :</h4>
        @foreach($periodes_associees[$i] as $p)
          <h5 style="margin-left:15px">{{$p->nom}}, du {{ (new DateTime($p->date_debut))->format('d/m/Y') }} au {{ (new DateTime($p->date_fin))->format('d/m/Y') }}.</h5>
        @endforeach
    @endif
    <h4>Notation :</h4>
   @if( $e->quant_part == 'yes' )
        <h5 style="margin-left:15px">la quantité de participation est notée.</h5>
    @endif
    @if( $e->qual_part == 'yes' )
        <h5 style="margin-left:15px">la qualité de participation est notée.</h5>
    @endif
    @if( $e->quant_real == 'yes' )
        <h5 style="margin-left:15px">la quantité de réalisation est notée.</h5>
    @endif
    @if( $e->qual_real == 'yes' )
        <h5 style="margin-left:15px">la qualité de réalisation est notée.</h5>
    @endif
    <h4>Experts sollicités :</h4>
    @foreach($experts_associes[$i] as $exp)
      <h5 style="margin-left:15px">{{$exp->nom}} {{$exp->prenom}}; structure : {{$exp->structure}};fonction : {{$exp->fonction}}; ville {{$exp->ville}} : </h5>
    @endforeach
</div>
<div class="hidden">{{$i=$i+1;}}</div>
@endforeach




{{Form::close()}}
{{ HTML::script('js/gest_expertise.js'); }}
@stop