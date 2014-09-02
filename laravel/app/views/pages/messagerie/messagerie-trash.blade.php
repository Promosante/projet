@extends('layout.messagerie')
@section('messagerie-content')
  
    <h2>Corbeille <span class="glyphicon glyphicon-trash pull-right"></span></h2>
          <br>
            {{Form::open(array('url'=> URL::route('messagerie.action_trash')))}}
            <div class="row">
                {{Form::submit('Restaurer',['class'=>'btn btn-success col-sm-2 col-xs-12 pull-left ','name'=>'restaure'])}}
                {{Form::submit('Supprimer',['class'=>'btn btn-danger col-sm-3 col-xs-12 pull-right' ,'name'=>'delete'])}}
            </div>
          <div class="row">
          <div class="panel panel-info" style="margin-top:20px">
            <div class="panel-heading" style="font-size:20px"><strong>Messages :</strong></div>
                <div class="panel-body">
                      <div class="table-responsive">  
                          <table class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th>Sujet</th>
                                      <th>Expediteur</th>
                                      <th>Destinataire</th>
                                      <th>Date</th>
                                      <th>Check </th>
                                  </tr>
                              </thead>
                              <tbody>
                               
                                <?php define('i',0); ?>
                                 @foreach ($messages as $message)
                                 <?php $i=$i+1; ?>
                                    <tr>
                                      <td>{{$i}}</td>
                                      <td>{{ $message->sujet }}</td>
                                      <td>{{ $message->source_login }}</td>
                                      <td>{{ $message->dest_login }}</td>
                                      <td>{{ $message->created_at }}</td>
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