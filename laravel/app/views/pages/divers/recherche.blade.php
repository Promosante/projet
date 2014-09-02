@extends('layout.basic_layout')
@section('body')
{{Form::open(array('url'=> URL::route('recherche.action')))}} 
<div class="row">    
  <div class="jumbotron"> 
   
                 <div class="row">
                    <div class="col-md-1 col-xs-1"></div>
                    <div class="col-md-10 col-xs-10 col-sm-12">
                        <h1>Recherche</h1>
                        <hr>
                        {{Form::label('mots_cles','Mots clés',['class'=>'form-label','style'=>'margin-top:15px'])}}
                        {{Form::text('mots_cles','',['class'=>'form-control'])}}
                        <button class="btn btn-primary col-sm-1 col-xs-12 pull-right top-marge-button"><span class="glyphicon glyphicon-search pull-right"></span></button>
                        <h2>Rechercher parmis : </h2>
                        <div class="col-md-2">
                          {{Form::label('projet_check','Projets',['class'=>'form-label','style'=>'margin-top:15px'])}}
                          {{ Form::checkbox('projet_check', 'yes',true,['id'=>'projet_check']) }}
                        </div>
                        <div class="col-md-2">
                          {{Form::label('membres_check','Membres (nf)',['class'=>'form-label','style'=>'margin-top:15px'])}}
                          {{ Form::checkbox('membres_check', 'yes',true,['id'=>'membres_check']) }}
                        </div>
                        <div class="col-md-2">
                          {{Form::label('lieu_check','Lieux',['class'=>'form-label','style'=>'margin-top:15px'])}}
                          {{Form::checkbox('lieu_check', 'yes',true,['id'=>'lieu_check']) }}
                        </div>
                       
                    </div>
                    <div class="col-md-1"></div>
                </div>

    </div>
  
 
    <div class="container">
      <div class="row">
        <div class="col-md-1 col-xs-1"></div>
        
        <div class="col-md-10 col-xs-10 col-sm-12">
          

        @if($resProj)
          <div class="alert alert-success">
              Des projets ont été trouvés !
          </div>
          <div class="row">
            <div class="panel panel-info" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>Résultat :</strong></div>
                <div class="panel-body">
                  <div class="table-responsive">  
                          <table class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th>Acronyme</th>
                                      <th>Titre</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php define('i',0); ?>
                                
                                 @foreach($resProj as $p)
                                 <?php $i=$i+1; ?>
                                    <tr onclick="document.location.href='/projet/{{Crypt::encrypt($p->id)}}'" style="cursor:pointer">
                                      <td>{{$i}}</td>
                                      <td>{{$p->acronyme}}</td>
                                      <td>{{$p->titre}}</td>
                                    </tr>
                                  @endforeach
                              </tbody>
                          </table>
                        </div>
                </div>
              </div>
            </div>
            <hr>
            <hr>
          @endif
          @if($resLieux)
          <div class="hidden">
           {{$ligneName='line_lieu_name';}}
           {{$ligneId='l_';}}
           {{$NbPerPage=10;}}
           {{$ligneClass='lieu_class';}}
           {{$Nb_pages=ceil(count($resLieux)/$NbPerPage)+1;}}
           {{$Nb_El=count($resLieux);}}
           {{$pageId='page_lieu_id';}}
         </div>
          <div class="alert alert-success">
              Des lieux ont été trouvés !
          </div>

           <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Lieux :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                         <th data-sort="string">
                                        <p class="btn btn-default trick" id="tri_nom" 
                                            onclick="javascript:refresh_result('tri_nom','{{$pageId}}','{{$ligneName}}', {{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}} );"
                                                   style="width:100%;">Nom</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_addr" 
                                            onclick="javascript:refresh_result('tri_addr','{{$pageId}}','{{$ligneName}}', {{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}} );"
                                            style="width:100%;">Adresse</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_ville" 
                                            onclick="javascript:refresh_result('tri_ville','{{$pageId}}','{{$ligneName}}', {{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}} );" 
                                                        style="width:100%;">Ville</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_cp" 
                                            onclick="javascript:refresh_result('tri_cp','{{$pageId}}','{{$ligneName}}', {{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}} );" 
                                                style="width:100%;">Code Postal</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($resLieux as $lieu)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line_for_details('{{$ligneId.$i}}','{{$ligneName}}',{{$Nb_El}},'success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      <td>{{$i}} </td>
                                      <td>{{$lieu->nom}}</td>
                                      <td>{{$lieu->adresse}}</td>
                                      <td>{{$lieu->ville}}</td>
                                      <td>{{$lieu->code_postal}}</td>
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
              <?php $i=0; ?>
               @foreach ($resLieux as $lieu)
               <?php $i=$i+1; ?>
                   <div class="row details" id="d_{{$i}}">
                    <div class="panel panel-success" style="margin-top:10px">
                      <div class="panel-heading" style="font-size:20px"><strong>Détails</strong> <div class="btn btn-danger pull-right" onclick="javascript:$('#d_{{$i}}').hide(200);$('.lieu_line').attr('class','lieu_line');"><span class="glyphicon glyphicon-remove"></span></div></div>
                        <div class="panel-body">
                          <h4> <strong>Dans le projet : </strong></h4>
                          <h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> {{$lieu->titre_projo}}</h4>
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
          @endif      
         @if($err==1)
            <div class="alert alert-danger">
               Pas de résultats !
            </div>
         @endif 
       </div>
         <div class="col-md-1"></div>
         </div>         
        </div>
       </div> 
       
       <script>
       $(".details").hide();
       </script>
 

 {{Form::close()}} 
@stop