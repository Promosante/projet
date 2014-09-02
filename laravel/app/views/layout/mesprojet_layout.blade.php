@extends('layout.basic_layout')
@section('body')

    
     
      <div class="row">
         <div class="col-sm-3 col-md-3 sidebar">
           <div class="jumbotron" style="height:100%">
              <ul class="nav nav-pills nav-stacked" style="margin-top:170px">
                <li class="{{ Request::is( 'newproject') ? 'active' : '' }}"><a href="{{ URL::to( 'newproject') }}">Nouveau projet<span class="glyphicon glyphicon-tasks pull-right"></span></a></li>
                <li class="{{ Request::is( 'my-projects') ? 'active' : '' }}"><a href="{{ URL::to( 'my-projects') }}">Mes projets<span class="glyphicon glyphicon-list-alt pull-right"></span></a></li>
                <li class="{{ Request::is( 'projects-trash') ? 'active' : '' }}"><a href="{{ URL::to( 'projects-trash') }}">Corbeille<span class="glyphicon glyphicon-trash pull-right"></span></a></li>
                <li style="height:300px"></li>
              </ul>
          </div>
        </div>
        <div class="col-md-8"style="margin-left:20px">
           <p style="font-size:50px;margin-top:20px;">Mes projets</p>
           <hr>
          @yield('mesprojet-content')
      </div>
    </div>

@stop