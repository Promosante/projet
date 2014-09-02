@extends('layout.mesprojet_layout')
@section('mesprojet-content')

            <h1>Créer un nouveau projet<span class="glyphicon glyphicon-tasks pull-right"></span></h1>
            
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    @foreach (Session::get('errors')->all() as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                    
                </div>
            @endif
            {{Form::open(array('url'=> URL::route('newproject.createnew')))}}
            <div class="form-group">
                {{Form::label('nomprojet','Titre',['class'=>'form-label'])}}
                {{Form::text('nomprojet','Titre projet',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('acronyme','Acronyme',['class'=>'form-label'])}}
                {{Form::text('acronyme','acronyme',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('objectif','Objectif principal',['class'=>'form-label'])}}
                {{Form::textarea('objectif','objectif principal',['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('objectif_specifique','Objectif spécifique',['class'=>'form-label'])}}
                {{Form::textarea('objectif_specifique','objectif spécifique',['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('population_cible','Population cible',['class'=>'form-label'])}}
                {{Form::text('population_cible','population',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('date_debut','Date de début',['class'=>'form-label'])}}
                {{Form::text('date_debut','01/01/2000',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('date_fin','Date de fin',['class'=>'form-label'])}}
                {{Form::text('date_fin','01/01/2000',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('date_fin','Fichier descriptif',['class'=>'form-label'])}}
                {{Form::file('fichier')}}
            </div>
             <div class="form-group">
                {{Form::submit('Créer projet !',['class'=>'btn btn-primary col-sm-2 col-xs-12 pull-right top-marge-button'])}}
            </div> 
            {{Form::close()}}
@stop