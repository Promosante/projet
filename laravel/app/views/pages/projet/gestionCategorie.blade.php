@extends('layout.projet_layout')
@section('projet-content')

  {{Form::open(array('url'=> URL::route('categorieactivite.action',$id)))}}
    <h2>Gestion des catégories d'activités<span class="glyphicon glyphicon-th pull-right"></span></h2>

   
 
    @if(Session::has('errors'))
                <div class="alert alert-danger">
                    @foreach ($errors as $message)
                        <p>{{ $message }}</p>
                    @endforeach 
                </div>
     @endif

     @if($success)
     <div class="alert alert-success">
        {{$success}}
      </div>
    @endif
     <div class="row">
         {{Form::submit("Consulter mes catégories d'activités",['class'=>'btn btn-primary btn-lg col-md-6 col-sm-6 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'consulter'])}}
    </div>


 

<div class="row" id="basics_categorie">   
  <hr>

    <div class="row">
          <div class="col-md-6">
              <h3 style="margin-top:35px">Ajouter une catégorie d'activité : </h3>
              <hr>
           </div> 
     </div>
     
     <div class="row"> 
        <div class="col-md-6">
            {{Form::label('description_ajout','Description',['class'=>'form-label'])}}
            {{Form::textarea('description_ajout', 'Description' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-4">
            {{Form::label('nom_ajout_cat','Nom de la catégorie',['class'=>'form-label'])}}
            {{Form::text('nom_ajout_cat', 'Nom' ,['class'=>'form-control'])}}
            {{Form::submit('Créer',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'ajout_categorie'])}}   
        </div>
    </div>
</div>
<hr>
  <div class="col-md-12"id="association_categorie">
    <div class="row" >
         

         <div class="row">
            <div class="row">
              <div class="col-md-6">
                  <h4 style="margin-top:35px">Associer des lieux  <div id="hide_lieux_p_cat" class="btn btn-danger" style="margin-left:15px"><span id="logo_lieux_p_cat" class="glyphicon glyphicon-eye-close"></span></div></h4> 
              </div>
            </div>
            <div class="row" id="content_lieux_p_cat"> 
                  <div class="row">
                    
                    <div class="col-md-4">
                      <a class="btn btn-success col-sm-2 col-xs-12" 
                            onclick="javascript:show_hidden_lieu();"
                              style="width:100%;margin-top:25px">
                              Ajouter un nouveau lieu
                      </a>
                    </div>
                    <div class="col-md-4">
                          <a class="btn btn-primary col-sm-2 col-xs-12" 
                              onclick="javascript:show_hidden_lieu_enr();"
                                style="width:100%;margin-top:25px">
                                Ajouter un lieu enregistré
                        </a>   
                    </div>
                    <div class="col-md-4">
                        {{Form::submit('Retirer lieu(x)',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'retirer_lieu'])}}   
                    </div>
                  </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Lieux attribués :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom" onclick="javascript:refresh_result('tri_nom','page_','ligne',{{$lieu_max_p+1}},{{count($lieux)}},5);" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_addr" onclick="javascript:refresh_result('tri_addr','page_','ligne',{{$lieu_max_p+1}},{{count($lieux)}},5);" style="width:100%;">Adresse</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_ville" onclick="javascript:refresh_result('tri_ville','page_','ligne',{{$lieu_max_p+1}},{{count($lieux)}},5);" style="width:100%;">Ville</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_cp" onclick="javascript:refresh_result('tri_cp','page_','ligne',{{$lieu_max_p+1}},{{count($lieux)}},5);" style="width:100%;">Code Postal</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php define('i',0); ?>
                                 @foreach ($lieux as $lieu)
                                 <?php $i=$i+1; ?>
                                    <tr id="lieu_cat_{{$i}}" name="ligne" onclick="javascript:hilight_line({{$i}},'lieu_cat_','check_lieu_','success lieu_cat_line','lieu_cat_line')" class="lieu_cat_line">
                                      <td>{{$i}} {{ Form::checkbox('check_lieu_'.$i, 'yes',false,['id'=>'check_lieu_'.$i]) }}</td>
                                      <td>{{ $lieu->nom }}</td>
                                      <td>{{ $lieu->adresse }}</td>
                                      <td>{{ $lieu->ville }}</td>
                                      <td>{{ $lieu->code_postal}}</td>
                                    </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                            </div>
                          @for($p=1; $p < $lieu_max_p+1;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_','ligne',{{$p}},{{$lieu_max_p+1}},{{count($lieux)}},5);" id="page_{{$p}}">{{$p}}</p>
                             @endfor

                          </div>
                      </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="row">
              <div class="col-md-6">
                  <h4 style="margin-top:35px">Associer des Membres  <div id="hide_membres_p_cat" class="btn btn-danger" style="margin-left:15px"><span id="logo_membres_p_cat" class="glyphicon glyphicon-eye-close"></span></div></h4> 
              </div>
            </div>
            <div class="row" id="content_membres_p_cat"> 
                  <div class="row">
                    
                    <div class="col-md-4">
                      <a class="btn btn-success col-sm-2 col-xs-12" 
                            onclick="javascript:show_hidden_membres();"
                              style="width:100%;margin-top:25px">
                              Ajouter un nouveau membre
                      </a>
                    </div>
                    <div class="col-md-4">
                          <a class="btn btn-primary col-sm-2 col-xs-12" 
                              onclick="javascript:show_hidden_membres_enr();"
                                style="width:100%;margin-top:25px">
                                Ajouter un membre enregistré
                        </a>   
                    </div>
                    <div class="col-md-4">
                        {{Form::submit('Retirer membre(s)',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'retirer_membres'])}}   
                    </div>
                  </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Membres attribués :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_membres" onclick="javascript:refresh_result('tri_nom_membres','page_membres','ligne_membres',{{ceil(count($membres)/5)+1}},{{count($membres)}},5);" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_prenom_membres" onclick="javascript:refresh_result('tri_prenom_membres','page_membres','ligne_membres',{{ceil(count($membres)/5)+1}},{{count($membres)}},5);" style="width:100%;">Prenom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_adresse_membres" onclick="javascript:refresh_result('tri_adresse_membres','page_membres','ligne_membres',{{ceil(count($membres)/5)+1}},{{count($membres)}},5);" style="width:100%;">Adresse</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_ville_membres" onclick="javascript:refresh_result('tri_ville_membres','page_membres','ligne_membres',{{ceil(count($membres)/5)+1}},{{count($membres)}},5);" style="width:100%;">Ville</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_status_membres" onclick="javascript:refresh_result('tri_status_membres','page_membres','ligne_membres',{{ceil(count($membres)/5)+1}},{{count($membres)}},5);" style="width:100%;">Status (futur)</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($membres as $membre)
                                 <?php $i=$i+1; ?>
                                    <tr id="membre_cat_{{$i}}" name="ligne_membres" onclick="javascript:hilight_line({{$i}},'membre_cat_','check_membre_','success membre_cat_line','membre_cat_line')" class="membre_cat_line">
                                      <td>{{$i}} {{ Form::checkbox('check_membre_'.$i, 'yes',false,['id'=>'check_membre_'.$i]) }}</td>
                                      <td>{{ $membre->nom }}</td>
                                      <td>{{ $membre->prenom }}</td>
                                      <td>{{ $membre->adresse}}</td>
                                      <td>{{ $membre->ville }}</td>
                                      <td>{{ $membre->status}}</td>
                                    </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                            </div>
                          @for($p=1; $p < ceil(count($membres)/5)+1;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_membre','ligne_membres',{{$p}},{{ceil(count($membres)/5)+1}},{{count($membres)}},5);" id="page_membres{{$p}}">{{$p}}</p>
                             @endfor

                          </div>
                      </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="row">
              <div class="col-md-6">
                  <h4 style="margin-top:35px">Associer des indicateurs <div id="hide_indic_p_cat" class="btn btn-danger" style="margin-left:15px"><span id="logo_indic_p_cat" class="glyphicon glyphicon-eye-close"></span></div></h4> 
              </div>
              
            </div>
            <div class="row" id="content_indic_p_cat"> 
                   <div class="alert alert-warning">
                      Vous devez au préalable avoir créer des indicateurs pour ce projet avant de pouvoir en ajouter.
                </div> 
                  <div class="row">

                     <div class="col-md-4">
                      <p class="btn btn-primary col-sm-2 col-xs-12" 
                            onclick="javascript:show_hidden_indic();"
                              style="width:100%;margin-top:25px">
                              Ajouter un indicateur enregistré
                      </p>
                    </div>
                    <div class="col-md-4">
                        {{Form::submit('Retirer un indicateur',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'ajout_lieu'])}}   
                    </div>
                  </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Indicateurs attribués :</strong> </div>
                          <div class="panel-body">

                                  <div class="table-responsive">  
                                  <table id="stupidTable" class="table table-hover table-condensed">
                                      <thead>
                                          <tr>
                                              <th></th>
                                              <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_indic" onclick="javascript:refresh_result('tri_nom_indic','page_indics_','ligne_indics_enr',{{ceil(count($indics)/15)+1}},{{count($indics)}},15);" style="width:100%;">Nom</p></th>
                                              <th data-sort="string"><p class="btn btn-default trick" id="tri_dom_indic" onclick="javascript:refresh_result('tri_dom_indic','page_indics_','ligne_indics_enr',{{ceil(count($indics)/15)+1}},{{count($indics)}},15);" style="width:100%;">Domaine</p></th>
                                              <th data-sort="string"><p class="btn btn-default trick" id="tri_decl_indic" onclick="javascript:refresh_result('tri_decl_indic','page_indics_','ligne_indics_enr',{{ceil(count($indics)/15)+1}},{{count($indics)}},15);" style="width:100%;">Declinaison</p></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php define('ll',0); ?>
                                        @foreach($indics as $indic)  
                                         <?php $ll=$ll+1; ?>
                                            <tr id="outils_cat_{{$ll}}" name="ligne_indics" onclick="javascript:hilight_line({{$ll}},'indics_cat_','check_indics_','pop_indics_cat_tr success','pop_indics_cat_tr');" class="pop_indics_cat_tr">
                                             <td>{{$ll}} {{ Form::checkbox('check_indics_'.$ll, 'yes',false,['id'=>'check_indics_'.$ll]) }}</td>
                                             <td>{{$indic->nom}}</td>
                                             <td>{{$indic->domaine}}</td>
                                             <td>{{$indic->declinaison}}</td>
                                            </tr>
                                        @endforeach 
                                      </tbody>
                                  </table>
                                </div> 
                               @for($p=1; $p < ceil(count($indics)/15)+1;$p=$p+1)
                                  <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_indics_','ligne_indics',{{$p}},{{ceil(count($indics)/15)+1}},{{count($indics)}},5);" id="page_indics_{{$p}}">{{$p}}</p>
                               @endfor
                             
                          </div>
                      </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
              <div class="col-md-6">
                  <h4 style="margin-top:35px">Associer des outils  <div id="hide_outils_p_cat" class="btn btn-danger" style="margin-left:15px"><span id="logo_outils_p_cat" class="glyphicon glyphicon-eye-close"></span></div></h4> 
              </div>
              
            </div>
            <div class="row" id="content_outils_p_cat">
                <div class="alert alert-warning">
                      Vous devez au préalable avoir créer des outils pour ce projet avant de pouvoir en ajouter.
                </div> 
                  <div class="row">

                    <div class="col-md-4">
                      <a class="btn btn-primary col-sm-2 col-xs-12" 
                            onclick="javascript:show_hidden_outils();"
                              style="width:100%;margin-top:25px">
                              Ajouter un outils existant
                      </a>
                    </div>

                    <div class="col-md-4">
                        {{Form::submit('Retirer un outil',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'supp_outils'])}}   
                    </div>
                  </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Outils attribués :</strong> </div>
                          <div class="panel-body">


                              <div class="table-responsive">  
                                <table id="stupidTable" class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_shad" onclick="javascript:refresh_result('tri_nom_shad','page_outils_','ligne_lieux_enr',{{ceil(count($outils)/15)+1}},{{count($outils)}},15);" style="width:100%;">Nom</p></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php define('l',0); ?>
                                      @foreach($outils as $outil)  
                                       <?php $l=$l+1; ?>
                                          <tr id="outils_cat_{{$l}}" name="ligne_outils" onclick="javascript:hilight_line({{$l}},'outils_cat_','check_outils_','pop_outils_cat_tr success','pop_outils_cat_tr');" class="pop_outils_cat_tr">
                                           <td>{{$l}} {{ Form::checkbox('check_outils_'.$l, 'yes',false,['id'=>'check_outils_'.$l]) }}</td>
                                           <td>{{$outil->nom}}</td>
                                          </tr>
                                      @endforeach 
                                    </tbody>
                                </table>
                              </div> 
                             @for($p=1; $p < ceil(count($outils)/15)+1;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_outils_','ligne_outils',{{$p}},{{ceil(count($outils)/15)+1}},{{count($outils)}},5);" id="page_outils_{{$p}}">{{$p}}</p>
                             @endfor

                          </div>
                      </div>
                </div>
            </div>
        </div> 
    </div>
  </div>  
  <div class="row">
     {{Form::submit('Terminer',['class'=>'btn btn-success col-md-2 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'terminer','id'=>'terminer'])}}     
  </div>  
    <div class="row" style="margin-top:10px;">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Supprimer une catégorie d'activité </h4>
              <hr>
           </div> 
     </div>

     <div class="row"> 
        <div class="col-md-5">
            {{Form::label('nom_supp','Nom de la catégorie (exact)',['class'=>'form-label'])}}
            {{Form::text('nom_supp', 'Nom' ,['class'=>'form-control'])}}
        </div>
        
        <div class="col-md-2">
            <p class="btn btn-danger" id="fake_supp_gest_cat_hide" style="margin-top:25px">Supprimer</p>
        </div>
    </div>

    <div class="row" id="alert_supp_gest_cat" style="margin-top:20px">
      
        <div class="alert alert-warning" >
            Confirmer suppression ? <br>
        </div>
        <div class="row">
             <p class="btn btn-success col-sm-2  col-xs-12 pull-left" id="cancel_supp_gest_cat">Annuler</p>
            {{Form::submit('Supprimer',['class'=>'btn btn-danger col-sm-2 col-xs-12 pull-right','name'=>'supp_cat'])}}
        </div> 
      
  </div>
{{Form::close()}}

@include('pages.projet.Shadow_lieux')
@include('pages.projet.Shadow_lieux_enregistres')
@include('pages.projet.Shadow_indicateurs')
@include('pages.projet.Shadow_outilsC')
@include('pages.projet.Shadow_membresC')
@include('pages.projet.Shadow_new_membresC')
{{ HTML::script('js/gest_cat.js'); }}

<script>
hide_hidden_lieu();
hide_hidden_lieu_enr();
hide_hidden_membres_enr();
hide_hidden_outils();
hide_hidden_indic();
hide_hidden_membres();
pagine_results('page_','ligne',1,{{$lieu_max_p+1}},{{count($lieux)}},5);
{{$script}}
</script>
@stop