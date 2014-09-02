@extends('layout.messagerie')
@section('messagerie-content')
<h2>Nouveau message<span class="glyphicon glyphicon-envelope pull-right"></span></h2>
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
            @if(Session::has('error_login'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error_login')}}</p>
                </div>
            @endif
            
          <div class="row">
          {{Form::open(array('url'=> URL::route('messagerie.send_message')))}}
            <div class="form-group">
                {{Form::label('dest','Login destinataire',['class'=>'form-label'])}}
                {{Form::text('dest','Login',['class'=>'form-control'])}}
            </div>
           <div class="form-group">
                {{Form::label('subject','Sujet',['class'=>'form-label'])}}
                {{Form::text('subject','Sujet',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('content','Contenu',['class'=>'form-label'])}}
                {{Form::textarea('content','Contenu',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::submit('Envoyer !',['class'=>'btn btn-primary col-sm-2 col-xs-12 pull-right top-marge-button'])}}
            </div> 
            {{Form::close()}}
         </div>
    </div>
@stop