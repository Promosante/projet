@extends('layout.projet_layout')
@section('projet-content')

  {{Form::open(array('url'=> URL::route('outils.action',$id)))}}
    <h2>Gestion des outils<span class="glyphicon glyphicon-wrench pull-right"></span></h2>

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
     
    <div class="row">
         {{Form::submit('Consulter mes outils',['class'=>'btn btn-primary btn-lg col-md-6 col-sm-6 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'consulter'])}}
    </div>
    <div class="row">
          <div class="col-md-4">
            <h4 style="margin-top:35px">Ajouter un outils</h4>
             {{Form::label('nom_ajout',"Nom de l'outils",['class'=>'form-label'])}}
            {{Form::text('nom_ajout', 'Nom' ,['class'=>'form-control'])}}
           </div> 
     </div>

     <div class="row" style="margin-top:15px"> 
        <div class="col-md-6">
            {{Form::label('type',"Type",['class'=>'form-label'])}}
            <h5>Questionnaire {{ Form::checkbox('questionnaire', 'yes',false) }} </h5>
            
        </div>
        <div class="col-md-4">
            {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'ajout_outils'])}}
        </div>
    </div>
    <div class="row" style="margin-top:10px;">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Supprimer un outils</h4>
              <hr>
           </div> 
     </div>

     <div class="row"> 
        <div class="col-md-5">
            {{Form::label('nom_supp','Nom de la catégorie (exact)',['class'=>'form-label'])}}
            {{Form::text('nom_supp', 'Nom' ,['class'=>'form-control'])}}
        </div>
        
        <div class="col-md-2">
            {{Form::submit('Supprimer',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'supp_lieu'])}}
        </div>
    </div>

{{Form::close()}}
@stop