@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('outils.action',$id)))}}
<div class="row">
          <div class="panel panel-success" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>Outils</strong> </div>
                <div class="panel-body">
                  <div class="col-md-12">
                            <div class="hidden">{{$i=0;}}</div>
                            @foreach($outils as $o)

                                <h4><strong>Nom :</strong> {{$o->nom}}</h4>
                                @if($infos[$i][0]=='questionnaire')
                                 {{Form::submit('télécharger pdf',['class'=>'btn btn-success pull-right','style'=>'margin-top:25px;margin-left:15px','name'=>'pdf_'.$i])}}
                                {{Form::submit('Supprimer',['class'=>'btn btn-danger pull-right','style'=>'margin-top:25px','name'=>'supprime_'.$i])}}
                                  <h4><strong>Type :</strong> questionnaire</h4>
                                  <h4><strong>Titre :</strong> {{$infos[$i][1][0]->titre}}</h4>
                                @endif
                                <hr>
                                <div class="hidden">{{$i++;}}</div>
                            @endforeach
                       </div>
                   </div>
       </div>
    </div>
                  
    
{{Form::close()}}
@stop