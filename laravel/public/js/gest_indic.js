 
$(document).ready(function(){

  $("#shadow").css("height",$(document).height()).hide();

  $("body").on("click","#hide_outils_p_indic",function(){
      SetCookie ("state_outils_p_indic", 0);
      $("#content_outils_p_indic").hide(200);
      $("#hide_outils_p_indic").attr('class','btn btn-success');
      $("#hide_outils_p_indic").attr('id','show_outils_p_indic');
      $("#logo_outils_p_indic").attr('class','glyphicon glyphicon-eye-open');
    });

    $("body").on("click","#show_outils_p_indic",function(){
      SetCookie ("state_outils_p_indic", 1);
      $("#content_outils_p_indic").show(200);
      $("#show_outils_p_indic").attr('class','btn btn-danger');
      $("#show_outils_p_indic").attr('id','hide_outils_p_indic');
      $("#logo_outils_p_indic").attr('class','glyphicon glyphicon-eye-close');
    });

    $("body").on("click","#participation_ajout",function(){
      var check_p = document.getElementById("participation_ajout");
      var check_r = document.getElementById("realisation_ajout");
      check_p.checked=true;
      check_r.checked=false;
    });

    $("body").on("click","#realisation_ajout",function(){
      var check_p = document.getElementById("participation_ajout");
      var check_r = document.getElementById("realisation_ajout");
      check_p.checked=false;
      check_r.checked=true;
    });
 
    $("body").on("click","#quantite_ajout",function(){
      var check_ql = document.getElementById("qualite_ajout");
      check_ql.checked=false;
    });

    $("body").on("click","#qualite_ajout",function(){
      var check_q = document.getElementById("quantite_ajout");
      check_q.checked=false;
    });

 });
 
function init_indic(){
  $("#hidden_outils_stuff").hide();
  $("#outils_container").hide();
  $("#new_indic_container").show();
  SetCookie ("state_outils_p_indic", 0);
}

function deselect_check(id){
  var check = document.getElementById(id);
  check.checked=false;
}

n=1;
function ajoute_reponse(){

  var str ='<div class="col-md-6" style="background-color:#E6E6E6;margin-top:15px;" id="reponse_'+n+'">\
              <label class="form-label" style="margin-top:15px">\
                Reponse '+n+'\
              </label>\
              <input id="reponse_'+n+'_ajout" class="form-control" type="text" value="" name="reponse_'+n+'_ajout" style="width:100%"></input>\
              <h5><strong>type : </strong></h5>\
              <div class="col-md-3">\
                  <h5>QCM</h5>\
                  <input id="reponse_'+n+'_QCM" type="checkbox" value="yes" name="reponse_'+n+'_QCM" checked="checked" onclick="javascript:deselect_check(\'reponse_'+n+'_libre\');"></input>\
              </div>\
              <div class="col-md-4">\
                  <h5>Réponse libre</h5>\
                  <input id="reponse_'+n+'_libre" type="checkbox" value="yes" name="reponse_'+n+'_libre" onclick="javascript:deselect_check(\'reponse_'+n+'_QCM\');"></input>\
              </div>\
              <div class="col-md-5">\
                <div class="btn btn-danger btn-sm" style="margin-top:10px" onclick="javascript:remove_QCM('+n+');"><span class="glyphicon glyphicon-remove"></span></div>\
              </div>\
            </div>';
  $("#reponse_id_container").append(str);
  n++;
}

function remove_QCM(n){
  $("#reponse_"+n).remove();
}

function show_indic_assos(){
  $("#hidden_outils_stuff").hide();
  $("#outils_container").show();
  $("#new_indic_container").hide();

  if(GetCookie("state_outils_p_indic") ==0){
        $("#content_outils_p_indic").hide(200);
        $("#hide_outils_p_indic").attr('class','btn btn-success');
        $("#hide_outils_p_indic").attr('id','show_outils_p_indic');
        $("#logo_outils_p_indic").attr('class','glyphicon glyphicon-eye-open');
      }
    else{
        $("#content_outils_p_indic").show(200);
        $("#show_outils_p_indic").attr('class','btn btn-danger');
        $("#show_outils_p_indic").attr('id','hide_outils_p_indic');
        $("#logo_outils_p_indic").attr('class','glyphicon glyphicon-eye-close');
    }
  }
 
function toggle_slide(){
  $('#shadow').toggle("fade");
  $("#hidden_outils").show(200);
}

function ok_unlight_this(){
  $('#shadow').toggle("fade");
  $("#hidden_outils").hide();
}