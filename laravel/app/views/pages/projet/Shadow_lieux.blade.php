
{{Form::open(array('url'=> URL::route('shadowLieux.action',$id)))}}
<div id="hidden_lieu">

  <div class="row">
          <div class="col-md-6">
              <h2 class="font_for_shadow" >Ajouter un nouveau lieux : <span class="glyphicon glyphicon-road pull-right"></span></h2>
              <hr>
           </div> 
     </div>
     
     <div class="row"> 
        <div class="col-md-3">
            {{Form::label('nom_ajout','Nom',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
            {{Form::text('nom_ajout', 'Nom' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-3">
            {{Form::label('adresse_ajout','Adresse',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
            {{Form::text('adresse_ajout', 'Adresse' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-2">
            {{Form::label('ville_ajout','Ville',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
            {{Form::text('ville_ajout', 'Ville' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-2">
            {{Form::label('cp_ajout','Code Postal',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
            {{Form::text('cp_ajout', 'Code Postal' ,['class'=>'form-control'])}}
        </div>
    </div>
     <div class="row" style="margin-top:15px"> 
        <div class="col-md-4">
           {{Form::label('descr_ajout','Ressources humaines disponibles',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
          {{Form::textarea('descr_ajout', 'Descriptions' ,['class'=>'form-control'])}}
          {{Form::label('descr_ajout','Ressources matérielles disponibles',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
          {{Form::textarea('descr_ajout', 'Descriptions' ,['class'=>'form-control'])}}
        </div>
        <div class="col-md-4">
          {{Form::label('tel_ajout','Telephone',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
          {{Form::text('tel_ajout', '06 06 06 06 06 06' ,['class'=>'form-control'])}}
        
          {{Form::submit('Ajout',['class'=>'btn btn-success col-sm-2 col-xs-12','style'=>'width:100%;margin-top:25px','name'=>'ajout_lieu','id'=>'close_lieux_pop_event'])}}
          <div class="btn btn-danger" onclick="hide_hidden_lieu();" style="margin-top:25px;width:100%">Annuler</div>
        </div>
      </div>   
</div>
{{Form::close()}}