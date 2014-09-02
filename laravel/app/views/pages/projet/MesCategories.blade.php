@extends('layout.projet_layout')
@section('projet-content')
{{Form::open(array('url'=> URL::route('categorieactivite.action',$id)))}}
<div class="row">
          <div class="panel panel-success" style="margin-top:20px">
              <div class="panel-heading" style="font-size:20px"><strong>Activités</strong> </div>
                <div class="panel-body">
                  <div class="col-md-12">
                      <div class="row">
                        <?php define('i',0); ?> 
                          @foreach($cat as $c)
                          <?php $i=$i+1; ?>
                              <div class="panel panel-info" style="margin-top:20px" id="panel_{{$i}}"name="panelpanel">
                                <div class="panel-heading" style="font-size:20px"><strong>{{$c->nom}}</strong> {{Form::submit('Editer',['class'=>'btn btn-success col-sm-2 pull-right','name'=>'editer_'.$i])}} </div>
                                  <div class="panel-body">
                                    
                                    <h4><strong> Description : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;"> 
                                    {{$c->descriptif}}
                                   </h4>
                                    <h4><strong> Outil : </strong></h4><h4 style="text-align:justify;text-justify:inter-word;margin-left:30px;">1</h4>

                                    <h4><strong> Lieux : </strong><div id="hide_lieu_in_cat_view_{{$i}}" class="btn btn-danger" onclick="javascript:toggle_perso({{$i}});"style="margin-left:15px"><span id="logo_lieux_in_cat_view_{{$i}}" class="glyphicon glyphicon-eye-close"></span></div></h4> 
                                      <div id="lieu_container_{{$i}}">
                                        <div class="table-responsive">  
                                          <table id="simpleTable" class="table table-hover table-condensed">
                                              <thead>
                                                  <tr>
                                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_nom"   style="width:100%;">Nom</p></th>
                                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_addr"  style="width:100%;">Adresse</p></th>
                                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_ville" style="width:100%;">Ville</p></th>
                                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_cp"  style="width:100%;">Code Postal</p></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($lieux_assoc[$i] as $lieu)
                                                  <tr>
                                                    <td>{{$lieu->nom}}</td>
                                                    <td>{{$lieu->adresse}}</td>
                                                    <td>{{$lieu->ville}}</td>
                                                    <td>{{$lieu->code_postal}}</td>
                                                  </tr> 
                                                @endforeach
                                              </tbody>
                                            </table>
                                       </div>
                                    </div> 
                                  </div>
                                </div>
                            @endforeach
                      </div>
                      
                     @for($p=1; $p < count($cat)/2+1;$p=$p+1)
                              <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_','panelpanel',{{$p}},{{ceil(count($cat)/2)+1}},{{count($cat)}},2);" id="page_{{$p}}">{{$p}}</p>
                      @endfor
                    </div>
                  </div>
                </div>
            </div>
{{form::close()}}
<script>

pagine_results('page_','panelpanel',1,{{ceil(count($cat))/2+1}},{{count($cat)}},2);

for(n=1;n<{{count($cat)+1}};n++){
  toggle_perso(n);
}
</script>
@stop