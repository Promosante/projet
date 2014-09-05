@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('association.action',$id)))}}

<h2>Programmation des évènements<span class="glyphicon glyphicon-time pull-right"></span></h2>
<hr>

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
<div class="row"> 
	<h3>1)</h3>	
	<hr>
  <div class="col-md-4">
  	<h4>Choisir une activité :</h4>
    {{Form::select('activite_ajout',$act,count($act)-1,['style'=>'max-width:100%;margin-top:15px;','id'=>'act_sel'])}}
  </div>
</div>

<div class="row">
  
  	<hr>
  	<div class="col-md-4">
		  	<h4 >Choisir une période :</h4>

		    @for($i=0;$i < count($act)-1 ;$i++)
		    	{{Form::select('periode_ajout_'.$i,$periodes[ $act[$i] ],0,['style'=>'max-width:100%;margin-top:15px;','id'=>str_replace(' ','_',$act[$i]).'P','class'=>'periodes_propose' ])}}
		    	
		  	@endfor
  	</div>
  	<div class="col-md-4">
		  	<h4 >Choisir un lieu :</h4>

		    @for($i=0;$i < count($act)-1 ;$i++)
		    	{{Form::select('lieu_ajout',$lieux[ $act[$i] ],0,['style'=>'max-width:100%;margin-top:15px;','id'=>str_replace(' ','_',$act[$i]).'L','class'=>'lieux_propose' ])}}
		  	@endfor
  	</div> 
  	<div class="col-md-4">
		  	<h4 >Choisir un (ou plusieurs) intervenant(s) :</h4>
		  	@for($i=0;$i < count($act)-1 ;$i++)
		    	{{Form::select('interv_ajout',$intervenants[ $act[$i] ],0,['style'=>'max-width:100%;margin-top:15px;','id'=>str_replace(' ','_',$act[$i]).'I','class'=>'interv_propose' ])}}
		  	@endfor
		   
  	</div>
</div>
<div class="row">
  	<hr>
    <div class="alert alert-info">
      Les participants du groupe/sous-groupe non associés à l'activité seront rajoutés automatiquement.
    </div>
  	<div class="col-md-4">
		  	<h4 >Choisir un groupe :</h4>
		    {{Form::select('groupes', $groupes,0,['style'=>'max-width:100%','id'=>'groupe_affect','class'=>'groupe_propose'])}}
  	</div>
  	<div class="col-md-4">
		  	<h4 >Choisir un sous-groupe :</h4>
		  	 <div class="hidden">{{$i=0;}}</div>
		       @foreach($groupes as $g)
                    {{Form::select('ss_groupe_affecte_'.$i, $ss_groupe[$i], 0,['style'=>'max-width:100%','class'=>'sous_groupe_propose','id'=>'groupe_'.$i,'name'=>'ss_groupe_affecte_'.$i ] ) }}
                  <div class="hidden">{{$i++;}}</div>
            @endforeach
  	</div>
</div>
<div class="row">

  	<h3 style="margin-top:25px;">2)</h3>
  	<hr>
  	<div class="alert alert-info">
  		Les dates doivent être incluses dans celles de la période.
  	</div>
  	<div class="col-md-6">
         <h4 >Nom</h4>
        {{Form::text('nom_de_evene','',['class'=>'form-control'])}}
		  	<h4 >Informations pratiques :</h4>

		    {{Form::textarea('infos_pratiques','',['class'=>'form-control'])}}
		  	 
  	</div>
  	<div class="col-md-6">
		  	<h4 >Date de début : (JJ/MM/AAAA)</h4>
		    {{Form::text('date_debut','',['class'=>'form-control'])}}

        <h4 >Heure de début : (HH:MM)</h4>
        {{Form::text('heure_debut','',['class'=>'form-control'])}}

		    <h4 >Date de fin : (JJ/MM/AAAA)</h4>
		    {{Form::text('date_fin_eve','',['class'=>'form-control'])}}

        <h4 >Heure de fin : (HH:MM)</h4>
        {{Form::text('heure_fin','',['class'=>'form-control'])}}

		  	{{Form::submit('Ajouter',['class'=>'btn btn-success','style'=>'width:100%;margin-top:25px','name'=>'ajout_eve'])}}
  	</div>
  	
</div>

{{Form::close()}}

{{ HTML::script('js/gest_evenements.js'); }}

<script>
init_evenement();
</script>

@stop 