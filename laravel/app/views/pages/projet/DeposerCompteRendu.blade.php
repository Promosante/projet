@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('CompteRendu.action',$id)))}}
<h2>Comptes rendus</h2>
<h3>liste :</h3>
<hr>
@for($i=0;$i < count($list);$i++)
<hr>
	<h4>{{ $list[$i] }} {{ Form::submit('Consulter ',['class'=>'btn btn-info btn-sm col-sm-2 col-xs-12 pull-right','name'=>'consulter_'.$i]) }}</h4> 
<hr>
@endfor
  

{{Form::close()}}
@stop