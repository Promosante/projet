@extends('layout.basic_layout')
@section('body')

   
      <div class="row">
         <div class="col-sm-3 col-md-3 sidebar">
          <div class="jumbotron">
          <ul class="nav nav-pills nav-stacked" style="margin-top:170px">
            <li class="{{ Request::is( 'messagerie-newmsg') ? 'active' : '' }}"><a href="{{ URL::to( 'messagerie-newmsg') }}">Nouveau message<span class="glyphicon glyphicon-envelope pull-right"></span></a></li>
            <li class="{{ Request::is( 'messagerie-br') ? 'active' : '' }}"><a href="{{ URL::to( 'messagerie-br') }}">Boite de réception<span class="glyphicon glyphicon-save pull-right"></span></a></li>
            <li class="{{ Request::is( 'messagerie-saved') ? 'active' : '' }}"><a href="{{ URL::to( 'messagerie-saved') }}">Messages Enregistrés<span class="glyphicon glyphicon-saved pull-right"></span></a></li>
            <li class="{{ Request::is( 'messagerie-be') ? 'active' : '' }}"><a href="{{ URL::to( 'messagerie-be') }}">Messages Envoyés<span class="glyphicon glyphicon-open pull-right"></span></a></li>
            <li class="{{ Request::is( 'messagerie-trash') ? 'active' : '' }}"><a href="{{ URL::to( 'messagerie-trash') }}">Corbeille<span class="glyphicon glyphicon-trash pull-right"></span></a></li>
            <li style="height:450px"></li>
          </ul>
        </div>
      </div>
        <div class="col-sm-8"style="margin-left:20px">
          <p style="font-size:50px;margin-top:20px;">Messagerie</p>
          <hr>
          @yield('messagerie-content')
        </div>
      </div>

@stop