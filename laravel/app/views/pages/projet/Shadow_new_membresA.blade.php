{{Form::open(array('url'=> URL::route('shadowMembresA.action',$id)))}}
    <div id="hidden_membresa">
      <h2 class="font_for_shadow">Ajouter un nouveau membre <span class="glyphicon glyphicon-user pull-right"></span></h2>
        <hr class="font_for_shadow">
        <div class="row">
            <div class="col-md-3">
                {{Form::label('nom_ajout','Nom',['class'=>'form-label font_for_shadow'])}}
                {{Form::text('nom_ajout', '' ,['class'=>'form-control'])}}
            </div>
             <div class="col-md-3">
                {{Form::label('prenom_ajout','Prenom',['class'=>'form-label font_for_shadow'])}}
                {{Form::text('prenom_ajout', '' ,['class'=>'form-control'])}}
            </div>
             <div class="col-md-5">
                {{Form::label('adresse_ajout','Adresse',['class'=>'form-label font_for_shadow'])}}
                {{Form::text('adresse_ajout', '' ,['class'=>'form-control'])}}
            </div>
       </div>
       <div class="row">
           <div class="col-md-3">
              {{Form::label('ville_ajout','Ville',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
              {{Form::text('ville_ajout', '' ,['class'=>'form-control'])}}
          </div>
           <div class="col-md-2">
              {{Form::label('cp_ajout','Code postal',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
              {{Form::text('cp_ajout', '' ,['class'=>'form-control'])}}
          </div>
          
          <div class="col-md-3">
            {{Form::label('qualite_ajout','En qualité de',['class'=>'form-label font_for_shadow','style'=>'margin-top:15px'])}}
            <br>
            {{Form::select('qualite_ajout', array('E' => 'Expert', 'C' => 'Collaborateur','I'=>'Intervenant','P'=>'Participant','N'=>'Non attribué'), 'N',['style'=>'max-width:100%'])}} 
        </div>
    </div>
       <div class="row">
          <div class="col-md-5">
              {{Form::submit('Ajouter',['class'=>'btn btn-success','style'=>'margin-top:25px;width:100%','name'=>'ajout_membre_shad_cat'])}}
          </div>
          <div class="col-md-5">
              <p class="btn btn-danger" onclick="javascript:hide_hidden_membres();" style="margin-top:25px;width:100%">Annuler</p>
          </div>
      </div>
  </div>
{{Form::close()}}