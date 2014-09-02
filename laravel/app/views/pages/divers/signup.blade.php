@extends('layout.basic_layout')
@section('body')

    <div class="container">
        <div class="col-md-2"></div>

        <div class="col-md-8 col-xs-12 col-sm-12">
            <br>
            <h1>Sign up</h1>
            <br>
            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    @foreach (Session::get('errors')->all() as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                    
                </div>
            @endif
            <div class="alert alert-warning">
                Les champs munis de (*) sont obligatoires.  
            </div>
            {{Form::open(array('url'=> URL::route('signup.register')))}}
            <div class="form-group">
                {{Form::label('login','Votre login (*)',['class'=>'form-label'])}}
                {{Form::text('login','',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('email','Votre email de compte (unique, privée, associée au compte) (*)',['class'=>'form-label'])}}
                {{Form::text('email','',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('email_membre','Votre email publique ( pour contact )',['class'=>'form-label'])}}
                {{Form::text('email_membre','',['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('nom','Votre nom (*)',['class'=>'form-label'])}}
                {{Form::text('nom','',['class'=>'form-control '])}}
            </div>
             <div class="form-group">
                {{Form::label('prenom','Votre prenom (*)',['class'=>'form-label '])}}
                {{Form::text('prenom','',['class'=>'form-control '])}}
            </div>
            <div class="form-group">
                {{Form::label('password','Votre mot de passe (*)',['class'=>'form-label'])}}
                {{Form::password('password',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('passwordVerif','Confirmez votre mot de passe (*)',['class'=>'form-label'])}}
                {{Form::password('passwordVerif',['class'=>'form-control '])}}
            </div>
             <div class="form-group">
                {{Form::label('structure','Votre structure',['class'=>'form-label'])}}
                {{Form::text('structure','',['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('fonction','Votre fonction',['class'=>'form-label'])}}
                {{Form::text('fonction','',['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('datenaissance','Votre date de naissance (format JJ/MM/AAAA)',['class'=>'form-label'])}}
                {{Form::text('datenaissance','',['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('adresse','Votre adresse',['class'=>'form-label'])}}
                {{Form::text('adresse','',['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('codepostal','Votre code postal',['class'=>'form-label'])}}
                {{Form::text('codepostal','',['class'=>'form-control'])}}
            </div>   
              <div class="form-group">
                {{Form::label('ville','Votre ville',['class'=>'form-label'])}}
                {{Form::text('ville','',['class'=>'form-control'])}}
            </div>  
             <div class="form-group">
                {{Form::label('pays','Votre Pays',['class'=>'form-label'])}}
                {{Form::text('pays','',['class'=>'form-control'])}}
            </div> 
            <div class="form-group">
                {{Form::submit('Sign up !',['class'=>'btn btn-primary col-sm-2 col-xs-12 pull-right top-marge-button'])}}
            </div>  
            {{Form::close()}}
         </div>

        <div class="col-md-2"></div>

    </div>
@stop