function init_activity(){

    SetCookie ("state_lieu_p_act", 0);
    SetCookie ("state_cat_p_act", 0);
    SetCookie ("state_indic_p_act", 0);

    $("#basics_activites").show(200);
    $("#association_activites").hide(200);

    $("#content_lieux_p_act").hide();
    $("#hide_lieux_p_act").attr('class','btn btn-success');
    $("#hide_lieux_p_act").attr('id','show_lieux_p_act');
    $("#logo_lieux_p_act").attr('class','glyphicon glyphicon-eye-open');

     $("#content_cat_p_act").hide();
    $("#hide_cat_p_act").attr('class','btn btn-success');
    $("#hide_cat_p_act").attr('id','show_cat_p_act');
    $("#logo_cat_p_act").attr('class','glyphicon glyphicon-eye-open');

    $("#content_membres_p_act").hide();
    $("#hide_membres_p_act").attr('class','btn btn-success');
    $("#hide_membres_p_act").attr('id','show_membres_p_act');
    $("#logo_membres_p_act").attr('class','glyphicon glyphicon-eye-open');
}
 

function show_act_assoc(){
    
    $("#basics_activites").hide(200);
    $("#association_activites").show(200);

    if(GetCookie("state_lieu_p_act") ==0){
      $("#content_lieux_p_act").hide();
      $("#hide_lieux_p_act").attr('class','btn btn-success');
      $("#hide_lieux_p_act").attr('id','show_lieux_p_act');
      $("#logo_lieux_p_act").attr('class','glyphicon glyphicon-eye-open');
     }
     else{
      $("#content_lieux_p_act").show(200);
      $("#show_lieux_p_act").attr('class','btn btn-danger');
      $("#show_lieux_p_act").attr('id','hide_lieux_p_act');
      $("#logo_lieux_p_act").attr('class','glyphicon glyphicon-eye-close');
     }

      if(GetCookie("state_cat_p_act") ==0){
      $("#content_cat_p_act").hide();
      $("#hide_cat_p_act").attr('class','btn btn-success');
      $("#hide_cat_p_act").attr('id','show_cat_p_act');
      $("#logo_cat_p_act").attr('class','glyphicon glyphicon-eye-open');
     }
     else{
      $("#content_cat_p_act").show(200);
      $("#show_cat_p_act").attr('class','btn btn-danger');
      $("#show_cat_p_act").attr('id','hide_cat_p_act');
      $("#logo_cat_p_act").attr('class','glyphicon glyphicon-eye-close');
     }

     if(GetCookie("state_indic_p_act") ==0){
      $("#content_indic_p_act").hide();
      $("#hide_indic_p_act").attr('class','btn btn-success');
      $("#hide_indic_p_act").attr('id','show_indic_p_act');
      $("#logo_indic_p_act").attr('class','glyphicon glyphicon-eye-open');
     }
     else{
      $("#content_indic_p_act").show(200);
      $("#show_indic_p_act").attr('class','btn btn-danger');
      $("#show_indic_p_act").attr('id','hide_indic_p_act');
      $("#logo_indic_p_act").attr('class','glyphicon glyphicon-eye-close');
     }

     if(GetCookie("state_membres_p_act") ==0){
      $("#content_membres_p_act").hide();
      $("#hide_membres_p_act").attr('class','btn btn-success');
      $("#hide_membres_p_act").attr('id','show_membres_p_act');
      $("#logo_membres_p_act").attr('class','glyphicon glyphicon-eye-open');
     }
     else{
      $("#content_membres_p_act").show(200);
      $("#show_membres_p_act").attr('class','btn btn-danger');
      $("#show_membres_p_act").attr('id','hide_membres_p_act');
      $("#logo_membres_p_act").attr('class','glyphicon glyphicon-eye-close');
     }
}

