@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('notation.action',$id)))}}

<h2>Notation<span class="glyphicon glyphicon-briefcase pull-right"></span></h2>

@if($success)
     <div class="alert alert-success">
        {{$success}}
      </div>
@endif

@for($i=0;$i < count($expertises); $i++)
<div class="panel panel-info" style="margin-top:20px;margin-left:40px">
                        <div class="panel-heading" style="font-size:20px"><strong>Expertise {{$i+1}}</strong> </div>
                          <div class="panel-body">
    @if( $expertises[$i]->niveau_exp == 'tout_le_projet' )
         <h4>Le niveau d'expertise : tout le projet</h4>
      @endif
    @if( $expertises[$i]->niveau_exp == 'categorie' )
        <h4>Le niveau d'expertise : pour une catégorie d'activités.</h4>
    @endif
     @if( $expertises[$i]->niveau_exp == 'activite' )
        <h4>Le niveau d'expertise : pour une ou plusieurs activités.</h4>
    @endif
    @if( $expertises[$i]->periode_exp == 'tout_projet' )
        <h4>La période d'expertise : </h4>
         <h5 style="margin-left:15px"> tout le projet </h5>
    @endif
     @if( $expertises[$i]->periode_exp == 'periodes' )
        <h4>Périodes :</h4>
        @foreach($periodes_associees[$i] as $p)
          <h5 style="margin-left:15px">{{$p->nom}}, du {{ (new DateTime($p->date_debut))->format('d/m/Y') }} au {{ (new DateTime($p->date_fin))->format('d/m/Y') }}.</h5>
        @endforeach
    @endif
    <h4>Notation :</h4>
   @if( $expertises[$i]->quant_part == 'yes' )
        <h5 style="margin-left:15px">la quantité de participation est notée.</h5>
    @endif
    @if( $expertises[$i]->qual_part == 'yes' )
        <h5 style="margin-left:15px">la qualité de participation est notée.</h5>
    @endif
    @if( $expertises[$i]->quant_real == 'yes' )
        <h5 style="margin-left:15px">la quantité de réalisation est notée.</h5>
    @endif
    @if( $expertises[$i]->qual_real == 'yes' )
        <h5 style="margin-left:15px">la qualité de réalisation est notée.</h5>
    @endif
    <h4>Experts sollicités :</h4>
    @foreach($experts_associes[$i] as $exp)
      <h5 style="margin-left:15px">{{$exp->nom}} {{$exp->prenom}}; structure : {{$exp->structure}};fonction : {{$exp->fonction}}; ville {{$exp->ville}} : </h5>
    @endforeach
    <hr>
    <h4>Résultats :</h4>
    <hr>
    <h4>Quantité de réalisation</h4>
      <h5>Notes :</h5>
        @for($j=0;$j < count($notes_par_exp[$i]['qt_r']);$j++ )
          {{ $notes_par_exp[$i]['qt_r'][$j] }} ##
        @endfor
        
      <h5>Moyenne des notes :</h5>
        
      @if($moyennes[$i]['qt_r']>0)
        {{$moyennes[$i]['qt_r']}}
      @else
        Pas de données chiffrées !
      @endif


    <hr>
    <h4>Qualité de réalisation</h4>
      <h5>Notes :</h5>
      @for($j=0;$j < count($notes_par_exp[$i]['ql_r']);$j++ )
            {{ $notes_par_exp[$i]['ql_r'][$j] }} ##
        @endfor
      <h5>Moyenne des notes :</h5>
     
      @if($moyennes[$i]['ql_r']>0)
        {{$moyennes[$i]['ql_r'] }}
      @else
        Pas de données chiffrées !
      @endif
      <hr>
    <h4>Quantité de participation</h4>
      <h5>Notes :</h5>
      @for($j=0;$j < count($notes_par_exp[$i]['qt_p']);$j++ )
           {{ $notes_par_exp[$i]['qt_p'][$j] }} ##
        @endfor
      <h5>Moyenne des notes :</h5>
   
      @if($moyennes[$i]['qt_p']>0)
        {{$moyennes[$i]['qt_p']}}
      @else
        Pas de données chiffrées !
      @endif

      <hr>
    <h4>Qualité de participation</h4>
      <h5>Notes :</h5>
      @for($j=0;$j < count($notes_par_exp[$i]['ql_p']);$j++ )
            {{ $notes_par_exp[$i]['ql_p'][$j] }} ##
        @endfor
      <h5>Moyenne des notes :</h5>
      
      @if($moyennes[$i]['ql_p']>0)
        {{ $moyennes[$i]['ql_p'] }}
      @else
        Pas de données chiffrées !
      @endif

      <hr>
  </div>
</div>
@endfor



{{Form::close()}}

@stop