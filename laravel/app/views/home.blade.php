@extends('layout.basic_layout')
@section('body')
<div class="row">    
  <div class="jumbotron">
            <div class="container">
                 <div class="row">
                    
                    <div class="col-md-1 col-xs-1"></div>

                    <div class="col-md-10 col-xs-10 col-sm-12">
                        <h2>Evaluation des programmes de promotion de la santé</h2>
                    </div>
                    <div class="col-md-1"></div>
                  </div>
                  <div class="row" style="margin-top:50px">
                     @unless (Auth::check())
                        
                    @else
                         @if( count( DB::table('administrateurs')->where('compte_id','=',Auth::user()->id)->get() ) > 0 )
                            
                            @if( count(DB::table('administrateurs')->where('compte_id','=',Auth::user()->id)->where('id','=',1)->get())>0)
                             <div class="col-md-1 col-xs-1"></div>

                            <div class="col-md-10 col-xs-10 col-sm-12">
                                <h3> Vous êtes l'unique super-administrateur !</h3>
                             </div>
                            <div class="col-md-1"></div>

                            @else

                            <div class="col-md-1 col-xs-1"></div>

                            <div class="col-md-10 col-xs-10 col-sm-12">
                                <h3> Vous êtes administrateur !</h3>
                             </div>
                            <div class="col-md-1"></div>
                            @endif
                         @endif

                     @endunless
                 </div>

                 <div class="row">
                    @unless(Auth::check())
                        
                    @else
                        @if( count($data) > 0 )
                            <div class="col-md-1 col-xs-1"></div>

                            <div class="col-md-10 col-xs-10 col-sm-12">
                                <h3>Welcome, {{$data[0]->prenom}} {{$data[0]->nom}} </h3>
                            </div>
                            <div class="col-md-1"></div>
                        @endif
                    @endunless
                  </div>

                   <div class="row" style="margin-top:50px">
                    @unless (Auth::check())
                        
                    @else
                        <div class="col-md-1 col-xs-1"></div>
                        <div class="col-md-10 col-xs-10 col-sm-12">
                            <div class="btn btn-info btn-lg" style="margin-left:15px" onclick="document.location.href='/notifications'">Notifications récentes</div>
                            <div class="btn btn-info btn-lg" style="margin-left:35px" onclick="document.location.href='/my-projects'">Mes projets</div>
                            <div class="btn btn-info btn-lg" style="margin-left:35px" onclick="document.location.href='/recherche'">Recherche</div>
                        </div>
                    @endunless
                  </div>



           </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-1 col-xs-1"></div>

        <div class="col-md-10 col-xs-10 col-sm-12">
        @if(Session::has('success'))
                  <div class="alert alert-success">
                      {{Session::get('success')}}
                  </div>
         @endif
         <h4 style="text-align:justify;text-justify:inter-word;">De nombreux programmes de promotion de la santé sont menés par plusieurs infrastructures pour répondre à différents besoins. Une importante variabilité est susceptible de survenir dans la mise en œuvre des interventions de ces programmes et celle-ci n’est généralement pas prise en compte pour la phase d’analyse. Actuellement, de nombreux guides d’auto-évaluation papier et de nombreuses recommandations existent pour aider à mener ces évaluations, mais peu sous la forme d’outils informatiques. Ainsi, la demande des équipes pour une aide pratique à la structuration des projets et l’évaluation est de plus en plus forte. Le challenge principal de cet outil informatique serait donc d’avoir une adapatabilité à tous types de programmes et de permettre aux analystes de prendre en compte les différentes doses d’interventions dans les différents lieux pour chaque projet afin d’obtenir des résultats plus fiables.</h4>
          <button class="btn btn-primary col-sm-2 col-xs-12 pull-right top-marge-button">En savoir plus </button>
        </div>
        <div class="col-md-1"></div>
      </div>  
       
  </div>

@stop