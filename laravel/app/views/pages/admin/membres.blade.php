@extends('layout.admin-layout')
@section('admin-content')
{{Form::open(array('url'=> URL::route('adminmembres.action')))}}
<div class="alert alert-info">
	Seul le super-administrateur peut rétrograder les autres administrateurs.
</div>
@if($success)
     <div class="alert alert-success">
        {{$success}}
      </div>
@endif
<div class="row">
{{Form::submit('Elever en tant qu\'admin',['class'=>'btn btn-success col-sm-3 col-xs-12 pull-left','style'=>'margin-top:25px','name'=>'elever'])}}
{{Form::submit('Rétrograder en tant qu\'admin',['class'=>'btn btn-danger col-sm-3 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'retrograde'])}}
</div>
<div class="row">
  {{Form::submit('Supprimer Compte',['class'=>'btn btn-danger col-sm-3 col-xs-12 pull-right','style'=>'margin-top:25px','name'=>'supprime_compte'])}}
</div>

<div class="hidden">
     {{$ligneName='ligne_membre_name';}}
     {{$ligneId='ligne_membre_';}}
     {{$NbPerPage=10;}}
     {{$ligneClass='line_membres_class';}}
     {{$checkNameAndId='check_';}}
     {{$Nb_pages=ceil(count($membres)/$NbPerPage)+1;}}
     {{$Nb_El=count($membres);}}
     {{$pageId='page_';}}
</div> 
    <hr>

    <hr>
		<div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Liste des membres</strong> </div>
                          <div class="panel-body">
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                         <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_admin" onclick="javascript:refresh_result('tri_nom_admin','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_prenom" onclick="javascript:refresh_result('tri_prenom','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Prenom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_structure" onclick="javascript:refresh_result('tri_structure','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Structure</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_fonction" onclick="javascript:refresh_result('tri_fonction','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Fonction</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_ville" onclick="javascript:refresh_result('tri_ville','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Ville</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_compte" onclick="javascript:refresh_result('tri_compte','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Compte ?</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_admin" onclick="javascript:refresh_result('tri_admin','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Admin ?</p></th>
                                       </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($membres as $m)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}');" class="{{$ligneClass}}">
                                      <td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      <td>{{ $m->nom }}</td>
                                      <td>{{ $m->prenom }}</td>
                                      <td class="ligne_structure">{{ $m->structure }}</td>
                                      <td class="ligne_fonction">{{ $m->fonction}}</td>
                                      <td>{{ $m->ville }}</td>
                                      <td>{{ $infoenplus[$i-1]['compte'] }}</td>
                                      <td>{{ $infoenplus[$i-1]['admin'] }}</td>
                                    </tr>
                                  @endforeach
                                  </tbody>
                              </table>

                            </div>
                            
                          @for($p=1; $p < $Nb_pages;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('{{$pageId}}','{{$ligneName}}',{{$p}},{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" id="{{$pageId.$p}}">{{$p}}</p>
                             @endfor

                          </div>

                      </div>
                </div>
{{Form::close()}}

{{ HTML::script('js/admin_membres.js'); }}

<script>

</script>

@stop