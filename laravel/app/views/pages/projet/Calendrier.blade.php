@extends('layout.projet_layout')
@section('projet-content')

  {{Form::open(array('url'=> URL::route('calendrier.action',$id)))}}
    <h2>Déroulement du projet<span class="glyphicon glyphicon-calendar pull-right"></span></h2>

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
     <div class="row" style="margin-top:35px">
            <h3>Nous sommes le {{$jour_actuel}} {{$jour_nb_actuel}} {{$mois_actuel}}, jour n° {{$jour_nb_annee_actuel}}/365, semaine {{$semaine_actuel}}.</h3>
     </div>
  <div class="row">
      <div class="col-md-4">
                {{Form::submit('Année précédente',['class'=> 'btn btn-success' ,'name'=>'annee_moins','style'=>'margin-top:20px;width:100%;'])}}
      </div>
      <div class="col-md-4">

      </div>
      <div class="col-md-4">
                {{Form::submit('Année suivante',['class'=> 'btn btn-success' ,'name'=>'annee_plus','style'=>'margin-top:20px;width:100%;'])}}
      </div>
  </div>
<input class="" type="hidden" value="{{$annee_sel}}" name="annee_sel"></input>
 <div class="row">
    <div class="row" style="margin-top:15px">
            <div class="col-md-2">
                {{Form::submit('Janvier',['class'=> ($mois_sel=='Janvier' ) ? 'btn btn-danger' : 'btn btn-primary' ,'name'=>'janvier','style'=>'margin-top:20px;width:100%;'])}}
            </div>
            <div class="col-md-2">
                {{Form::submit('Fevrier',['class'=>($mois_sel=='Fevrier' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'fevrier','style'=>'margin-top:20px;width:100%;'])}}
            </div>
            <div class="col-md-2">
                {{Form::submit('Mars',['class'=>($mois_sel=='Mars' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'mars','style'=>'margin-top:20px;width:100%;'])}}
            </div>
            <div class="col-md-2">
                {{Form::submit('Avril',['class'=>($mois_sel=='Avril' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'avril','style'=>'margin-top:20px;width:100%;'])}}
            </div>
            <div class="col-md-2">
              {{Form::submit('Mai',['class'=>($mois_sel=='Mai' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'mai','style'=>'margin-top:20px;width:100%;'])}}
            </div>
            <div class="col-md-2">
               {{Form::submit('Juin',['class'=>($mois_sel=='Juin' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'juin','style'=>'margin-top:20px;width:100%;'])}}
            </div>
    </div>
    <div class="row">
        <div class="col-md-2">
               {{Form::submit('Juillet',['class'=>($mois_sel=='Juillet' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'juillet','style'=>'margin-top:20px;width:100%;'])}}
            </div>
            <div class="col-md-2">
            {{Form::submit('Aout',['class'=>($mois_sel=='Aout' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'aout','style'=>'margin-top:20px;width:100%;'])}}
           </div>
            <div class="col-md-2">
             {{Form::submit('Septembre',['class'=>($mois_sel=='Septembre' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'septembre','style'=>'margin-top:20px;width:100%;'])}}
           </div>
            <div class="col-md-2">
              {{Form::submit('Octobre',['class'=>($mois_sel=='Octobre' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'octobre','style'=>'margin-top:20px;width:100%;'])}}
          </div>
            <div class="col-md-2">
              {{Form::submit('Novembre',['class'=>($mois_sel=='Novembre' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'novembre','style'=>'margin-top:20px;width:100%;'])}}
          </div>
            <div class="col-md-2">
            {{Form::submit('Décembre',['class'=>($mois_sel=='Decembre' ) ? 'btn btn-danger' : 'btn btn-primary','name'=>'decembre','style'=>'margin-top:20px;width:100%;'])}}
        </div>
    </div>
    <h3 style="margin-top:35px;text-align:center;">
      Période du 01 au {{(new DateTime(GestionDate::get_Nb_Mois($mois_sel).'/20/'.$annee_sel))->format('t'); }} {{$mois_sel}} {{$annee_sel}}. 
     
    </h3>
    <div class="row" style="margin-top:30px">
        <div class="hidden">
            {{$i=0;$j=0;}}
        </div>

        
        @foreach($activites as $act)

            <div class="row" style="height:50px" >
                <div class="col-md-2">
                    <h4>Activité {{$i+1}}</h4>
                </div>
               
                <div class="col-md-10">

                   <div class="progress barres_dessous" style="margin-top:10px">

                       
                        <div class="progress-bar progress-bar-success barres1 " name="barre" role="progressbar"
                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" id="bar_{{$i}}"
                            style="width:{{$segments[$i][1]}}%;background-image:none;margin-left:{{$segments[$i][0]}}%;"
                            onclick="javascript:show_details('d_{{$i+1}}','bar_{{$i}}');">

                        </div>
                        

                    </div>
                </div>
            </div>

            <div class="hidden">
                {{$i++;}}
            </div>
        @endforeach

    </div>

 </div>
<div class="row">
  <?php $i=0; ?>
  <?php $j=0; ?>
        @foreach($activites as $r)
          <?php $i=$i+1; ?>
            <div class="row details" id="d_{{$i}}">
              <div class="panel panel-success" style="margin-top:10px">
                <div class="panel-heading" style="font-size:20px"><strong>Détails</strong> <div class="btn btn-danger pull-right" onclick="javascript:hide_details();"><span class="glyphicon glyphicon-remove"></span></div></div>
                  <div class="panel-body">
                    <h3>Activité</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                             <h4> <strong> Nom : </strong></h4>
                             <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$r->nom}}</h4>
                        </div>
                         <div class="col-md-3">
                             <h4> <strong> Date de début : </strong></h4>
                             <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$r->date_debut}}</h4>
                        </div>
                         <div class="col-md-3">
                             <h4> <strong> Date de fin : </strong></h4>
                             <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$r->date_fin}}</h4>
                        </div>
                        <div class="col-md-3">
                             <h4> <strong> Nombre de périodes: </strong></h4>
                             <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{count($periodes_associees[$i-1])}}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                                @foreach($periodes_associees[$i-1] as $p)
                                  <?php $j=$j+1; ?>
                                  <h4>période {{$j}}</h4>
                                  <div class="progress barres_dessous" style="margin-top:10px">
                                       <div class="progress-bar progress-bar-success barres1 " name="barre" role="progressbar"
                                          aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" id="bar_{{$i}}_{{$j}}"
                                          style="width:{{$segments2[$i-1][$j-1][1]}}%;background-image:none;margin-left:{{$segments2[$i-1][$j-1][0]}}%;"
                                          onclick="javascript:show_periode_details('d_{{$i}}_{{$j}}','bar_{{$i}}_{{$j}}','bar_{{$i-1}}');">
                                      </div>
                                       
                                  </div>
                                @endforeach
                              <div class="hidden"> {{$j=0;}}</div>
                            
                        </div>
                    </div>

                  </div>
              </div>
            </div>
    @endforeach
</div>
<div class="row">
  <?php $i=0; ?>
   <?php $j=0; ?>
        @foreach($activites as $r)
          <?php $i=$i+1; ?>
           @foreach($periodes_associees[$i-1] as $p)
            <?php $j=$j+1; ?>
            <div class="row details_periodes" id="d_{{$i}}_{{$j}}">
              <div class="panel panel-success" style="margin-top:10px">
                <div class="panel-heading" style="font-size:20px"><strong>Détails</strong> <div class="btn btn-danger pull-right" onclick="javascript:hide_periode_details('bar_{{$i-1}}');"><span class="glyphicon glyphicon-remove"></span></div></div>
                  <div class="panel-body">
                    <h3>Periode</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                             <h4> <strong> Nom : </strong></h4>
                             <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$p->nom}}</h4>
                        </div>
                         <div class="col-md-3">
                             <h4> <strong> Date de début : </strong></h4>
                             <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$p->date_debut}}</h4>
                        </div>
                         <div class="col-md-3">
                             <h4> <strong> Date de fin : </strong></h4>
                             <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$p->date_fin}}</h4>
                        </div>
                    </div>
                        <hr>
                        <hr>
                        @foreach($segments3[$i-1][$j-1] as $e)
                        <?php $k=$k+1; ?>

                        Evenement {{$k}}, du {{$evenements_associes[$i-1][$j-1][$k-1]->date_debut}} au {{$evenements_associes[$i-1][$j-1][$k-1]->date_fin}}, au {{$evenements_associes[$i-1][$j-1][$k-1]->nom}}, {{$evenements_associes[$i-1][$j-1][$k-1]->adresse}}
                        <div class="progress barres_dessous" style="margin-top:10px">
                            <div class="progress-bar progress-bar-success barres3 " name="barre" role="progressbar"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" id=""
                                style="width:{{$segments3[$i-1][$j-1][$k-1][0]}}%;background-image:none;" >
                            </div>
                            <div class="progress-bar progress-bar-danger barres3 " name="barre" role="progressbar"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" id=""
                                style="width:{{$segments3[$i-1][$j-1][$k-1][1]}}%;background-image:none;" >
                            </div>
                            <div class="progress-bar progress-bar-success barres3 " name="barre" role="progressbar"
                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" id=""
                                style="width:{{$segments3[$i-1][$j-1][$k-1][2]}}%;background-image:none;" >
                            </div>
                        </div>

                        @endforeach
                        <?php $k=0; ?>
                    
                  </div>
              </div>
            </div>
            @endforeach
           <div class="hidden"> {{$j=0;}}</div>
    @endforeach
  <div class="hidden">  {{$i=0;}}</div>
</div>

{{ HTML::script('js/calendrier.js'); }}
<script>
$(".details_periodes").hide();
$(".details").hide();
</script>
{{Form::close()}}
@stop