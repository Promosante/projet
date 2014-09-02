{{Form::open(array('url'=> URL::route('shadowLieux.action',$id)))}}
<div id="hidden_lieux_enr">
    <div class="row">
                  <h2 class="font_for_shadow">Ajouter un lieux : <span class="glyphicon glyphicon-road pull-right"></span></h2>
                  <hr class="font_for_shadow">
    </div>

    <div class="panel panel-info" style="margin-top:10px;">
              <div class="panel-heading" style="font-size:20px"><strong>Lieux</strong> </div>
                <div class="panel-body">
                   
                      <div class="table-responsive">  
                          <table id="stupidTable" class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_shad" onclick="javascript:refresh_result('tri_nom_shad','page_lieu_enr_','ligne_lieux_enr',{{ceil(count($TousLesLieux)/15)+1}},{{count($TousLesLieux)}},15);" style="width:100%;">Nom</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_addr_shad" onclick="javascript:refresh_result('tri_addr_shad','page_lieu_enr_','ligne_lieux_enr',{{ceil(count($TousLesLieux)/15)+1}},{{count($TousLesLieux)}},15);" style="width:100%;">Adresse</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_ville_shad" onclick="javascript:refresh_result('tri_ville_shad','page_lieu_enr_','ligne_lieux_enr',{{ceil(count($TousLesLieux)/15)+1}},{{count($TousLesLieux)}},15);" style="width:100%;">Ville</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_cp_shad" onclick="javascript:refresh_result('tri_cp_shad','page_lieu_enr_','ligne_lieux_enr',{{ceil(count($TousLesLieux)/15)+1}},{{count($TousLesLieux)}},15);" style="width:100%;">Code Postal</p></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php define('j',0); ?>
                                @foreach($TousLesLieux as $lieu)  
                                 <?php $j=$j+1; ?>
                                    <tr id="lieu_{{$j}}" name="ligne_lieux_enr" onclick="javascript:hilight_line({{$j}},'lieu_','check_','pop_lieu_tr success','pop_lieu_tr');" class="pop_lieu_tr">
                                     <td>{{$j}} {{ Form::checkbox('check_'.$j, 'yes',false,['id'=>'check_'.$j]) }}</td>
                                      <td>{{$lieu->nom}}</td>
                                      <td>{{$lieu->adresse}}</td>
                                      <td>{{$lieu->ville}}</td>
                                      <td>{{$lieu->code_postal}}</td>
                                    </tr>

                                @endforeach 
                              </tbody>
                          </table>
                        </div> 
                             @for($p=1; $p < ceil(count($TousLesLieux)/15)+1;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_lieu_enr_','ligne_lieux_enr',{{$p}},{{ceil(count($TousLesLieux)/15)+1}},{{count($TousLesLieux)}},15);" id="page_lieu_enr_{{$p}}">{{$p}}</p>
                             @endfor
                </div>
        </div>

        <div class="col-md-6">
            <div class="btn btn-danger" onclick="javascript:hide_hidden_lieu_enr();" style="width:100%">Annuler</div>
        </div>

        <div class="col-md-6">
            {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%','name'=>'ajout_lieu_enregistre'])}}
        </div>

       
</div>
<script>
pagine_results('page_lieu_enr_','ligne_lieux_enr',1,{{ceil(count($TousLesLieux)/15)+1}},{{count($TousLesLieux)}},15);
</script>
{{Form::close()}}