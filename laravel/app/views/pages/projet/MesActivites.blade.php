@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('activite.action',$id)))}}
<h2>Mes activités<span class="glyphicon glyphicon-th pull-right"></span></h2>

  <div class="row">
            <div class="panel panel-success" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>Activités</strong> </div>
                <div class="panel-body">
                  <div class="col-md-12">

                    <div class="hidden">{{$i=0;}}</div>
                    @foreach($activites as $act)
                    <div class="hidden">{{$i++}}</div>
                    <div class="row">

                            <div class="panel panel-info" style="margin-top:20px" name="panelpanel">
                              <div class="panel-heading" style="font-size:20px"><strong>{{$act->nom}}</strong> {{Form::submit('Editer',['class'=>'btn btn-success col-sm-2 pull-right','name'=>'editer_'.$i])}}  </div>
                                <div class="panel-body">
                                  
                                  <h4><strong> Objectif : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> 
                                      {{$act->objectif}}
                                  </h4>
                                  <h4><strong> Date de début : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;">{{$act->date_debut}}</h4>
                                  <h4><strong> Date de fin : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;">{{$act->date_fin}}</h4>
                                  <h4><strong> Indicateur : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;">Indicateur</h4>
                                  <h4><strong> Outil : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;">1</h4>
                                </div>
                              </div>
                    </div>
                    @endforeach
                   
                     @for($p=1; $p < count($activites)/2+1;$p=$p+1)
                              <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_','panelpanel',{{$p}},{{ceil(count($activites)/2)+1}},{{count($activites)}},2);" id="page_{{$p}}">{{$p}}</p>
                      @endfor

                </div>
            </div>
        </div>
     </div>

<script>
    pagine_results('page_','panelpanel',1,{{ceil(count($activites))/2+1}},{{count($activites)}},2);
</script>
{{Form::close()}}
@stop