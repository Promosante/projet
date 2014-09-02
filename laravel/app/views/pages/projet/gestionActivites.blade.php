@extends('layout.projet_layout')
@section('projet-content')

  {{Form::open(array('url'=> URL::route('activite.action',$id)))}}

    <h2>Gestion des activités<span class="glyphicon glyphicon-th pull-right"></span></h2>
    <div class="row">
         {{Form::submit('Consulter mes activités',['class'=>'btn btn-primary btn-lg col-md-6 col-sm-6 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'consulter'])}}
    </div> 
    <div class="row">
         @if(Session::has('errors'))
                    <br>
                    <div class="alert alert-danger">
                        @foreach ($errors as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                        
                    </div>
        @endif
        @if($success)
                    <br>
                    <div class="alert alert-success">
                        @foreach ($success as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                        
                    </div>
        @endif 
     </div>
     
     
<div class="row" id="basics_activites"> 
  <hr>  
  <div class="row" style="margin-top:15px">
          <div class="col-md-6"> 
              <h4 style="margin-top:35px">Ajouter une activité : </h4>
              <hr>
           </div> 
     </div>
        <div class="col-md-5">
            {{Form::label('objectif_ajout','Objectif',['class'=>'form-label'])}}
            {{Form::textarea('objectif_ajout', '' ,['class'=>'form-control'])}}
           
        </div>
        <div class="col-md-6">
            {{Form::label('nom_ajout','Nom',['class'=>'form-label'])}}
            {{Form::text('nom_ajout', '' ,['class'=>'form-control'])}}
            {{Form::label('date_deb_ajout','Date de début',['class'=>'form-label','style'=>'margin-top:20px;'])}}
            {{Form::text('date_deb_ajout', '' ,['class'=>'form-control'])}}
            {{Form::label('date_fin_ajout','Date de fin',['class'=>'form-label','style'=>'margin-top:20px;'])}}
            {{Form::text('date_fin_ajout', '' ,['class'=>'form-control'])}}
            {{Form::submit("Ajouter",['class'=>'btn btn-success col-md-6 col-sm-6 col-xs-12 pull-right','style'=>'margin-top:25px;width:100%','name'=>'ajout_act'])}}
        </div>
</div>
<div class="col-md-12"id="association_activites" style="margin-top:20px">
  <hr>
      @if($act_en_cour)
        <div class="alert alert-warning">
            <div class="row">
              <div class="col-md-4">
                <h4><strong>Nom</strong></h4>
                <h5>{{$act_en_cour[0]->nom}}</h5>
              </div>
               <div class="col-md-4">
                <h4><strong>Date début</strong></h4>
                 <h5>{{(new DateTime($act_en_cour[0]->date_debut))->format('d/m/Y')}}</h5>
              </div>
               <div class="col-md-4">
                <h4><strong>Date fin</strong></h4>
                 <h5>{{(new DateTime($act_en_cour[0]->date_fin))->format('d/m/Y')}}</h5>
              </div>
            </div>
        </div>
        <hr>
        @endif
        <h4>Attribuer des catégories d'activités <div id="hide_cat_p_act" class="btn btn-danger" style="margin-left:15px"><span id="logo_cat_p_act" class="glyphicon glyphicon-eye-close"></span></div></h4>
            <br>
            
           <div class="row" id="content_cat_p_act"> 
                  <div class="row">
                    
                    
                    <div class="col-md-4">
                          <a class="btn btn-primary col-sm-2 col-xs-12" 
                              onclick="javascript:show_hidden_cat()"
                                style="width:100%;margin-top:25px">
                                Ajouter une catégorie
                        </a>   
                    </div>
                    <div class="col-md-4">
                        {{Form::submit('Retirer catégorie(s)',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'retirer_cat'])}}   
                    </div>
                  </div>
               <div class="hidden">
                 {{$ligneName='ligne_cats_shad';}}
                 {{$ligneId='cat_shad_';}}
                 {{$NbPerPage=5;}}
                 {{$ligneClass='cat_shad_line';}}
                 {{$checkNameAndId='check_cats_act';}}
                 {{$Nb_pages=ceil(count($cat)/$NbPerPage)+1;}}
                 {{$Nb_El=count($cat);}}
                 {{$pageId='page_shad_cats';}}
               </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Catégories :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_c" onclick="javascript:refresh_result('tri_nom_c','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_descr_c" onclick="javascript:refresh_result('tri_descr_c','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Description</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($cat as $c)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      <td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      <td>{{ $c->nom }}</td>
                                      <td>{{ $c->descriptif }}</td>
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
                </div>
              </div>


          <h4>Attribuer des lieux <div id="hide_lieux_p_act" class="btn btn-danger" style="margin-left:15px"><span id="logo_lieux_p_act" class="glyphicon glyphicon-eye-close"></span></div></h4>
            <br>
            
           <div class="row" id="content_lieux_p_act"> 
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
                <div class="hidden">
                 {{$ligneName='ligne_lieux_shad';}}
                 {{$ligneId='lieu_shad_';}}
                 {{$NbPerPage=5;}}
                 {{$ligneClass='lieu_shad_line';}}
                 {{$checkNameAndId='check_lieux_act';}}
                 {{$Nb_pages=ceil(count($lieux)/$NbPerPage)+1;}}
                 {{$Nb_El=count($lieux);}}
                 {{$pageId='page_shad_lieux';}}
               </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Lieux :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_l" onclick="javascript:refresh_result('tri_nom_l','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_adresse_l" onclick="javascript:refresh_result('tri_adresse_l','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Adresse</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_ville_l" onclick="javascript:refresh_result('tri_ville_l','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Ville</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_code_postal_l" onclick="javascript:refresh_result('tri_code_postal_l','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Code Postal</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($lieux as $l)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      <td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      <td>{{ $l->nom }}</td>
                                      <td>{{ $l->adresse }}</td>
                                      <td>{{ $l->ville }}</td>
                                      <td>{{ $l->code_postal }}</td>
                                    </tr>
                                  @endforeach
                                <?php $i=0; ?>
                                 @foreach ($lieux_cat as $l)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" class="warning">
                                      <td>{{$i}}</td>
                                      <td>{{ $l->nom }}</td>
                                      <td>{{ $l->adresse }}</td>
                                      <td>{{ $l->ville }}</td>
                                      <td>{{ $l->code_postal }}</td>
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
                </div>
              </div>



          <h4>Attribuer des membres <div id="hide_membres_p_act" class="btn btn-danger" style="margin-left:15px"><span id="logo_membres_p_act" class="glyphicon glyphicon-eye-close"></span></div></h4>
            <br>
            
           <div class="row" id="content_membres_p_act"> 
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
                        {{Form::submit('Retirer membre(s)',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'retirer_membre'])}}   
                    </div>
                  </div>
                <div class="hidden">
                 {{$ligneName='ligne_membres_shad';}}
                 {{$ligneId='membre_shad_';}}
                 {{$NbPerPage=5;}}
                 {{$ligneClass='membre_shad_line';}}
                 {{$checkNameAndId='check_membres_act';}}
                 {{$Nb_pages=ceil(count($membres)/$NbPerPage)+1;}}
                 {{$Nb_El=count($membres);}}
                 {{$pageId='page_shad_membres';}}
               </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Lieux :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_m" onclick="javascript:refresh_result('tri_nom_m','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_prenom_m" onclick="javascript:refresh_result('tri_prenom_m','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Prenom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_status_m" onclick="javascript:refresh_result('tri_status_m','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Status</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_date_m" onclick="javascript:refresh_result('tri_date_m','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Date</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($membres as $m)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      <td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      <td>{{ $m->nom }}</td>
                                      <td>{{ $m->prenom }}</td>
                                      <td>{{ $m->status }}</td>
                                      <td>{{ $m->date }}</td>
                                    </tr>
                                  @endforeach
                                <?php $i=0; ?>
                                 @foreach ($membres_cat as $mc)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" class="warning">
                                      <td>{{$i}}</td>
                                      <td>{{ $mc->nom }}</td>
                                      <td>{{ $mc->prenom }}</td>
                                      <td>{{ $mc->status }}</td>
                                      <td>{{ $mc->date }}</td>
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
                </div>
              </div>

          <h4>Attribuer des indicateurs <div id="hide_indic_p_act" class="btn btn-danger" style="margin-left:15px"><span id="logo_indic_p_act" class="glyphicon glyphicon-eye-close"></span></div></h4>
            <br>
            
           <div class="row" id="content_indic_p_act"> 
                  <div class="row">
                    <div class="col-md-4">
                          <a class="btn btn-primary col-sm-2 col-xs-12" 
                              onclick="javascript:show_hidden_indics();"
                                style="width:100%;margin-top:25px">
                                Ajouter un indicateur
                        </a>   
                    </div>
                    <div class="col-md-4">
                        {{Form::submit('Retirer indicateur(s)',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'retirer_indic'])}}   
                    </div>
                  </div>
               <div class="hidden">
                 {{$ligneName='ligne_indics_shad';}}
                 {{$ligneId='indic_shad_';}}
                 {{$NbPerPage=5;}}
                 {{$ligneClass='indic_shad_line';}}
                 {{$checkNameAndId='check_indics_act';}}
                 {{$Nb_pages=ceil(count($indics)/$NbPerPage)+1;}}
                 {{$Nb_El=count($indics);}}
                 {{$pageId='page_shad_indics';}}
               </div>
                  <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Indicateurs :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_a" onclick="javascript:refresh_result('tri_nom_a','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_decli_a" onclick="javascript:refresh_result('tri_decli_a','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Déclinaison</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_dom_a" onclick="javascript:refresh_result('tri_dom_a','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Domaine</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_dest_a" onclick="javascript:refresh_result('tri_dest_a','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Destinataire</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($indics as $c)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      <td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      <td>{{ $c->nom }}</td>
                                      <td>{{ $c->declinaison }}</td>
                                      <td>{{ $c->domaine }}</td>
                                      <td>{{ $c->destinataire }}</td>
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
                </div>
              </div>
          <hr>
          <div class="row">
            <div class="alert alert-info">
                  Les périodes sont comprises dans la limite des dates de l'activité.
              </div>
              <div class="hidden">{{$i=0;}}</div>
              <div id="periodes">
                  @foreach($periodes as $p)
                   <div class="hidden">{{$i++;}}</div>

                       <div class="alert alert-warning">
                          <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">
                                   Période 
                                </label>
                             <h4>{{$i}}</h4>
                            </div>
                              <div class="col-md-4">
                                <label class="form-label" for="nom_ajout">
                                    Nom
                                </label>
                                <h4>{{$p->nom}}</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="date_deb_ajout">
                                    Date de début
                                </label>
                                <h4>{{ (new DateTime($p->date_debut))->format('d/m/Y') }}</h4>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="date_fin_ajout">
                                    Date de fin
                                </label>
                                <h4>{{(new DateTime($p->date_fin))->format('d/m/Y') }}</h4>
                            </div>
                            <div class="col-md-2">
                                <input class="btn btn-danger pull-right" type="submit" value="Retirer" name="retirer_p_{{$i}}"></input>
                            </div>
                        </div>
                      </div>

                @endforeach
              </div>
              <div class="btn btn-success" style="margin-top:20px" onclick="javascript:add_periode();">
                  Ajouter une periode 
              </div>
          </div>

          <hr>
        <div class="row">
              {{Form::submit("Enregistrer",['class'=>'btn btn-success col-md-6 col-sm-6 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'refresh_act'])}}
         </div>
         <div class="row">
              {{Form::submit("Terminer",['class'=>'btn btn-success col-md-6 col-sm-6 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'terminer_act'])}}
         </div>

</div>


    <div class="row" style="margin-top:10px;">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Supprimer une activité </h4>
              <hr>
           </div> 
     </div>

     <div class="row"> 
        <div class="col-md-5">
            {{Form::label('nom_supp','Nom (exact)',['class'=>'form-label'])}}
            {{Form::text('nom_supp', '' ,['class'=>'form-control'])}}
        </div>
        
        <div class="col-md-2">
            {{Form::submit('Supprimer',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'supp_act'])}}
        </div>
    </div>
{{Form::close()}}
{{ HTML::script('js/gest_act.js'); }}

@include('pages.projet.Shadow_lieuxA')
@include('pages.projet.Shadow_lieux_enregistres_a')
@include('pages.projet.Shadow_categories')
@include('pages.projet.Shadow_new_membresA')
@include('pages.projet.Shadow_membresA')
@include('pages.projet.Shadow_indicateurs_act')
<script>
hide_hidden_lieu();
hide_hidden_lieu_enr();
hide_hidden_cat();
hide_hidden_membres();
hide_hidden_membres_enr();
hide_hidden_indics();
pagine_results('page_cat','ligne_cat',1,{{ceil(count($cat)/5) }},{{count($cat)}},5);
pagine_results('page_lieu','ligne_lieu',1,{{ceil(count($lieux)/5) }},{{count($lieux)}},5);
{{$script}}
</script>
@stop