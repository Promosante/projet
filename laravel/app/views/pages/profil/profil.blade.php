@extends('layout.basic_layout')
@section('body')
{{Form::open(array('url'=> URL::route('profil.edit')))}}
    <div class="container">
      <p style="font-size:55px;margin-top:10px;">Mon profil</p>
      <div class="row">

        <div class="col-sm-4 ">
          Date creation :<br> {{ $results[0]->created_at}}<br><br>
          Derniere mise a jour : <br>{{ $results[0]->updated_at}}<br>
        </div>

        <div class="col-sm-6">
          <h2>{{ $results[0]->login }} :</h2>
          <br>
          <div class="panel panel-info">
            <div class="panel-heading" style="font-size:22px"><strong>{{ $results[0]->prenom }} {{ $results[0]->nom }}</strong></div>
            <div class="panel-body">
              <div class="container">
                  <h4> <strong>Email :</strong> {{ $results[0]->email }}</h4>
                  <h4> <strong>Fonction :</strong> {{ $results[0]->fonction }}</h4>
                  <h4> <strong>Structure :</strong> {{ $results[0]->structure }}</h4>
                  <h4> <strong>Date de naissance :</strong> {{ $results[0]->datenaissance }}</h4>
                  <h4> <strong>Adresse :</strong> {{ $results[0]->adresse }}</h4>
                  <h4> <strong>Code postal :</strong> {{ $results[0]->codepostal }}</h4>
                  <h4> <strong>Ville :</strong> {{ $results[0]->ville }}</h4>
                  <h4> <strong>Pays :</strong> {{ $results[0]->pays }}</h4>
              </div>
            </div>
          </div>
        </div>

      </div>

        <div class="row">
          <div class="col-sm-6">
            {{Form::submit('Editer mon profil',['class'=>'btn btn-primary pull-right','name'=>'edit'])}}
          </div>
        </div>
  </div>
{{Form::close()}}

@stop