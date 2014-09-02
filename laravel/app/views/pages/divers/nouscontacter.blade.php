@extends('layout.basic_layout')
@section('body')
<div class="container">
        <div class="col-md-2"></div>

        <div class="col-md-8 col-xs-12 col-sm-12">
            <br>
            <h1>Nous contacter</h1>
            <br>
            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    @foreach (Session::get('errors')->all() as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                    
                </div>
            @endif
            {{Form::open(array('url'=> URL::route('nouscontacter.action')))}}
            <div class="form-group">
                {{Form::label('email_guest','Votre email',['class'=>'form-label'])}}
                {{Form::text('email_guest','exemple@exemple.com',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('objet','Objet',['class'=>'form-label'])}}
                {{Form::text('objet','Objet',['class'=>'form-control'])}}
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

        <div class="col-md-2"></div>

    </div>

@stop