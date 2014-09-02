@extends('layout.projet_layout')
@section('projet-content')
 {{Form::open(array('url'=> URL::route('projectmembers.action',$id),'enctype'=>'multipart/form-data'))}}
    <h2>Gestion des membres <span class="glyphicon glyphicon-user pull-right"></span></h2>
    

    @if(Session::has('errors'))
                <br>
                <div class="alert alert-danger">
                    @if($line_err)
                      {{$line_err}}
                    @endif
                    @foreach (Session::get('errors')->all() as $message)
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
    <div class="row">
            <div class="panel panel-info" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>Membres</strong> </div>
                <div class="panel-body">
                      <div class="table-responsive">  
                          <table id="simpleTable" class="table table-hover table-condensed">
                              <thead>
                                  <tr> 
                                      <th></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_nom" onclick="javascript:refresh_result('tri_nom','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);" style="width:100%;">Nom</p></th>
                                       <th data-sort="string"><p class="btn btn-default trick" id="tri_prenom" onclick="javascript:refresh_result('tri_prenom','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);" style="width:100%;">Prenom</p></th>
                                       <th data-sort="string"><p class="btn btn-default trick" id="tri_act" onclick="javascript:refresh_result('tri_act','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);" style="width:100%;">Activité</p></th>
                                       <th data-sort="string"><p class="btn btn-default trick" id="tri_qual" onclick="javascript:refresh_result('tri_qual','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);" style="width:100%;">En qualité de</p></th>
                                      <th data-sort="int"><p class="btn btn-default trick" id="tri_date" onclick="javascript:refresh_result('tri_date','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);" style="width:100%;">Date</p></th>
                                  </tr>
                              </thead>
                              <tbody> 
                                  <?php $i=0; ?>
                                 @foreach ($results as $m)
                                    <?php $i=$i+1; ?>
                                    <tr name="ligne" id="member_{{$i}}" onclick="javascript:hilight_line({{$i}},'member_','check_','success member_line','member_line')" class="member_line">
                                      <td>{{$i}} {{ Form::checkbox('check_'.$i, 'yes',false,['id'=>'check_'.$i]) }}</td>
                                      <td>{{ $m->nom }}</td>
                                      <td>{{ $m->prenom }}</td>
                                      <td>{{ $m->activite }}</td>
                                      <td>{{ $m->status}}</td>
                                      <td data-sort-value="{{date_timestamp_get(date_create($m->date))}}">{{ $m->date}}</td>
                                      </tr>
                                  @endforeach
  
                              </tbody> 
                          </table>
                        </div>  
              
                    @for($p=1; $p < ceil(count($results)/15)+1;$p=$p+1)
                          <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_','ligne',{{$p}},{{ceil(count($results)/15)+1}},{{count($results)}},15);" id="page_{{$p}}">{{$p}}</p>
                      @endfor
                    
                </div>

              </div>
            </div>

    <h4 style="margin-top:35px"> <strong> Ajouter un membre :</strong></h4>
    <hr>

     <div class="row">
      <h4 style="margin-top:15px"><em>Si inscrit : </em></h4>
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                {{Form::label('login_ajout','Login',['class'=>'form-label'])}}
                {{Form::text('login_ajout', 'Login' ,['class'=>'form-control'])}}
            </div>
            <div class="col-md-3">
                {{Form::label('activite_ajout','Activité',['class'=>'form-label'])}}
                <br>
                {{Form::select('activite_ajout',$act,count($act),['style'=>'max-width:100%'])}}  
            </div>
            <div class="col-md-3">
                
                {{Form::label('qualite_ajout','En qualité de',['class'=>'form-label'])}}
                <br>
                {{Form::select('qualite_ajout', array('E' => 'Expert', 'C' => 'Collaborateur','I'=>'Intervenant','P'=>'Participant','N'=>'Non attribué'), 'N',['style'=>'max-width:100%'])}}
                   
            </div>
        </div>
        <div class="row">
            
                {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'membre_ajout'])}}
      
        </div>
        
    </div>

    <div class="row">
      <h4 style="margin-top:15px"><em>Si non-inscrit : </em></h4>
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                {{Form::label('nom_non_insc_ajout','Nom',['class'=>'form-label'])}}
                {{Form::text('nom_non_insc_ajout', '' ,['class'=>'form-control'])}}
            </div>
             <div class="col-md-3">
                {{Form::label('prenom_non_insc_ajout','Prenom',['class'=>'form-label'])}}
                {{Form::text('prenom_non_insc_ajout', '' ,['class'=>'form-control'])}}
            </div>
             <div class="col-md-5">
                {{Form::label('adresse_non_insc_ajout','Adresse',['class'=>'form-label'])}}
                {{Form::text('adresse_non_insc_ajout', '' ,['class'=>'form-control'])}}
            </div>
       </div>
       <div class="row">
           <div class="col-md-3 col-md-offset-1">
              {{Form::label('ville_non_insc_ajout','Ville',['class'=>'form-label','style'=>'margin-top:15px'])}}
              {{Form::text('ville_non_insc_ajout', '' ,['class'=>'form-control'])}}
          </div>
           <div class="col-md-2">
              {{Form::label('cp_non_insc_ajout','Code postal',['class'=>'form-label','style'=>'margin-top:15px'])}}
              {{Form::text('cp_non_insc_ajout', '' ,['class'=>'form-control'])}}
          </div>
          <div class="col-md-3">
              {{Form::label('activite_non_insc_ajout','Activité',['class'=>'form-label','style'=>'margin-top:15px'])}}
              <br>
              {{Form::select('activite_non_insc_ajout',$act,count($act),['style'=>'max-width:100%'])}}  
          </div>
          <div class="col-md-3">
            
            {{Form::label('qualite_non_insc_ajout','En qualité de',['class'=>'form-label','style'=>'margin-top:15px'])}}
            <br>
            {{Form::select('qualite_non_insc_ajout', array('E' => 'Expert', 'C' => 'Collaborateur','I'=>'Intervenant','P'=>'Participant','N'=>'Non attribué'), 'N',['style'=>'max-width:100%'])}}
               
        </div>
      </div>
      <div class="row">
        
        
             {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'membre_non_inscrit_ajout'])}}
        
      </div>
    </div>

    <h4 style="margin-top:35px"><strong>Modifier la catégorie d'un membre : </strong></h4>
    <hr>
     
     <div class="row">
        <div class="alert alert-info">
         Plusieurs coches modifie tout en même temps.  
        </div> 
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                
                {{Form::label('activite_modif','Activité',['class'=>'form-label'])}}
                <br>
                {{Form::select('activite_modif',$act,count($act),['style'=>'max-width:100%'])}}    
            </div>

            <div class="col-md-3">
                {{Form::label('qualite_modif','Modifie en qualité de',['class'=>'form-label'])}}
                <br>
                {{Form::select('qualite_modif', array('E' => 'Expert', 'C' => 'Collaborateur','I'=>'Intervenant','P'=>'Participant','N'=>'Non attribué'), 'N',['style'=>'max-width:100%'])}}  
            </div>
        </div>
        <div class="row">
                 {{Form::submit('Modifier',['class'=>'btn btn-primary col-sm-2 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'membre_modif'])}}
        </div>
       
    </div>

    <h4 style="margin-top:35px"><strong>Groupes de participants :</strong></h4>
    <hr>

    <div class="row">
     
            <div class="hidden">
              {{$ligneName='ligne_participant';}}
               {{$ligneId='membre_participant_';}}
               {{$NbPerPage=15;}}
               {{$ligneClass='membre_participant_line';}}
               {{$checkNameAndId='check_participant_shad_';}}
               {{$Nb_pages=ceil(count($TousLesParticipants)/$NbPerPage)+1;}}
               {{$Nb_El=count($TousLesParticipants);}}
               {{$pageId='page_participant_membres';}}
             </div>
              
                      <div class="panel panel-info" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Participants :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_part" onclick="javascript:refresh_result('tri_nom_part','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_prenom_part" onclick="javascript:refresh_result('tri_prenom_part','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Prenom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_act_part" onclick="javascript:refresh_result('tri_act_part','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Activité</p></th>
                                           <th data-sort="string"><p class="btn btn-default trick" id="tri_groupe" onclick="javascript:refresh_result('tri_groupe','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Groupe</p></th>
                                            <th data-sort="string"><p class="btn btn-default trick" id="tri_ss_groupe" onclick="javascript:refresh_result('tri_ss_groupe','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Sous groupe</p></th>
                                      
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($TousLesParticipants as $p)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      <td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      <td>{{ $p->nom }}</td>
                                      <td>{{ $p->prenom }}</td>
                                      <td>{{ $p->activite }}</td>
                                      <td>
                                        <div class="hidden">{{$j=0;}}</div>
                                        @for($j=0; $j < count($groupe_associes[$i-1]); $j++)
                                          {{ $groupe_associes[$i-1][$j] }}
                                        @endfor
                                      </td>
                                      <td>
                                        <div class="hidden">{{$j=0;}}</div>
                                        @for($j=0; $j < count($ss_groupes_associes[$i-1]); $j++)
                                          {{ $ss_groupes_associes[$i-1][$j] }}
                                        @endfor
                                      </td>
                                      
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
             

          <div class="row">
            <hr style="margin-top:15px">
            
               <h4 style="margin-top:15px"><em>Affectation de groupe</em></h4>
               <div class="col-md-4">
                 {{Form::label('groupe_affecte','Groupe',['class'=>'form-label'])}}<br>
                   {{Form::select('groupe_affecte', $groupes,0,['style'=>'max-width:100%','id'=>'groupe_affect'])}}
                </div>
                <div class="col-md-4">
                    <div class="hidden">{{$i=0;}}</div>
                    {{Form::label('osef','Sous Groupe',['class'=>'form-label'])}}<br>
                @foreach($groupes as $g)
                    {{Form::select('ss_groupe_affecte_'.$i, $ssgroupes[$i], 0,['style'=>'max-width:100%','class'=>'groupe_propose','id'=>'groupe_'.$i,'name'=>'ss_groupe_affecte_'.$i ] ) }}
                  <div class="hidden">{{$i++;}}</div>
                @endforeach
                    
                </div>
                 <div class="col-md-4">
                        {{Form::submit('Affecter',['class'=>'btn btn-success col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'affecter'])}}
                  </div>
            </div>
            <br>
            <hr style="margin-top:15px">
            <hr>
              <div class="row">
              <h4 style="margin-top:15px"><em>Création de groupes</em></h4>
                <div class="col-md-4">
                    {{ Form::label('groupe','Nom du groupe',['class'=>'form-label']) }}
                    {{ Form::text('groupe', '' ,['class'=>'form-control','name'=>'nom_create_groupe']) }}
                </div>
                <div class="col-md-4">
                   {{Form::submit('Nouveau groupe',['class'=>'btn btn-success col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'new_groupe'])}}
                </div>
                <div class="col-md-4">
                   
                </div>
              </div>

           <div class="row">
                  <hr style="margin-top:15px">
                  <h4 style="margin-top:15px"><em>Création de sous groupes</em></h4>
                   <div class="col-md-4">
                      {{Form::label('groupe_pour_ssgroupes_creation','Nom du groupe',['class'=>'form-label'])}}<br>
                       {{Form::select('groupe_pour_ssgroupes_creation', $groupes, '',['style'=>'max-width:100%','name'=>'groupe_pour_ssgroupes_creation'])}}
                    </div>

                    <div class="col-md-4">
                        {{Form::label('sous_groupe_nom','Nom du sous-groupe',['class'=>'form-label'])}}
                        {{Form::text('sous_groupe_nom', '' ,['class'=>'form-control'])}}
                    </div>

                    <div class="col-md-4">
                         {{Form::submit('Nouveau sous groupe',['class'=>'btn btn-success col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'new_ss_groupe'])}}
                    </div>
            </div>
             <hr>
             <hr>  
     

    </div>

    <h4 style="margin-top:35px"><strong>Générer des comptes: </strong></h4>
    <hr>

      <div class="row">
        <div class="row">
            <div class="col-md-3 col-md-offset-1">
                {{Form::label('nb_comptes','Nombre de comptes',['class'=>'form-label'])}}
                {{Form::text('nb_comptes', '10' ,['class'=>'form-control'])}}
            </div>
            <div class="col-md-3">
                {{Form::label('activite_genere','Activité',['class'=>'form-label'])}}
                <br>
                {{Form::select('activite_genere',$act,count($act),['style'=>'max-width:100%'])}}  
            </div>
            <div class="col-md-3">
                {{Form::label('qualite_genere','En qualité de',['class'=>'form-label'])}}
                <br>
                {{Form::select('qualite_genere', array('E' => 'Expert', 'C' => 'Collaborateur','I'=>'Intervenant','P'=>'Participant','N'=>'Non attribué'), 'N',['style'=>'max-width:100%'])}}
            </div> 
        </div> 
        <div class="row">
              <div class="btn btn-success pull-right" id="fake_gen" style="margin-top:25px">Générer des comptes</div>
        </div>
     </div>
     <div class="row" id="gen_compte_instruc" style="margin-top:20px">
        <div class="alert alert-warning">
            Un fichier au format CSV contenant les informations des comptes va être édité. Vous devez accepter le téléchargement et ne pas perdre ces données car le téléchargement ne sera proposé qu'une fois (et l'administrateur ne peut pas retrouver les mots de passe des comptes générés). En cas de perte veuillez contacter l'administrateur pour effacer les comptes générés et en créer de nouveaux.
        </div> 
        <div class="col-md-3">
           <div class="btn btn-danger" id="cancel_gen" style="width:100%">Annuler</div>
        </div>
        <div class="col-md-6">
          
        </div>
        <div class="col-md-3">
          {{Form::submit('Générer des comptes',['class'=>'btn btn-success col-sm-2 col-xs-12 pull-right','name'=>'genere_comptes'])}}
        </div>
        
     </div>
    <h4 style="margin-top:35px"><strong>Supprimer un membre : </strong></h4>
    <hr>

     <div class="row"> 
             {{Form::submit('Supprimer',['class'=>'btn btn-danger col-sm-2 col-xs-12 pull-right','name'=>'membre_supp'])}}
    </div>

    <h4 style="margin-top:35px"><strong>Télécharger données CSV</strong></h4>
    <hr>

     <div class="row"> 
           {{Form::submit('Download !',['class'=>'btn btn-info col-sm-2 col-xs-12 pull-right','name'=>'down_csv'])}}
    </div>

    <h4 style="margin-top:35px"><strong>Importer données CSV</strong></h4>
    <hr>
     <div class="row"> 
          <div class="alert alert-info">
              L'ordre des champs doit être le suivant : nom,prénom,adresse,ville,code_postal,NomActivité(exact ou vide si non-attribué),Qualité(parmis les 4 ou vide si non-attribué). La première ligne est ignorée et les champs doivent avoir moins de 1024 caractères. Si vous passez des lignes à la fin du fichier vous obtiendrez une erreur (sans conséquence pour la saisie).
          </div>
            <div class="form-group"> 
                  {{ Form::file('fichier') }}
                
                {{Form::submit('Go!',['class'=>'btn btn-info col-sm-2 col-xs-12 pull-right','name'=>'upload_csv'])}}
            </div>
          
    </div>

 {{Form::close()}}

 {{ HTML::script('js/gest_membres.js'); }}

 <script>

pagine_results('page_','ligne',1,{{ceil(count($results)/15)+1}},{{count($results)}},15);
 </script>
@stop