@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('indicateurs.action',$id)))}}
<div class="row">
          <div class="panel panel-success" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>Indicateurs</strong> </div>
                <div class="panel-body">
                  <div class="col-md-12">
                      <div class="row">
                              <div class="panel panel-info" style="margin-top:20px">
                                <div class="panel-heading" style="font-size:20px"></div>
                                  <div class="panel-body">
                                    <div class="hidden">{{$i=0;}}</div>
                                    @foreach($indics as $ind)
                                           {{Form::submit('Supprimer',['class'=>'btn btn-danger pull-right','style'=>'margin-top:25px','name'=>'supprime_$i'])}}
                                          <h4 style="text-align:justify;text-justify:inter-word;"><strong> {{$ind->nom}} </strong> : </h4>
                                          <h4 style="text-align:justify;text-justify:inter-word;margin-left:20px"> Domaine : {{$ind->domaine}}  </h4>
                                          <h4 style="text-align:justify;text-justify:inter-word;margin-left:20px"> Declinaison : {{$ind->declinaison}}  </h4>
                                          <h4 style="text-align:justify;text-justify:inter-word;margin-left:20px"> Question : {{$ind->question}} </h4>
                                          <div class="hidden">{{$j=0;}}</div>

                                          @foreach($reponses[$i] as $r)
                                                <div class="hidden">{{$j++;}}</div>
                                               <h4> (reponse {{$j}} type:{{$r->type}}) {{$r->contenu}}</h4>
                                          @endforeach
                                          <div class="hidden">{{$j=0;}}</div>
                                        <hr>
                                    <div class="hidden">{{$i++;}}</div>
                                    @endforeach
                                  </div>
                                </div>
                      </div>

                    </div>
                  </div>
                </div>
            </div>
    
{{Form::close()}}
@stop