$(document).ready(function(){
              //handler on click
              
              $("body").on("click","#hide_cat_p_act",function(){
                 SetCookie ("state_cat_p_act", 0);
                 $("#content_cat_p_act").hide(200);
                 $("#hide_cat_p_act").attr('class','btn btn-success');
                 $("#hide_cat_p_act").attr('id','show_cat_p_act');
                 $("#logo_cat_p_act").attr('class','glyphicon glyphicon-eye-open');
              });

              $("body").on("click","#show_cat_p_act",function(){
                  SetCookie ("state_cat_p_act", 1);
                 $("#content_cat_p_act").show(200);
                 $("#show_cat_p_act").attr('class','btn btn-danger');
                 $("#show_cat_p_act").attr('id','hide_cat_p_act');
                 $("#logo_cat_p_act").attr('class','glyphicon glyphicon-eye-close');
              });

              $("body").on("click","#hide_indic_p_act",function(){
                 SetCookie ("state_indic_p_act", 0);
                 $("#content_indic_p_act").hide(200);
                 $("#hide_indic_p_act").attr('class','btn btn-success');
                 $("#hide_indic_p_act").attr('id','show_indic_p_act');
                 $("#logo_indic_p_act").attr('class','glyphicon glyphicon-eye-open');
              });

              $("body").on("click","#show_indic_p_act",function(){
                  SetCookie ("state_indic_p_act", 1);
                 $("#content_indic_p_act").show(200);
                 $("#show_indic_p_act").attr('class','btn btn-danger');
                 $("#show_indic_p_act").attr('id','hide_indic_p_act');
                 $("#logo_indic_p_act").attr('class','glyphicon glyphicon-eye-close');
              });

              $("body").on("click","#hide_lieux_p_act",function(){
                 SetCookie ("state_lieu_p_act", 0);
                 $("#content_lieux_p_act").hide(200);
                 $("#hide_lieux_p_act").attr('class','btn btn-success');
                 $("#hide_lieux_p_act").attr('id','show_lieux_p_act');
                 $("#logo_lieux_p_act").attr('class','glyphicon glyphicon-eye-open');
              });

              $("body").on("click","#show_lieux_p_act",function(){
                  SetCookie ("state_lieu_p_act", 1);
                 $("#content_lieux_p_act").show(200);
                 $("#show_lieux_p_act").attr('class','btn btn-danger');
                 $("#show_lieux_p_act").attr('id','hide_lieux_p_act');
                 $("#logo_lieux_p_act").attr('class','glyphicon glyphicon-eye-close');
              });

              $("body").on("click","#hide_membres_p_act",function(){
                 SetCookie ("state_membres_p_act", 0);
                 $("#content_membres_p_act").hide(200);
                 $("#hide_membres_p_act").attr('class','btn btn-success');
                 $("#hide_membres_p_act").attr('id','show_membres_p_act');
                 $("#logo_membres_p_act").attr('class','glyphicon glyphicon-eye-open');
              });

              $("body").on("click","#show_membres_p_act",function(){
                  SetCookie ("state_membres_p_act", 1);
                 $("#content_membres_p_act").show(200);
                 $("#show_membres_p_act").attr('class','btn btn-danger');
                 $("#show_membres_p_act").attr('id','hide_membres_p_act');
                 $("#logo_membres_p_act").attr('class','glyphicon glyphicon-eye-close');
              });


 });

n=1;
function add_periode(){


  var html = '<div id="periodes_'+n+'" class="periode_count" style="margin-top:15px">\
                    <div class="col-md-4">\
                        <label class="form-label" for="nom_ajout">\
                            Nom\
                        </label>\
                        <input id="nom_periode_ajout_'+n+'" class="form-control" type="text" value="" name="nom_periode_ajout_'+n+'"></input>\
                    </div>\
                    <div class="col-md-3">\
                        <label class="form-label" for="date_deb_ajout">\
                            Date de début\
                        </label>\
                        <input id="date_deb_periode_ajout_'+n+'" class="form-control" type="text" value="" name="date_deb_periode_ajout_'+n+'"></input>\
                    </div>\
                    <div class="col-md-3">\
                        <label class="form-label" for="date_fin_ajout">\
                            Date de fin\
                        </label>\
                        <input id="date_fin_periode_ajout_'+n+'" class="form-control" type="text" value="" name="date_fin_periode_ajout_'+n+'"></input>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="btn btn-danger" style="margin-top:20px" onclick="javascript:remove_periode('+n+')">\
                            <span class="glyphicon glyphicon-remove"></span>\
                        </div>\
                    </div>\
                </div>';
  $("#periodes").append(html);
  n++;
}

function remove_periode(n){
  $("#periodes_"+n).remove();
}

function show_hidden_lieu(){
  $('#shadow').toggle("fade");
  $("#hidden_lieua").show(200);
}

function hide_hidden_lieu(){
  $('#shadow').toggle("fade");
  $("#hidden_lieua").hide(200);
} 

function show_hidden_membres(){
  $('#shadow').toggle("fade");
  $("#hidden_membresa").show(200);
}

function hide_hidden_membres(){
  $('#shadow').toggle("fade");
  $("#hidden_membresa").hide(200);
}

function show_hidden_membres_enr(){
  $('#shadow').toggle("fade");
  $("#hidden_membresa_enr").show(200);
}

function hide_hidden_membres_enr(){
  $('#shadow').toggle("fade"); 
  $("#hidden_membresa_enr").hide(200);
}

function show_hidden_cat(){
  $('#shadow').toggle("fade");
  $("#hidden_categories_enr").show(200);
}

function hide_hidden_cat(){
  $('#shadow').toggle("fade");
  $("#hidden_categories_enr").hide(200);
}

function show_hidden_lieu_enr(){
  $('#shadow').toggle("fade");
  $("#hidden_lieuxa_enr").show(200);
}

function hide_hidden_lieu_enr(){
  $('#shadow').toggle("fade");
  $("#hidden_lieuxa_enr").hide(200);
}

function show_hidden_outils(){
  $('#shadow').toggle("fade");
  $("#hidden_outils").show(200);
}

function hide_hidden_outils(){
  $('#shadow').toggle("fade");
  $("#hidden_outils").hide(200);
}

function show_hidden_indics(){
  $('#shadow').toggle("fade");
  $("#hidden_indics_enr").show(200);
}

function hide_hidden_indics(){
  $('#shadow').toggle("fade");
  $("#hidden_indics_enr").hide(200);
}
