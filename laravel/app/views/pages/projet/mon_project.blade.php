@extends('layout.projet_layout')
@section('projet-content')

 @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
     @endif

<div class="row">
      <div class="col-md-8">
            <h2 style="text-align:justify;text-justify:inter-word;margin-right:20px">{{$projet->titre}} </h2>
      </div>

      <div class="col-md-4">
          <div class="alert alert-warning pull-right">
              Vous avez le status de : Créateur        
            </div>
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
                        <div class="panel-heading" style="font-size:20px"><strong>Catégorie d'activités disponibles</strong></div>
                          <div class="panel-body">
                            <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"><span class="glyphicon glyphicon-chevron-right pull-left"></span> Catégorie_1</h4>
                            <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;margin-top:20px"><span class="glyphicon glyphicon-chevron-right pull-left"></span> Catégorie_2</h4>
                            <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;margin-top:20px"><span class="glyphicon glyphicon-chevron-right pull-left"></span> Catégorie_3</h4>
                          </div>
                        </div>
                      </div>
                   </div>
                 </div>
               </div>
    </div>
    
{{Form::open(array('url'=> URL::route('mon_projo.post_comment',$id)))}}
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
           
            {{Form::textarea('comment', '' ,['class'=>'form-control'])}}
            {{Form::submit('Ajouter un commentaire',['class'=>'btn btn-success','style'=>'margin-top:25px','name'=>'ajout_com'])}}
          
  </div>
{{Form::close()}}
@stop
