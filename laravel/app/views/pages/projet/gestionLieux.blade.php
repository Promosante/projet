@extends('layout.projet_layout')
@section('projet-content')

  {{Form::open(array('url'=> URL::route('projectlieux.action',$id),'enctype'=>'multipart/form-data'))}}
    <h2>Gestion des Lieux<span class="glyphicon glyphicon-road pull-right"></span></h2>

    @if($success)
                <div class="alert alert-success"style="margin-top:15px">
                    {{$success}}
                </div>
    @endif

    @if(Session::has('errors'))
                <div class="alert alert-danger" style="margin-top:15px">
                    @foreach ($errors as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                    
                </div>
     @endif
 
    <div class="row">
            <div class="panel panel-info" style="margin-top:10px">
              <div class="panel-heading" style="font-size:20px"><strong>Lieux</strong> </div>
                <div class="panel-body">
                    
                      <div class="table-responsive">  
                          <table id="simpleTable" class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th data-sort="string">
                                        <p class="btn btn-default trick" id="tri_nom" 
                                            onclick="javascript:refresh_result('tri_nom','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);"
                                                   style="width:100%;">Nom</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_addr" 
                                            onclick="javascript:refresh_result('tri_addr','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);"
                                            style="width:100%;">Adresse</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_ville" 
                                            onclick="javascript:refresh_result('tri_ville','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);" 
                                                        style="width:100%;">Ville</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_cp" 
                                            onclick="javascript:refresh_result('tri_cp','page_','ligne',{{ceil(count($results)/15)+1}},{{count($results)}},15);" 
                                                style="width:100%;">Code Postal</p></th>
                                  </tr>
                              </thead> 
                              <tbody>
                                <?php define('i',0) ?>
                                @foreach($results as $lieu)
                                 <?php $i=$i+1; ?>
                                    <tr id="l_{{$i}}" name="ligne" onclick="javascript:hilight_line_for_details('l_{{$i}}','ligne',{{count($results)}},'success lieu_line','lieu_line')" class="lieu_line">
                                      <td>{{$i}} {{ Form::checkbox('check_lieu_'.$i, 'yes',false,['id'=>'check_lieu_'.$i]) }} </td>
                                      <td>{{$lieu->nom}}</td>
                                      <td>{{$lieu->adresse}}</td>
                                      <td>{{$lieu->ville}}</td>
                                      <td>{{$lieu->code_postal}}</td>
                                    </tr>
                                @endforeach
                              </tbody>
                          </table>
                        </div> 
                      
                      @for($p=1; $p < ceil(count($results)/15)+1;$p=$p+1)
                          <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_','ligne',{{$p}},{{ceil(count($results)/15)+1}},{{count($results)}},15);" 
                                                                        id="page_{{$p}}">{{$p}}</p>
                      @endfor
                </div>
              </div>
            </div>

        <?php $i=0; ?>
        @foreach($results as $lieu)
          <?php $i=$i+1; ?>
            <div class="row details" id="d_{{$i}}">
              <div class="panel panel-success" style="margin-top:10px">
                <div class="panel-heading" style="font-size:20px"><strong>Détails</strong> <div class="btn btn-danger pull-right" onclick="javascript:$('#d_{{$i}}').hide(200);$('.lieu_line').attr('class','lieu_line');"><span class="glyphicon glyphicon-remove"></span></div></div>
                  <div class="panel-body">
                    <h4> <strong>Nom : </strong></h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->nom}}</h4>
                    <h4><strong>Adresse : </strong> </h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;">{{$lieu->adresse}}</h4>
                    <h4><strong>Ville : </strong></h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->ville}}</h4>
                    <h4><strong>Code Postal : </strong></h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->code_postal}}</h4>
                    <h4><strong>Ressources humaines : </strong></h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->ressources_humaines}}</h4>
                    <h4><strong>Ressources matérielles : </strong></h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->ressources_materielles}}</h4>
                    <h4><strong>Téléphone : </strong></h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->telephone}}</h4>
                    <h4><strong>Ajouté le : </strong></h4>
                    <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->created_at}}</h4>
                    <div class="btn btn-success btn-lg pull-right"><span class="glyphicon glyphicon-globe pull-left" style="margin-right:10px;font-size:20pt"></span> Rechercher sur Google Map  </div>
                  </div>
              </div>
            </div>
    @endforeach
    <div class="row">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Ajouter un lieux : </h4>
              <hr>
           </div> 
     </div>
     
     <div class="row"> 
        <div class="col-md-6">
            {{Form::label('nom_ajout','Nom',['class'=>'form-label','style'=>'width:100%;margin-top:25px'])}}
            {{Form::text('nom_ajout', 'Nom' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-6">
            {{Form::label('adresse_ajout','Adresse',['class'=>'form-label','style'=>'width:100%;margin-top:25px'])}}
            {{Form::text('adresse_ajout', 'Adresse' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-4">
            {{Form::label('ville_ajout','Ville',['class'=>'form-label','style'=>'width:100%;margin-top:25px'])}}
            {{Form::text('ville_ajout', 'Ville' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-2">
            {{Form::label('cp_ajout','Code Postal',['class'=>'form-label','style'=>'width:100%;margin-top:25px'])}}
            {{Form::text('cp_ajout', 'Code Postal' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-4">
            {{Form::label('tel_ajout','Telephone',['class'=>'form-label','style'=>'width:100%;margin-top:25px'])}}
            {{Form::text('tel_ajout', '06 06 06 06 06' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-6">
            {{Form::label('ress_h_ajout','Ressources humaines disponibles',['class'=>'form-label','style'=>'width:100%;margin-top:25px'])}}
            {{Form::textarea('ress_h_ajout', 'Ressources humaines' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-6">
            {{Form::label('ress_m_ajout','Ressources matérielles disponibles',['class'=>'form-label','style'=>'width:100%;margin-top:25px'])}}
            {{Form::textarea('ress_m_ajout', 'Ressources matérielles' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-2">
            {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'ajout_lieu'])}}
        </div>
    </div>
    
    <div class="row">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Supprimer les lieux cochés : </h4>
              <hr>
           </div> 
     </div>

     <div class="row"> 
        <div class="col-md-2">
            {{Form::submit('Supprimer',['class'=>'btn btn-danger col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'supp_lieu'])}}
        </div>
    </div>

    <div class="row">
          <div class="col-md-6">
              <h4 style="margin-top:35px">Télécharger données CSV</h4>
              <hr>
           </div> 
     </div>
     <div class="row"> 
        <div class="col-md-2">
            {{Form::submit('Download !',['class'=>'btn btn-info col-sm-2 col-xs-12','style'=>'width:100%;','name'=>'down_lieu'])}}
        </div>
    </div>
    <h4 style="margin-top:35px"><strong>Importer données CSV</strong></h4>
    <hr>
    <div class="row"> 
          <div class="alert alert-info">
              L'ordre des champs doit être le suivant : nom,adresse,ville,code postal,telephone,ressource humaine,ressource matérielle. La première ligne est ignorée et les champs doivent avoir moins de 1024 caractères. Si vous passez des lignes à la fin du fichier vous obtiendrez une erreur (sans conséquence pour la saisie).
          </div>
            <div class="form-group"> 
                  {{ Form::file('fichier') }}
                
                {{Form::submit('Go!',['class'=>'btn btn-info col-sm-2 col-xs-12 pull-right','name'=>'upload_csv'])}}
            </div>
          
    </div>
{{Form::close()}}
<script>
$(".details").hide();
pagine_results('page_','ligne',1,{{ceil(count($results)/15)+1}},{{count($results)}},15);
</script>
@stop