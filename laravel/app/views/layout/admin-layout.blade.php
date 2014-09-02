@extends('layout.basic_layout')
@section('body')
<div class="row">
	<div class="col-md-3 sidebar">
		<div class="jumbotron" style="height:100%">
              <ul class="nav nav-pills nav-stacked" style="margin-top:170px">
              	 <li class="{{ Request::is( 'admin') ? 'active' : '' }}"><a href="{{ URL::to( 'admin') }}">Accueil<span class="glyphicon glyphicon-home pull-right"></span></a></li>
                <li class="{{ Request::is( 'admin/membres') ? 'active' : '' }}"><a href="{{ URL::to( 'admin/membres') }}">Membres <span class="glyphicon glyphicon-tasks pull-right"></span></a></li>
                <li class="{{ Request::is( '') ? 'active' : '' }}"><a href="{{ URL::to( '') }}"><span class="glyphicon glyphicon-list-alt pull-right"></span></a></li>
                <li class="{{ Request::is( '') ? 'active' : '' }}"><a href="{{ URL::to( '') }}"><span class="glyphicon glyphicon-trash pull-right"></span></a></li>
                <li style="height:300px"></li>
              </ul>
		</div>
	</div>
	<div class="col-md-8" style="margin-top:50px">
			
				@yield('admin-content')
			
	</div>
</div>
@stop 