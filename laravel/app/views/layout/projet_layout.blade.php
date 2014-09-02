@extends('layout.basic_layout')
@section('body')

    
     
      <div class="row">
        
         <div class="col-sm-3 col-md-3 sidebar"  >
          <div class="jumbotron" id="colonnegauche"> 
          <ul class="nav nav-pills nav-stacked" style="margin-top:190px">
            <h4>Administration du projet</h4>
            <hr>

            <li class="{{ Request::is( '*/*/edit') ? 'active' : '' }} ">
              <a href="{{ URL::to( 'my-projects/'.$id.'/edit') }}">
                Modifier les informations
                  <span class="glyphicon glyphicon-list-alt pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/categorie_activite') ? 'active' : '' }} ">
              <a href="{{ URL::to( 'my-projects/'.$id.'/categorie_activite') }}">
                Gestion des catégorie d'activités
                <span class="glyphicon glyphicon-th pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/activites') ? 'active' : '' }} ">
              <a href="{{ URL::to( 'my-projects/'.$id.'/activites') }}">
                Gestion des activités<span class="glyphicon glyphicon-th-list pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/members') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/members') }}">
                Gestion des membres 
                <span class="glyphicon glyphicon-user pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/lieux') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/lieux')}}">
                Gestion des lieux
                <span class="glyphicon glyphicon-road pull-right"></span>
              </a>
              </li>
            <li class="{{ Request::is( '*/*/indicateurs') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/indicateurs') }}">
                Gestion des indicateurs
                <span class="glyphicon glyphicon-asterisk pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/outils') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/outils') }}">
                Gestion des outils<span class="glyphicon glyphicon-wrench pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/associations') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/associations') }}">
                Programmation des évènements <span class="glyphicon glyphicon-time pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/gestion_expertise') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/gestion_expertise') }}">
                Gestion de l'expertise <span class="glyphicon glyphicon-briefcase pull-right"></span>
              </a>
            </li>
            <h4 style="margin-top:30px;">Déroulement du projet</h4>
            <hr>
            <li class="{{ Request::is( '*/*/calendrier') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/calendrier') }}">
                Calendrier
                <span class="glyphicon glyphicon-calendar pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/[0-9]+') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id) }}">
                Visualisation
                <span class="glyphicon glyphicon-picture pull-right"></span>
              </a>
            </li>
            <li class="{{ Request::is( '*/*/depot_compte_rendu') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/depot_compte_rendu') }}">
                Compte-rendu
              </a>
            </li>
            <h4 style="margin-top:30px;">Synthèse du projet</h4>
            <hr>
            <li class="{{ Request::is( '*/*/notation') ? 'active' : '' }}">
              <a href="{{ URL::to( 'my-projects/'.$id.'/notation') }}">
                Notation
              </a>
            </li>
          </ul>
        </div>
      </div>


        <div class="col-sm-8 col-md-8" style="margin-left:10px" id="colonnedroite">
           <p style="font-size:50px;margin-top:20px;">Projet</p>
           <hr>
          @yield('projet-content')
        </div>

      </div>
 


@stop