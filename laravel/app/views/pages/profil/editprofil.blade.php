@extends('layout.basic_layout')
@section('body')

    <div class="container">
        <div class="col-md-2"></div>

        <div class="col-md-8 col-xs-12 col-sm-12">
            <br>
            <h1>Editer le profil</h1>
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
            {{Form::open(array('url'=> URL::route('editprofil.edit')))}}
             <div class="form-group">
                {{Form::label('nom','Votre nom',['class'=>'form-label'])}}
                {{Form::text('nom',$results[0]->nom ,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('prenom','Votre prenom',['class'=>'form-label'])}}
                {{Form::text('prenom', $results[0]->prenom ,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('structure','Votre structure',['class'=>'form-label'])}}
                {{Form::text('structure', $results[0]->structure ,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('fonction','Votre fonction',['class'=>'form-label'])}}
                {{Form::text('fonction', $results[0]->fonction ,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('datenaissance','Votre date de naissance (format JJ/MM/AAAA)',['class'=>'form-label'])}}
                {{Form::text('datenaissance',$results[0]->datenaissance,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('adresse','Votre adresse',['class'=>'form-label'])}}
                {{Form::text('adresse',$results[0]->adresse,['class'=>'form-control'])}}
            </div>
             <div class="form-group">
                {{Form::label('codepostal','Votre code postal',['class'=>'form-label'])}}
                {{Form::text('codepostal',$results[0]->codepostal,['class'=>'form-control'])}}
            </div>   
              <div class="form-group">
                {{Form::label('ville','Votre ville',['class'=>'form-label'])}}
                {{Form::text('ville',$results[0]->ville,['class'=>'form-control'])}}
            </div>  
             <div class="form-group">
                {{Form::label('pays','Votre Pays',['class'=>'form-label'])}}
                {{Form::text('pays',$results[0]->pays,['class'=>'form-control'])}}
            </div> 
            <div class="form-group">
                {{Form::submit('Editer le profil!',['class'=>'btn btn-primary col-sm-2 col-xs-12 pull-right top-marge-button','name'=>'goedit'])}}
            </div>  
            {{Form::close()}}
         </div>

        <div class="col-md-2"></div>

    </div>
@stop