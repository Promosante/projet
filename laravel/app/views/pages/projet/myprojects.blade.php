@extends('layout.mesprojet_layout')
@section('mesprojet-content')

            <h1>Mes projets<span class="glyphicon glyphicon-list-alt pull-right"></span></h1>
            <br>
            {{Form::open(array('url'=> URL::route('mesprojets.action')))}}
            <div class="row">
                {{Form::submit('Corbeille',['class'=>'btn btn-danger col-sm-2 col-xs-12 pull-left' ,'name'=>'delete'])}}
                <div class="btn btn-success pull-right" onclick="javascript:document.location.href='newproject'">Nouveau projet</div>
            </div>
          <div class="row">
          <div class="panel panel-info" style="margin-top:20px">
            <div class="panel-heading" style="font-size:20px"><strong>Projets auxquels je participe</strong></div>
                <div class="panel-body">
                  <div class="col-md-10">
                      <div class="table-responsive">  
                          <table class="table table-hover table-condensed">
                            
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th>Createur</th>
                                      <th>Titre</th>
                                      <th>En qualité de </th>
                                    
                                     
                                  </tr>
                              </thead>
                              <tbody>
                               
                                <?php define('i',0); ?>
                                 
                                 @foreach ($participe as $projet)
                                 <?php $i=$i+1; ?>
                                    <tr onclick="document.location.href='projet/{{$liste_hash[$i-1]}}'" style="cursor:pointer">
                                      <td>{{$i}}</td>
                                      <td>{{ $projet->login}}</td>
                                      <td>{{ $projet->titre}}</td>
                                      <td>{{ $projet->status }}</td>
                                      
                                      
                                    </tr>
                                  @endforeach
                                 
                                 {{Form::close()}}
                                   
                              </tbody>
                          </table>
                          </div>
                        </div>
                      <div class="col-md-2">
                           <div class="table-responsive">  
                            <table class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th>check</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($participe as $projet)
                                  <tr >
                                    <?php $i=$i+1; ?>
                                      <td style="padding-top:2px"> {{ Form::checkbox('msg'.$i, ''.$i) }}</td>
                                  </tr>
                                @endforeach
                                
                              </tbody> 
                         </table>
                            
                          </div>
                      </div>
                      </div>
                    </div>
                  </div>
          <div class="row">
          <div class="panel panel-info" style="margin-top:20px">
            <div class="panel-heading" style="font-size:20px"><strong>Projets que j'ai créé</strong></div>
                <div class="panel-body">
                  <div class="col-md-10">
                      <div class="table-responsive">  
                          <table class="table table-hover table-condensed">
                            
                              <thead>
                                  <tr>
                                      <th></th>
                                      
                                      <th>Titre</th>
                                      <th>Date de creation</th>
                                     
                                  </tr>
                              </thead>
                              <tbody>
                               
                                <?php define('j',0); ?>
                                 
                                 @foreach ($createur as $projet)
                                 <?php $j=$j+1; ?>
                                    <tr onclick="document.location.href='my-projects/{{$j}}'" style="cursor:pointer">
                                      <td>{{$j}}</td>
                                      <td>{{ $projet->titre}}</td>
                                      <td>{{ $projet->date }}</td>
                                    </tr>
                                  @endforeach
                                 
                                 {{Form::close()}}
                                   
                              </tbody>
                          </table>
                          </div>
                        </div> 
                      <div class="col-md-2">
                           <div class="table-responsive">  
                            <table class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th>check</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 <?php $j=0; ?>
                                 @foreach ($createur as $projet)
                                  <tr >
                                    <?php $j=$j+1; ?>
                                      <td style="padding-top:2px"> {{ Form::checkbox('msg'.$j, ''.$j) }}</td>
                                  </tr>
                                @endforeach
                                
                              </tbody> 
                         </table>
                            
                          </div>
                      </div>
                      </div>
                    </div>
                  </div> 
          
  {{Form::close()}}
            
@stop