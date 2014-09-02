@extends('layout.basic_layout')
@section('body')
{{Form::open(array('url'=> URL::route('visuprojet.action',$hash),'enctype'=>'multipart/form-data'))}}
 <div class="row" style="margin-top:15px">
    <div class="col-md-10 col-md-offset-1">
     @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
         @endif

    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{Session::get('error')}}
                    </div>
         @endif
    <div class="row">
          <div class="col-md-7">
                <h1>Projet</h1>
                <hr>
                <h2 style="text-align:justify;text-justify:inter-word;margin-right:20px">{{$projet->titre}}</h2>
          </div>

          <div class="col-md-5">
              @if(count($status)>0)
              <div class="alert alert-warning pull-right">
                     @foreach($status as $s)
                       Vous avez le status de : {{$s}} pour ce projet.<br>    
                    @endforeach   
              </div> 
              @else 
                <div class="alert alert-warning pull-right">
                    Vous n'êtes pas associé a ce projet.
                </div>
              @endif
          </div>
    </div>

    <div class="row">
       <div class="col-md-8">
        <h3>Participer au projet en tant que : </h3>
        {{Form::select('qualite_ajout', array('E' => 'Expert', 'C' => 'Collaborateur','I'=>'Intervenant','P'=>'Participant','N'=>'Non attribué'), 'N',['style'=>'max-width:100%'])}}
        <h3> Pour l'activité :</h3>
        {{Form::select('activite_ajout',$act,count($act),['style'=>'max-width:100%'])}}<br>  
        {{Form::submit('Envoyer une demande',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:60%;margin-top:25px','name'=>'participer'])}}
        
      </div>
    </div>   
        <div class="row">
            <div class="panel panel-success" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>{{$projet->acronyme}} </strong></div>
                <div class="panel-body">
                  <div class="col-md-12">

                    <div class="row">
                      <div class="panel panel-info" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Informations</strong></div>
                          <div class="panel-body">

                            <h4><strong> Objectif principal : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$projet->objectif}}<br><br></h4>
                            <h4><strong> Objectif spécifique :  </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;">{{$projet->objectif_specifique}} <br><br></h4>
                            <h4><strong> Population cible :  </strong></h4><h4 style="margin-left:30px;"> {{$projet->population_cible}}<br><br></h4>
                            <h4><strong> Date de début :  </strong></h4><h4 style="margin-left:30px;"> {{$projet->date_debut}}<br><br></h4>
                            <h4><strong> Date de fin : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$projet->date_fin}}<br><br></h4>
                          </div>
                        </div>
                      </div>

                    <div class="row">
                      <div class="panel panel-info" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Activités Programmés</strong></div>
                          <div class="panel-body">
                              @foreach($activites as $act)
                              <div class="hidden">
                                {{$i=0;}}
                              </div>
                                <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"><span class="glyphicon glyphicon-chevron-right pull-left"></span> {{$act->nom}}, 
                                
                                </h4>
                                <div class="hidden">
                                 {{$i=$i+1;}}
                                </div>
                              @endforeach
                          </div>
                        </div>
                      </div>


                       </div>
                     </div>
                   </div>
        </div>
        
       

        @foreach($status as $s)
            @if($s=='Intervenant')    
                    
           <div class="row">
              <div class="panel panel-warning" style="margin-top:20px">
                <div class="panel-heading" style="font-size:20px"><strong>Comptes rendus</strong></div>
                  <div class="panel-body">
                    <div class="alert alert-warning">
                      En qualité d'intervenant vous avez la possibilité de déposer des comptes rendus.
                    </div>
                    <h4>Déposer un compte rendu pour :</h4>
                    <h5>Le projet entier {{ Form::checkbox('cr_check_projet', 'yes',false,['id'=>'cr_check_projet']) }} </h5>
                    <h5>La catégorie {{Form::select('cr_cat_sel',$categories_cr,count($categories_cr)-1,['style'=>'max-width:100%'])}}</h5>
                    <h5>L'activité {{Form::select('cr_act_sel',$activites_cr,count($activites_cr)-1,['style'=>'max-width:100%','id'=>'cr_act_sel','onchange'=>'javascript:show_periode();'])}}</h5>
                    <div class="hidden">{{$i=0;}}</div>
                    <h5>La période
                      @foreach($periodes_cr as $p)
                         {{Form::select('cr_p_sel_'.$i,$p,count($p)-1,['style'=>'max-width:100%','class'=>'periode_choix','id'=>'cr_p_sel_'.$i,'onchange'=>"javascript:show_evenements(".$i.");"])}}
                        <div class="hidden">{{$i++;}}</div>
                      @endforeach
                    </h5>
                    <div class="hidden">{{$i=0;}}</div>
                    <div class="hidden">{{$j=0;}}</div>
                        <h5>L'evenement 
                          @for($i=0;$i < count($evenements_cr);$i++)
                            @for($j=0;$j < count($evenements_cr[$i]);$j++)
                                {{Form::select('cr_p_sel_'.$i.'_'.$j,$evenements_cr[$i][$j],count( $evenements_cr[$i][$j] )-1, ['style'=>'max-width:100%','class'=>'evenements_choix','id'=>'cr_p_sel_'.$i.'_'.$j ] ) }}
                            @endfor
                          @endfor
                        </h5>
                      {{ Form::file('fichier') }}
                
                      {{Form::submit('Go!',['class'=>'btn btn-info col-sm-2 col-xs-12 pull-right','name'=>'upload_cr'])}}

              </div>
            </div>
          </div>



           <div class="row">
              <div class="panel panel-warning" style="margin-top:20px">
                <div class="panel-heading" style="font-size:20px"><strong>Fiches de synthèses</strong></div>
                  <div class="panel-body">
                    <div class="alert alert-warning">
                      En qualité d'intervenant vous avez la possibilité de déposer des fiches de synthèses.
                    </div>
                    <h4>Editer la fiche de synthèse pour l'évènement :</h4>
                    {{ Form::select('fiche_syn_choix_eve',$eve_fiche_syn,0, ['style'=>'max-width:100%' ] ) }}

                    <h4>Nombre de participants :</h4>
                      {{ Form::text('fiche_syn_nb_part','',['style'=>'margin-right:35px']) }}
                    <h4>Prévus :</h4>
                      {{ Form::text('fiche_syn_nb_prevus','',['style'=>'margin-right:35px'])}}
                    <h4>Date effective de début : (jj/MM/aaaa)</h4>
                      {{ Form::text('fiche_syn_date_deb','',['style'=>'margin-right:35px']) }}
                    <h4>Heure effective de début : (jj/MM/aaaa)</h4>
                      {{ Form::text('fiche_syn_h_deb','',['style'=>'margin-right:35px']) }}
                    <h4>Date effective de fin :</h4>
                      {{ Form::text('fiche_syn_date_fin','',['style'=>'margin-right:35px']) }}
                    <h4>Heure effective de fin :</h4>
                      {{ Form::text('fiche_syn_h_fin','',['style'=>'margin-right:35px']) }}
                    <h4>Remarques/commentaires : </h4>
                      {{ Form::textarea('fiche_syn_rem_com','',['style'=>'margin-right:35px']) }}<br>
                    {{Form::submit('Sauver',['class'=>'btn btn-success col-sm-2 col-xs-12 pull-right','name'=>'save_fiche_syn'])}}
              </div>
            </div>
          </div>



          <div class="row">
              <div class="panel panel-warning" style="margin-top:20px">
                <div class="panel-heading" style="font-size:20px"><strong>Indicateurs</strong></div>
                  <div class="panel-body">
                    <div class="alert alert-warning">
                      En qualité d'intervenant vous avez la possibilité de répondre aux indicateurs auxquels vous êtes associé.
                    </div>

                   <h4><strong>Quantité de participation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                      @for($i=0;$i < count($indicateurs);$i++)
                          @if($indicateurs[$i]->domaine == 'participation')
                            @if($indicateurs[$i]->declinaison =='quantite')
                              <h4 style="margin-left:15px">{{$indicateurs[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                             </h4> {{$indicateurs[$i]->question}}
                                @for($j=0;$j < count($rep_indics[$i]); $j++)

                               
                                   @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif

                                @endfor
                                <hr>
                            @endif
                          @endif
                          
                      @endfor
                  <h4> <strong>Qualité de participation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                       @for($i=0;$i < count($indicateurs);$i++)
                          @if($indicateurs[$i]->domaine == 'participation')
                            @if($indicateurs[$i]->declinaison =='qualite')
                              <h4 style="margin-left:15px">{{$indicateurs[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                             </h4> {{$indicateurs[$i]->question}}
                               @for($j=0;$j < count($rep_indics[$i]); $j++)
                                   @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif


                                @endfor
                                <hr>
                            @endif
                          @endif
                          
                      @endfor
                    <h4><strong>Qualité de réalisation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                     @for($i=0;$i < count($indicateurs);$i++)
                            @if($indicateurs[$i]->domaine == 'realisation')
                              @if($indicateurs[$i]->declinaison =='qualite')
                                <h4 style="margin-left:15px">{{$indicateurs[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                              </h4>{{$indicateurs[$i]->question}}
                               @for($j=0;$j < count($rep_indics[$i]); $j++)
                             
                                    @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif


                                @endfor
                                 <hr>
                              @endif
                            @endif
                           
                        @endfor
                    <h4><strong>Quantité de réalisation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                     <div class="hidden">{{$j=0;}}</div>
                      @for($i=0;$i < count($indicateurs);$i++)
                          @if($indicateurs[$i]->domaine == 'realisation')
                            @if($indicateurs[$i]->declinaison =='quantite')
                             <hr>
                              <h4 style="margin-left:15px">{{$indicateurs[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                              </h4>{{$indicateurs[$i]->question}}
                                @for($j=0;$j < count($rep_indics[$i]); $j++)
                                   @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif

                                   
                                @endfor
                                <hr>
                            @endif
                          @endif
                          
                      @endfor
                      {{Form::submit('Sauver/mettre à jour',['class'=>'btn btn-success','style'=>'margin-top:25px','name'=>'sauver_indics'])}}
              </div>
            </div>
          </div>

          @endif
          @if($s=='Participant')
          <div class="row">
              <div class="panel panel-warning" style="margin-top:20px">
                <div class="panel-heading" style="font-size:20px"><strong>Indicateurs</strong></div>
                  <div class="panel-body">
                    <div class="alert alert-warning">
                      En qualité de participant vous avez la possibilité de répondre aux indicateurs auxquels vous êtes associé.
                    </div>
                    <h4><strong>Quantité de participation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                      @for($i=0;$i < count($indicateurs_p);$i++)
                          @if($indicateurs_p[$i]->domaine == 'participation')
                            @if($indicateurs_p[$i]->declinaison =='quantite')
                              <h4 style="margin-left:15px">{{$indicateurs_p[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                              </h4>{{$indicateurs_p[$i]->question}}
                               @for($j=0;$j < count($rep_indics_p[$i]); $j++)

                                  @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif

                                @endfor
                            @endif
                          @endif
                          <hr>
                      @endfor
                  <h4> <strong>Qualité de participation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                       @for($i=0;$i < count($indicateurs_p);$i++)
                          @if($indicateurs_p[$i]->domaine == 'participation')
                            @if($indicateurs_p[$i]->declinaison =='qualite')
                              <h4 style="margin-left:15px">{{$indicateurs_p[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                              </h4>{{$indicateurs_p[$i]->question}}
                               @for($j=0;$j < count($rep_indics_p[$i]); $j++)
                                   @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif


                                @endfor
                            @endif
                          @endif
                          <hr>
                      @endfor
                    <h4><strong>Qualité de réalisation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                     @for($i=0;$i < count($indicateurs_p);$i++)
                            @if($indicateurs_p[$i]->domaine == 'realisation')
                              @if($indicateurs_p[$i]->declinaison =='qualite')
                                <h4 style="margin-left:15px">{{$indicateurs_p[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                              </h4>{{$indicateurs_p[$i]->question}}
                               @for($j=0;$j < count($rep_indics_p[$i]); $j++)
                                  @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif


                                @endfor
                              @endif
                            @endif
                            <hr>
                        @endfor
                    <h4><strong>Quantité de réalisation :</strong></h4>
                    <div class="hidden">{{$i=0;}}</div>
                     <div class="hidden">{{$j=0;}}</div>
                      @for($i=0;$i < count($indicateurs_p);$i++)
                          @if($indicateurs_p[$i]->domaine == 'realisation')
                            @if($indicateurs_p[$i]->declinaison =='quantite')
                             <hr>
                              <h4 style="margin-left:15px">{{$indicateurs_p[$i]->nom}} ( activité : <strong>{{$indicateurs[$i]->act_nom}}</strong>; evenement : <strong>{{$indicateurs[$i]->nom_eve}}</strong>) : 
                              </h4>{{$indicateurs_p[$i]->question}}
                                @for($j=0;$j < count($rep_indics_p[$i]); $j++)
                                    
                                  @if($rep_indics[$i][$j]->type=='libre') 
                                       @if(count($rep_user_indics[$i][$j])>0)
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, $rep_user_indics[$i][$j][0]->contenu ,['class'=>'form-control']) }} </h4>
                                       @else
                                          <h4 style="margin-left:25px"> {{ $rep_indics[$i][$j]->contenu }} : 
                                        {{ Form::text('rep_'.$i.'_'.$j, '' ,['class'=>'form-control']) }} </h4>
                                      @endif
                                    @else
                                       @if(count($rep_user_indics[$i][$j])>0)
                                            @if($rep_user_indics[$i][$j][0]->contenu == 'yes')
                                              <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',true) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                            @endif
                                        @else
                                             <h4 style="margin-left:25px"> {{ Form::checkbox('check_'.$i.'_'.$j, 'yes',false) }} {{ $rep_indics[$i][$j]->contenu }}</h4>
                                        @endif
                                    @endif

                                   
                                @endfor
                            @endif
                          @endif
                          <hr>
                      @endfor
                      {{Form::submit('Sauver/mettre à jour',['class'=>'btn btn-success','style'=>'margin-top:25px','name'=>'sauver_indics'])}}
              </div>
            </div>
          </div>
          
          @endif
          @if($s=='Expert')
            @if(count($expertises)>0)
              <hr>
              <hr>
              <div class="alert alert-warning">
                  En qualité d'expert vous avez été associé à certaines expertises du projet.
              </div>
              @else
              <hr>
              <hr>
              <div class="alert alert-warning">
                  Aucune expertise n'a été définie pour le projet pour l'instant.
              </div>
            @endif
            
            
            @for($i=0;$i < count( $ensemble_evenement );$i++) 
            <div class="row">
              <div class="panel panel-warning" style="margin-top:20px">
                <div class="panel-heading" style="font-size:20px"><strong>Expertise {{$i+1}}</strong></div>
                  <div class="panel-body">
                    @if( $expertises[$i]->niveau_exp == 'tout_le_projet' )
                        <h4>Le niveau d'expertise a été défini sur tout le projet</h4>
                    @endif
                    @if( $expertises[$i]->niveau_exp == 'categorie' )
                        <h4>Le niveau d'expertise a été défini pour une catégorie d'activités.</h4>
                    @endif
                     @if( $expertises[$i]->niveau_exp == 'activite' )
                        <h4>Le niveau d'expertise a été défini pour une ou plusieurs activités.</h4>
                    @endif
                    @if( $expertises[$i]->periode_exp == 'tout_projet' )
                        <h4>La période d'expertise a été défini pour tout le projet.</h4>
                    @endif
                     @if( $expertises[$i]->periode_exp == 'periodes' )
                        <h4>La période d'expertise a été défini pour une ou plusieurs périodes.</h4>
                    @endif
                         @for($j=0;$j < count( $ensemble_evenement[$i] );$j++)
                          @if( $expertises[$i]->periode_exp == 'periodes' )
                          <h3> <strong> Période {{$j+1}} : </strong> {{$periodes_expertises[$i][$j]->nom }}</h3>
                           <h4>Du {{ (new DateTime($periodes_expertises[$i][$j]->date_debut))->format('d/m/Y') }} au {{ (new DateTime($periodes_expertises[$i][$j]->date_fin))->format('d/m/Y') }}.</h4>
                           <hr>
                           <hr>
                           @endif
                            @if( $expertises[$i]->periode_exp == 'tout_projet' )
                             <h3> <strong> Période : </strong> ensemble du projet.</h3>
                            @endif
                           @for($k=0;$k < count($ensemble_evenement[$i][$j]);$k++)
                            <h4><strong> activite {{$k+1}} : </strong></h4>
                             <hr>
                             @if( count($ensemble_evenement[$i][$j][$k])>0 )
                                 Evenements concernés : 
                                  @for($l=0;$l < count($ensemble_evenement[$i][$j][$k]);$l++)
                                    {{$ensemble_evenement[$i][$j][$k][$l]->nom}} |
                                  @endfor
                                  <hr>
                                  <hr>
                                  <h5><strong>Réalisation : </strong></h5>
                                  <h5><strong>Quantité</strong></h5>
                                    @for($r = 0; $r < count($indics_infos_exp[$i][$j][$k]) ;$r++ )
                                      <hr>
                                      @if( $indics_infos_exp[$i][$j][$k][$r]->domaine == 'realisation')
                                          @if(  $indics_infos_exp[$i][$j][$k][$r]->declinaison == 'quantite')
                                            @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'intervenant')
                                               <h5>(destinataires : intervenant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }}  </h5>
                                                 
                                                 @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                  <h5 >( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}}  </h5>
                                                   <h5 style="margin-left:10px">  Résultat obtenus :</h5>
                                                    @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                       {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}} |
                                                    @endfor
                                                    <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                      @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif

                                                    <br>
                                                    <br>
                                                @endfor
                                            @endif
                                            @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'participant')
                                               <h5>(destinataires : participant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }}  </h5>
                                                @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                  <h5 >( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}}  </h5>
                                                   <h5 style="margin-left:10px"> Résultat obtenus :</h5>
                                                    @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                       {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}} |
                                                    @endfor
                                                    <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                    @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif
                                                    <br>
                                                    <br>
                                                @endfor
                                            @endif
                                        @endif
                                      @endif
                                    @endfor

                                 @if($expertises[$i]->quant_part == 'yes')
                                    <h5>Définir une note pour la quantité de réalisation : </h5>
                                      @if(count($results_exp[$i][$j][$k]['qt_r']) > 0 )
                                        {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantreal',$results_exp[$i][$j][$k]['qt_r'],['style'=>'margin-right:35px']) }}
                                      @else
                                        {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantreal','',['style'=>'margin-right:35px']) }}
                                      @endif
                                 @endif

                                <h5><strong>Qualité</strong></h5>
                                  @for($r = 0; $r < count($indics_infos_exp[$i][$j][$k])  ;$r++ )
                                      <hr>
                                      @if( $indics_infos_exp[$i][$j][$k][$r]->domaine == 'realisation')
                                          @if(  $indics_infos_exp[$i][$j][$k][$r]->declinaison == 'qualite')
                                            @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'intervenant')
                                               <h5>(destinataires : intervenant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }} </h5>
                                                @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                 <h5 > ( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}}  </h5>
                                                  <h5 style="margin-left:10px"> Résultat obtenus :</h5>
                                                  @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                     {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}} |
                                                  @endfor
                                                  <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                  @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif
                                                  <br>
                                                  <br>
                                                @endfor
                                            @endif
                                            @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'participant')
                                               <h5>(destinataires : participant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }} </h5>
                                              @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                <h5 >  ( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}}  </h5>
                                                 <h5 style="margin-left:10px">    Résultat obtenus :</h5>
                                                    @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                       {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}}
                                                    @endfor
                                                    <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                    @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif
                                                    <br>
                                                    <br>
                                                @endfor
                                            @endif
                                        @endif
                                      @endif
                                    @endfor
                                 @if($expertises[$i]->quant_part == 'yes')
                                    <h5>Définir une note pour la qualité de réalisation : </h5>
                                     @if(count($results_exp[$i][$j][$k]['ql_r']) > 0 )
                                      {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualreal',$results_exp[$i][$j][$k]['ql_r'],['style'=>'margin-right:35px']) }}
                                     @else
                                      {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualreal','',['style'=>'margin-right:35px']) }}                                    
                                    @endif
                                 @endif
                                 <h5><strong>Participation : </strong></h5>
                                 <h5><strong>Quantité</strong></h5>
                                     @for($r = 0; $r < count($indics_infos_exp[$i][$j][$k]);$r++ )
                                     <hr>
                                        @if( $indics_infos_exp[$i][$j][$k][$r]->domaine == 'participation')
                                            @if(  $indics_infos_exp[$i][$j][$k][$r]->declinaison == 'quantite')
                                              @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'intervenant')
                                                <h5>(destinataires : intervenant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }}  </h5>
                                               @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                 <h5 > ( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}}  </h5>
                                                   <h5 style="margin-left:10px">  Résultat obtenus :</h5>
                                                    @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                       {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}} |
                                                    @endfor
                                                    <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                    @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif
                                                    <br>
                                                    <br>
                                                @endfor
                                              @endif
                                              @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'participant')
                                                 <h5>(destinataires : participant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }}  </h5>
                                                 @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                 <h5 > ( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}}  </h5>
                                                  <h5 style="margin-left:10px">   Résultat obtenus :</h5>
                                                    @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                       {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}} |
                                                    @endfor
                                                    <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                    @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif
                                                    <br>
                                                    <br>
                                                @endfor

                                              @endif
                                          @endif
                                        @endif
                                      @endfor
                                 @if($expertises[$i]->quant_part == 'yes')
                                    <h5>Définir une note pour la quantité de participation : </h5>
                                    @if(count($results_exp[$i][$j][$k]['qt_p']) > 0 )  
                                      {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantpart',$results_exp[$i][$j][$k]['qt_p'],['style'=>'margin-right:35px']) }}                     
                                    @else                          
                                      {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_quantpart','',['style'=>'margin-right:35px']) }}                                    
                                    @endif
                                 @endif
                                 <h5><strong>Qualité</strong></h5>
                                   @for($r = 0; $r < count($indics_infos_exp[$i][$j][$k]);$r++ )
                                   <hr>
                                      @if( $indics_infos_exp[$i][$j][$k][$r]->domaine == 'participation')
                                          @if(  $indics_infos_exp[$i][$j][$k][$r]->declinaison == 'qualite')
                                            @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'intervenant')
                                              <h5>(destinataires : intervenant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }}  </h5>
                                              
                                             @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                  <h5 > ( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}}  </h5>
                                                  <h5 style="margin-left:10px"> Résultat obtenus :</h5>
                                                  @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                     {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}} |
                                                  @endfor
                                                  <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                  @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif
                                                  <br>
                                                  <br>
                                              @endfor
                                            @endif
                                            @if(  $indics_infos_exp[$i][$j][$k][$r]->destinataire == 'participant')
                                               <h5>(destinataires : participant); question : {{ $indics_infos_exp[$i][$j][$k][$r]->question }}  </h5>
                                               @for($q = 0; $q < count($rep_indics_infos_exp[$i][$j][$k][$r]) ;$q++ )
                                                  <h5 >( Réponse : type :  {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} ) {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->contenu}} </h5>
                                                   <h5 style="margin-left:10px">    Résultat obtenus :</h5>
                                                      @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                         {{$rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu}} |
                                                      @endfor
                                                      <h5 style="margin-left:10px"><em> stats :</em></h5>
                                                      @if($rep_indics_infos_exp[$i][$j][$k][$r][$q]->type == 'qcm')
                                                        <div class="hidden"> {{$cpt=0}} </div>
                                                        @for($qq = 0; $qq < count($rep_indics_exp[$i][$j][$k][$r][$q] ) ;$qq++ )
                                                            @if($rep_indics_exp[$i][$j][$k][$r][$q][$qq]->contenu=='yes')
                                                                <div class="hidden"> {{$cpt++;}} </div>
                                                            @endif
                                                        @endfor
                                                       {{$rep_indics_infos_exp[$i][$j][$k][$r][$q]->type}} coché à {{ ($cpt*100)/count($rep_indics_exp[$i][$j][$k][$r][$q] )   }} %.
                                                      @endif
                                                      <br>
                                                      <br>
                                                @endfor
                                            @endif
                                        @endif
                                      @endif
                                    @endfor
                      
                                 @if($expertises[$i]->qual_part == 'yes')
                                    <h5>Définir une note pour la qualité de participation : </h5>
                                    @if(count($results_exp[$i][$j][$k]['ql_p']) > 0 )
                                      {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualpart',$results_exp[$i][$j][$k]['ql_p'],['style'=>'margin-right:35px']) }}
                                    @else
                                      {{ Form::text('exp_'.$i.'_per_'.$j.'_act_'.$k.'_qualpart','',['style'=>'margin-right:35px']) }}
                                   @endif
                                 @endif
                                <hr>
                            @endif
                          @endfor
                        @endfor
                        {{Form::submit('Sauver/mettre à jour',['class'=>'btn btn-success','style'=>'margin-top:25px','name'=>'sauver_exp_'.$i])}}
                </div>
              </div>
            </div>

            @endfor
          @endif



        @endforeach
         <div class="row">
            <div class="panel panel-success" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>Derniers commentaires </strong></div>
                <div class="panel-body">
                  <div class="col-md-12">
                    @for($i=0; $i< min(15,count($comments)); $i++)
                      <strong>De : </strong>{{$comments[$i]->login}}  <strong>Le : </strong>{{$comments[$i]->created_at}}<br>
                      {{$comments[$i]->contenu}}
                      <hr>
                    @endfor
                 </div>
              </div>
           </div>
           @if(count($status)>0)
            {{Form::textarea('comment', '' ,['class'=>'form-control'])}}
            {{Form::submit('Ajouter un commentaire',['class'=>'btn btn-success','style'=>'margin-top:25px','name'=>'ajout_com'])}}
           @endif
        </div>
        
    </div>
</div>
{{ HTML::script('js/visu.js'); }}
{{Form::close()}}
<script>
 init_visu();
</script>
@stop