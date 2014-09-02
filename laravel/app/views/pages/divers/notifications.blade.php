@extends('layout.basic_layout')
@section('body')
{{Form::open(array('url'=> URL::route('notifications.action')))}}
    <div class="container">

      @if($success)
           <div class="alert alert-success">
            {{$success}}
          </div>
     @endif


      <div class="row">
          <h2>Notifications récentes</h2>
          <hr>
           <div class="btn btn-success pull-right" style="margin-right:20px">Accepter toutes les demandes d'association aux projets en tant que participant</div>
      </div>
      <div class="row">
      <div class="hidden">
          {{$i=0;}}
      </div>
      @foreach($notifs_new as $n)
          @if($n->type === 'demande_assos_projet')
            <div class="panel panel-success" style="margin-top:20px">
                    <div class="panel-heading">
                        <h4>Demande d'association à un projet. </h4>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                          <h4 style="margin-left:15px"> {{$n->message}} </h4>
                      </div>
                      <div class="row">
                          {{Form::submit('Marquer comme lu',['class'=>'btn btn-primary pull-right','style'=>'margin-top:25px;margin-right:15px','name'=>'marquer_lu_'.$i])}} 
                          {{Form::submit('Accepter',['class'=>'btn btn-success pull-left','style'=>'margin-top:25px;margin-left:15px','name'=>'accepter_'.$i])}} 
                          {{Form::submit('Refuser',['class'=>'btn btn-danger pull-left','style'=>'margin-top:25px;margin-left:15px','name'=>'refuser_'.$i])}}    
                      </div>
                    </div>
            </div>
          @endif
          @if($n->type === 'info')
            <div class="panel panel-warning" style="margin-top:20px">
                    <div class="panel-heading">
                        <h4>Info </h4>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                          <h4 style="margin-left:15px"> {{$n->message}} {{Form::submit('Ok',['class'=>'btn btn-success pull-right','style'=>'margin-right:15px','name'=>'ok_'.$i])}} </h4>
                      </div>
                    </div>
            </div>
          @endif
        <div class="hidden">
            {{$i++;}}
        </div>
      @endforeach
      <h2>Notifications lues</h2>
      <hr>
      @foreach($notifs_old as $n)
          @if($n->type === 'demande_assos_projet')
            <div class="panel panel-info" style="margin-top:20px">
                    <div class="panel-heading">
                        <h4>Demande d'association à un projet. <div class="btn btn-danger pull-right" ><span class="glyphicon glyphicon-remove"></span></div></h4>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                          <h4 style="margin-left:15px"> {{$n->message}} </h4>
                      </div>
                      <div class="row">
                        @if($n->read_or_not=='answered')
                          {{Form::submit('Accepter',['class'=>'btn btn-success pull-left','disabled','style'=>'margin-top:25px;margin-left:15px','name'=>'accepter2_'.$i])}} 
                          {{Form::submit('Refuser',['class'=>'btn btn-danger pull-left','disabled','style'=>'margin-top:25px;margin-left:15px','name'=>'refuser2_'.$i])}}   
                        @endif
                        @if($n->read_or_not=='read')
                          {{Form::submit('Accepter',['class'=>'btn btn-success pull-left','style'=>'margin-top:25px;margin-left:15px','name'=>'accepter2_'.$i])}} 
                          {{Form::submit('Refuser',['class'=>'btn btn-danger pull-left','style'=>'margin-top:25px;margin-left:15px','name'=>'refuser2_'.$i])}}   
                        @endif   
                      </div>
                    </div>
            </div>
          @endif
           @if($n->type === 'info')
            <div class="panel panel-info" style="margin-top:20px">
                    <div class="panel-heading">
                        <h4>Info </h4>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                          <h4 style="margin-left:15px"> {{$n->message}} {{Form::submit('Ok',['class'=>'btn btn-success pull-right','disabled','style'=>'margin-right:15px','name'=>'ok_'.$i])}} </h4>
                      </div>
                    </div>
            </div>
          @endif
        <div class="hidden">
            {{$i++;}}
        </div>
      @endforeach
  </div>
</div>
{{Form::close()}}
{{ HTML::script('js/notif.js'); }}

<script>

</script>
@stop