@extends('layout.basic_layout')
@section('body')

    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8 col-xs-12 col-sm-12">
            <br>
            <h1>Login</h1>
            <br>  
            @if($err==1)
                <div class="alert alert-danger">
                        {{ $msg }}
                </div>
            @endif

            {{Form::open(array('url'=> URL::route('login.login')))}}
            <div class="form-group">
                {{Form::label('login','Votre login',['class'=>'form-label'])}}
                {{Form::text('login','Login',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('password','Votre mot de passe',['class'=>'form-label'])}}
                {{Form::password('password',['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::submit('Login !',['class'=>'btn btn-primary col-sm-2 col-xs-12 pull-right top-marge-button'])}}
            </div> 
            <input type="hidden" name="_token" value="<? php echo crsf_token();?>">
            {{Form::close()}}
         </div>

        <div class="col-md-2"></div>

    </div>
@stop