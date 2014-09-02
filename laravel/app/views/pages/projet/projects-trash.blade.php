@extends('layout.mesprojet_layout')
@section('mesprojet-content')

            <h1>Corbeille<span class="glyphicon glyphicon-trash pull-left"></span></h1>
            <br>
            {{Form::open(array('url'=> URL::route('projectstrash.action')))}}
            <div class="row">
                {{Form::submit('Restaurer',['class'=>'btn btn-success col-sm-2 col-xs-12 pull-left' ,'name'=>'delete'])}}
            </div>
          <div class="row">
          <div class="panel panel-info" style="margin-top:20px">
            <div class="panel-heading" style="font-size:20px"><strong>Projets :</strong></div>
                <div class="panel-body">
                      <div class="table-responsive">  
                          <table class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th>Titre</th>
                                      <th>Date</th>
                                      <th>Check </th>
                                  </tr>
                              </thead>
                              <tbody>
                               
                                <?php define('i',0); ?>
                                
                                @foreach ($projets as $projet)
                                 <?php $i=$i+1; ?>
                                    <tr>
                                      <td>{{$i}}</td>
                                      <td>{{ $projet->titre }}</td>
                                      <td>{{ $projet->date }}</td>
                                      <td>
                                          {{ Form::checkbox('msg'.$i, ''.$i) }}  
                                      </td>
                                    </tr>
                                  @endforeach
                                 
                                 {{Form::close()}}
                                   
                              </tbody>
                          </table>
                        </div>
                  
                    </div>
               
              </div>
           </div>
           {{Form::close()}}
            
@stop