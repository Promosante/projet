@extends('layout.messagerie')
@section('messagerie-content')
    
  <h2>Message<span class="glyphicon glyphicon-envelope pull-right"></span></h2>
          <br> 
          <div class="row">
          <div class="panel panel-info" style="margin-top:20px">
            <div class="panel-heading" style="font-size:20px"><strong>From : </strong>{{ $message->source_login }} <strong>To </strong>{{ $message->dest_login }}</div>
                <div class="panel-body">
                            <h4><strong> Date :  </strong></h4><h4 style="margin-left:30px;"> {{ $message->created_at}}<br><br></h4>
                            <h4><strong> Objet :  </strong></h4><h4 style="margin-left:30px;"> {{ $message->sujet}}<br><br></h4>
                            <h4><strong> Contenu :  </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{ $message->contenu}}<br><br></h4>
                            
                    </div>
               </div>
              </div>
           </div>
           {{Form::close()}}
@stop