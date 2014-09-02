@extends('layout.projet_layout')
@section('projet-content')
            <br>
            <h1>Editer le projet <span class="glyphicon glyphicon-list-alt pull-right"></span></h1>
            <br>
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
            {{Form::open(array('action'=> array('EditProjetController@edit',$id)))}}
            <div class="form-group">
                {{Form::label('nomprojet','Titre',['class'=>'form-label'])}}
                {{Form::text('nomprojet',$results->titre,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('acronyme','Acronyme',['class'=>'form-label'])}}
                {{Form::text('acronyme',$results->acronyme,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('objectif','Objectif principal',['class'=>'form-label'])}}
                {{Form::textarea('objectif',$results->objectif,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('objectif_specifique','Objectif spécifique',['class'=>'form-label'])}}
                {{Form::textarea('objectif_specifique',$results->objectif_specifique,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('population_cible','Population cible',['class'=>'form-label'])}}
                {{Form::text('population_cible',$results->population_cible,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('date_debut','Date de début',['class'=>'form-label'])}}
                {{Form::text('date_debut',$results->date_debut,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('date_fin','Date de fin',['class'=>'form-label'])}}
                {{Form::text('date_fin',$results->date_fin,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('date_fin','Fichier descriptif',['class'=>'form-label'])}}
                {{Form::file('fichier')}}
            </div>
             <div class="form-group">
                {{Form::submit('Editer projet',['class'=>'btn btn-primary col-sm-2 col-xs-12 pull-right top-marge-button'])}}
            </div> 
            {{Form::close()}}
@stop