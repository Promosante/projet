{{Form::open(array('url'=> URL::route('shadowOutilsI.action',$id)))}}
<div id="hidden_outils">
    <div class="row">
                  <h2 class="font_for_shadow">Ajouter un outil : <span class="glyphicon glyphicon-road pull-right"></span></h2>
                  <hr class="font_for_shadow">
    </div>

    <div class="panel panel-info" style="margin-top:10px;">
              <div class="panel-heading" style="font-size:20px"><strong>Outils</strong> </div>
                <div class="panel-body">

                      <div class="table-responsive">  
                          <table id="stupidTable" class="table table-hover table-condensed">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th data-sort="string"><p class="btn btn-default trick" id="tri_nom_shad" onclick="javascript:refresh_result('tri_nom_shad','page_lieu_enr_','ligne_lieux_enr',{{ceil(count($TousLesOutils)/15)+1}},{{count($TousLesOutils)}},15);" style="width:100%;">Nom</p></th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php define('k',0); ?>
                                @foreach($TousLesOutils as $outil)  
                                 <?php $k=$k+1; ?>
                                    <tr id="outils_{{$k}}" name="ligne_outils_enr" onclick="javascript:hilight_line({{$k}},'outils_','check_o_','pop_outils_tr success','pop_outils_tr');" class="pop_outils_tr">
                                     <td>{{$k}} {{ Form::checkbox('check_o_'.$k, 'yes',false,['id'=>'check_o_'.$k]) }}</td>
                                      <td>{{$outil->nom}}</td>
                                    </tr>
                                @endforeach 
                              </tbody>
                          </table>
                        </div> 
                             @for($p=1; $p < ceil(count($outils)/15)+1;$p=$p+1)
                                <p class="btn btn-default btn-sm" onclick="javascript:pagine_results('page_outils_','ligne_outils',{{$p}},{{ceil(count($TousLesOutils)/15)+1}},{{count($TousLesOutils)}},15);" id="page_outils_{{$p}}">{{$p}}</p>
                             @endfor
                </div>
        </div>

        <div class="col-md-6">
            <div class="btn btn-danger" onclick="javascript:ok_unlight_this();" style="width:100%">Annuler</div>
        </div>

        <div class="col-md-6">
            {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%','name'=>'ajout_outils_enregistre'])}}
        </div>

       
</div>
<script>
pagine_results('page_outils_','ligne_outils',1,{{ceil(count($outils)/15)+1}},{{count($outils)}},15);

</script>
{{Form::close()}}