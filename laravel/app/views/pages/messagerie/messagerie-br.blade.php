@extends('layout.messagerie')
@section('messagerie-content')
  
    <h2>Boite de réception <span class="glyphicon glyphicon-save pull-right"></span></h2>
          <br>
            {{Form::open(array('url'=> URL::route('messagerie.action_br')))}}
            <div class="row">
                {{Form::submit('Sauver',['class'=>'btn btn-success col-sm-2 col-xs-12 pull-left ','name'=>'save'])}}
                {{Form::submit('Corbeille',['class'=>'btn btn-danger col-sm-2 col-xs-12 pull-right' ,'name'=>'delete'])}}
            </div>
          <div class="row">
          <div class="panel panel-info" style="margin-top:20px">
            <div class="panel-heading" style="font-size:20px"><strong>Messages :</strong></div>
                <div class="panel-body">
                    <div class="col-md-10">
                      <div class="table-responsive">  
                          <table class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th>Sujet</th>
                                      <th>Expediteur</th>
                                      <th>Destinataire</th>
                                      <th>Date</th>
                                  </tr>
                              </thead>
                              <tbody>
                                
                                <?php define('i',0); ?>
                                 @foreach ($messages as $message)
                                 <?php $i=$i+1; ?>

                                    <tr onclick="document.location.href='messagerie-br/{{$i}}'" style="cursor:pointer">
                                      <td>{{$i}}</td>
                                      <td>{{ $message->sujet }}</td>
                                      <td>{{ $message->source_login }}</td>
                                      <td>{{ Auth::user()->login }}</td>
                                      <td>{{ $message->created_at}}</td>
                                      </tr>
                                  @endforeach
  
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
                                 @foreach ($messages as $message)
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
  {{Form::close()}}
@stop