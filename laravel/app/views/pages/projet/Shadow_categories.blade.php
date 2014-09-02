{{Form::open(array('url'=> URL::route('shadowcategoriea.action',$id)))}}
<div id="hidden_categories_enr">
  
<div class="hidden">
 {{$ligneName='ligne_categories_shad';}}
 {{$ligneId='categorie_shad_';}}
 {{$NbPerPage=15;}}
 {{$ligneClass='categorie_shad_line';}}
 {{$checkNameAndId='check_categorie_shad_';}}
 {{$Nb_pages=ceil(count($ToutesLesCategories)/$NbPerPage)+1;}}
 {{$Nb_El=count($ToutesLesCategories);}}
 {{$pageId='page_shad_categories';}}
 </div>

    <div class="row">
          <h2 class="font_for_shadow">Ajouter des categories : <span class="glyphicon glyphicon-road pull-right"></span></h2>
          <hr class="font_for_shadow">
    </div>

     <div class="row"> 
                      <div class="panel panel-success" style="margin-top:20px">
                        <div class="panel-heading" style="font-size:20px"><strong>Categories :</strong> </div>
                          <div class="panel-body">
                           
                              <div class="table-responsive">  
                              <table id="simpleTable" class="table table-hover table-condensed">
                                  <thead>
                                      <tr>
                                          <th></th> 
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_cat" onclick="javascript:refresh_result('tri_nom_cat','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Nom</p></th>
                                          <th data-sort="string"><p class="btn btn-default trick" id="tri_descr_cat" onclick="javascript:refresh_result('tri_descr_cat','{{$pageId}}','{{$ligneName}}',{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});" style="width:100%;">Descriptif</p></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                 <?php $i=0; ?>
                                 @foreach ($ToutesLesCategories as $membre)
                                 <?php $i=$i+1; ?>
                                    <tr id="{{$ligneId.$i}}" name="{{$ligneName}}" onclick="javascript:hilight_line({{$i}},'{{$ligneId}}','{{$checkNameAndId}}','success {{$ligneClass}}','{{$ligneClass}}')" class="{{$ligneClass}}">
                                      <td>{{$i}} {{ Form::checkbox($checkNameAndId.$i, 'yes',false,['id'=>$checkNameAndId.$i]) }}</td>
                                      <td>{{ $membre->nom }}</td>
                                      <td>{{ $membre->descriptif }}</td>
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

        <div class="col-md-6">
            <div class="btn btn-danger" onclick="javascript:hide_hidden_cat();" style="width:100%">Annuler</div>
        </div>

        <div class="col-md-6">
            {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%','name'=>'ajout_cat_enregistres'])}}
        </div>

       
</div>
<script>
pagine_results('{{$pageId}}','{{$ligneName}}',1,{{$Nb_pages}},{{$Nb_El}},{{$NbPerPage}});
</script>
{{Form::close()}}