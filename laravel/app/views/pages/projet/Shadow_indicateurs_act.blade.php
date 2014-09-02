{{Form::open(array('url'=> URL::route('shadowindicateursact.action',$id)))}}

<div id="hidden_indics_enr">
    <div class="row">
                  <h2 class="font_for_shadow">Ajouter un Indicateurs : <span class="glyphicon glyphicon-road pull-right"></span></h2>
                  <hr class="font_for_shadow">
    </div>

    <div class="panel panel-info" style="margin-top:10px;">
              <div class="panel-heading" style="font-size:20px"><strong>Indicateurs</strong> </div>
                <div class="panel-body">
                   
                      <div class="table-responsive">  
                          <table id="stupidTable" class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_indic_shad" onclick="javascript:refresh_result('tri_nom_indic_shad','page_indic_enr_','ligne_indic_enr',{{ceil(count($TousLesIndicateurs)/15)+1}},{{count($TousLesIndicateurs)}},15);" style="width:100%;">Nom</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_descr_indic_shad" onclick="javascript:refresh_result('tri_descr_indic_shad','page_indic_enr_','ligne_indic_enr',{{ceil(count($TousLesIndicateurs)/15)+1}},{{count($TousLesIndicateurs)}},15);" style="width:100%;">Declinaison</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_dom_indic_shad" onclick="javascript:refresh_result('tri_dom_indic_shad','page_indic_enr_','ligne_indic_enr',{{ceil(count($TousLesIndicateurs)/15)+1}},{{count($TousLesIndicateurs)}},15);" style="width:100%;">Domaine</p></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_dest_indic_shad" onclick="javascript:refresh_result('tri_dest_indic_shad','page_indic_enr_','ligne_indic_enr',{{ceil(count($TousLesIndicateurs)/15)+1}},{{count($TousLesIndicateurs)}},15);" style="width:100%;">Destinataire</p></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php define('jj',0); ?>
                                @foreach($TousLesIndicateurs as $indic)  
                                 <?php $jj=$jj+1; ?>
                                    <tr id="indic_{{$jj}}" name="ligne_indic_enr" onclick="javascript:hilight_line({{$jj}},'indic_','checkc_','pop_indic_tr success','pop_indic_tr');" class="pop_indic_tr">
                                     <td>{{$jj}} {{ Form::checkbox('checkc_'.$jj, 'yes',false,['id'=>'checkc_'.$jj]) }}</td>
                                      <td>{{$indic->nom}}</td>
                                      <td>{{$indic->declinaison}}</td>
                                      <td>{{$indic->domaine}}</td>
                                      <td>{{$indic->destinataire}}</td>
                                    </tr>
 
                                @endforeach 
                              </tbody>
                          </table>
                        </div> 
                             @for($p=1; $p < ceil(count($TousLesLieux)/15)+1;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_indic_enr_','ligne_indic_enr',{{$p}},{{ceil(count($TousLesIndicateurs)/15)+1}},{{count($TousLesIndicateurs)}},15);" id="page_indic_enr_{{$p}}">{{$p}}</p>
                             @endfor
                </div>
        </div>

        <div class="col-md-6">
            <div class="btn btn-danger" onclick="javascript:hide_hidden_indics();" style="width:100%">Annuler</div>
        </div>

        <div class="col-md-6">
            {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%','name'=>'ajout_indic_enregistre'])}}
        </div>

       
</div>
<script>
pagine_results('page_indic_enr_','ligne_indic_enr',1,{{ceil(count($TousLesIndicateurs)/15)+1}},{{count($TousLesIndicateurs)}},15);
</script>
{{Form::close()}}