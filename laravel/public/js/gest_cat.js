function init_categorie(){

    SetCookie ("state_outils_p_categorie", 0);
    SetCookie ("state_lieu_p_categorie", 0);
    SetCookie ("state_indic_p_categorie", 0);
    SetCookie ("state_membre_p_categorie", 0);

    $("#hidden_lieu").hide();
    $("#association_categorie").hide(); 
    $("#terminer").hide();
    $("#content_outils_p_cat").hide();
    $("#hide_outils_p_cat").attr('class','btn btn-success');
    $("#hide_outils_p_cat").attr('id','show_outils_p_cat');
    $("#logo_outils_p_cat").attr('class','glyphicon glyphicon-eye-open');

    $("#content_lieux_p_cat").hide();
    $("#hide_lieux_p_cat").attr('class','btn btn-success');
    $("#hide_lieux_p_cat").attr('id','show_lieux_p_cat');
    $("#logo_lieux_p_cat").attr('class','glyphicon glyphicon-eye-open');

    $("#content_membres_p_cat").hide();
    $("#hide_membres_p_cat").attr('class','btn btn-success');
    $("#hide_membres_p_cat").attr('id','show_membres_p_cat');
    $("#logo_membres_p_cat").attr('class','glyphicon glyphicon-eye-open');

    $("#content_indic_p_cat").hide();
    $("#hide_indic_p_cat").attr('class','btn btn-success');
    $("#hide_indic_p_cat").attr('id','show_indic_p_cat');
    $("#logo_indic_p_cat").attr('class','glyphicon glyphicon-eye-open');

    $("#alert_supp_gest_cat").hide(200);

    $("#fake_supp_gest_cat_hide").attr('id','fake_supp_gest_cat_show');

}


$(document).ready(function(){

      $("body").on("click","#hide_outils_p_cat",function(){
                 SetCookie ("state_outils_p_categorie", 0);
                 $("#content_outils_p_cat").hide(200);
                 $("#hide_outils_p_cat").attr('class','btn btn-success');
                 $("#hide_outils_p_cat").attr('id','show_outils_p_cat');
                 $("#logo_outils_p_cat").attr('class','glyphicon glyphicon-eye-open');
              });

      $("body").on("click","#show_outils_p_cat",function(){
                 SetCookie ("state_outils_p_categorie", 1);
                 $("#content_outils_p_cat").show(200);
                 $("#show_outils_p_cat").attr('class','btn btn-danger');
                 $("#show_outils_p_cat").attr('id','hide_outils_p_cat');
                 $("#logo_outils_p_cat").attr('class','glyphicon glyphicon-eye-close');
              });
              
      $("body").on("click","#hide_indic_p_cat",function(){
                  SetCookie ("state_indic_p_categorie", 0);
                 $("#content_indic_p_cat").hide(200);
                 $("#hide_indic_p_cat").attr('class','btn btn-success');
                 $("#hide_indic_p_cat").attr('id','show_indic_p_cat');
                 $("#logo_indic_p_cat").attr('class','glyphicon glyphicon-eye-open');
              });

      $("body").on("click","#show_indic_p_cat",function(){
                  SetCookie ("state_indic_p_categorie", 1);
                 $("#content_indic_p_cat").show(200);
                 $("#show_indic_p_cat").attr('class','btn btn-danger');
                 $("#show_indic_p_cat").attr('id','hide_indic_p_cat');
                 $("#logo_indic_p_cat").attr('class','glyphicon glyphicon-eye-close');
              });
                
      $("body").on("click","#hide_lieux_p_cat",function(){
                 SetCookie ("state_lieu_p_categorie", 0);
                 $("#content_lieux_p_cat").hide(200);
                 $("#hide_lieux_p_cat").attr('class','btn btn-success');
                 $("#hide_lieux_p_cat").attr('id','show_lieux_p_cat');
                 $("#logo_lieux_p_cat").attr('class','glyphicon glyphicon-eye-open');
              });

      $("body").on("click","#show_lieux_p_cat",function(){
                  SetCookie ("state_lieu_p_categorie", 1);
                 $("#content_lieux_p_cat").show(200);
                 $("#show_lieux_p_cat").attr('class','btn btn-danger');
                 $("#show_lieux_p_cat").attr('id','hide_lieux_p_cat');
                 $("#logo_lieux_p_cat").attr('class','glyphicon glyphicon-eye-close');
              });

      $("body").on("click","#hide_membres_p_cat",function(){
                 SetCookie ("state_membre_p_categorie", 0);
                 $("#content_membres_p_cat").hide(200);
                 $("#hide_membres_p_cat").attr('class','btn btn-success');
                 $("#hide_membres_p_cat").attr('id','show_membres_p_cat');
                 $("#logo_membres_p_cat").attr('class','glyphicon glyphicon-eye-open');
              });

      $("body").on("click","#show_membres_p_cat",function(){
                  SetCookie ("state_membre_p_categorie", 1);
                 $("#content_membres_p_cat").show(200);
                 $("#show_membres_p_cat").attr('class','btn btn-danger');
                 $("#show_membres_p_cat").attr('id','hide_membres_p_cat');
                 $("#logo_membres_p_cat").attr('class','glyphicon glyphicon-eye-close');
              });

 });

function show_cat_assoc(){
    $("#basics_categorie").hide(200);
    $("#association_categorie").show(200);
    $("#terminer").show();

    $("#hidden_lieu").hide();
    $("#hidden_lieux_enr").hide();
    $("#hidden_outils").hide();

    if(GetCookie("state_outils_p_categorie") ==0){
        $("#content_outils_p_cat").hide();
        $("#hide_outils_p_cat").attr('class','btn btn-success');
        $("#hide_outils_p_cat").attr('id','show_outils_p_cat');
        $("#logo_outils_p_cat").attr('class','glyphicon glyphicon-eye-open');
      }
    else{
        $("#content_outils_p_cat").show(200);
        $("#show_outils_p_cat").attr('class','btn btn-danger');
        $("#show_outils_p_cat").attr('id','hide_outils_p_cat');
        $("#logo_outils_p_cat").attr('class','glyphicon glyphicon-eye-close');
    }

    if(GetCookie("state_lieu_p_categorie") ==0){
      $("#content_lieux_p_cat").hide();
      $("#hide_lieux_p_cat").attr('class','btn btn-success');
      $("#hide_lieux_p_cat").attr('id','show_lieux_p_cat');
      $("#logo_lieux_p_cat").attr('class','glyphicon glyphicon-eye-open');
     }
     else{
      $("#content_lieux_p_cat").show(200);
      $("#show_lieux_p_cat").attr('class','btn btn-danger');
      $("#show_lieux_p_cat").attr('id','hide_lieux_p_cat');
      $("#logo_lieux_p_cat").attr('class','glyphicon glyphicon-eye-close');
     }

     if(GetCookie("state_membre_p_categorie") ==0){
      $("#content_membres_p_cat").hide();
      $("#hide_membres_p_cat").attr('class','btn btn-success');
      $("#hide_membres_p_cat").attr('id','show_membres_p_cat');
      $("#logo_membres_p_cat").attr('class','glyphicon glyphicon-eye-open');
     }
     else{
      $("#content_membres_p_cat").show(200);
      $("#show_membres_p_cat").attr('class','btn btn-danger');
      $("#show_membres_p_cat").attr('id','hide_membres_p_cat');
      $("#logo_membres_p_cat").attr('class','glyphicon glyphicon-eye-close');
     }

     if(GetCookie("state_indic_p_categorie") ==0){
      $("#content_indic_p_cat").hide();
      $("#hide_indic_p_cat").attr('class','btn btn-success');
      $("#hide_indic_p_cat").attr('id','show_indic_p_cat');
      $("#logo_indic_p_cat").attr('class','glyphicon glyphicon-eye-open');
      }
    else{
      $("#content_indic_p_cat").show(200);
      $("#show_indic_p_cat").attr('class','btn btn-danger');
      $("#show_indic_p_cat").attr('id','hide_indic_p_cat');
      $("#logo_indic_p_cat").attr('class','glyphicon glyphicon-eye-close');
      }

      $("#alert_supp_gest_cat").hide(200);
      $("#fake_supp_gest_cat_hide").attr('id','fake_supp_gest_cat_show');
}

function show_hidden_lieu(){
  $('#shadow').toggle("fade");
  $("#hidden_lieu").show(200);
}

function hide_hidden_lieu(){
  $('#shadow').toggle("fade");
  $("#hidden_lieu").hide(200);
}

function show_hidden_indic(){
  $('#shadow').toggle("fade");
  $("#hidden_indics_enr").show(200);
}

function hide_hidden_indic(){
  $('#shadow').toggle("fade");
  $("#hidden_indics_enr").hide(200);
}

function show_hidden_lieu_enr(){
  $('#shadow').toggle("fade");
  $("#hidden_lieux_enr").show(200);
}

function hide_hidden_lieu_enr(){
  $('#shadow').toggle("fade");
  $("#hidden_lieux_enr").hide(200);
}

function show_hidden_outils(){
  $('#shadow').toggle("fade");
  $("#hidden_outils").show(200);
}

function hide_hidden_outils(){
  $('#shadow').toggle("fade");
  $("#hidden_outils").hide(200);
}

function show_hidden_membres_enr(){
  $('#shadow').toggle("fade");
  $("#hidden_membres_enr").show(200);
}

function hide_hidden_membres_enr(){
  $('#shadow').toggle("fade");
  $("#hidden_membres_enr").hide(200);
}

function show_hidden_membres(){
  $('#shadow').toggle("fade");
  $("#hidden_membres_cat").show(200);
}

function hide_hidden_membres(){
  $('#shadow').toggle("fade");
  $("#hidden_membres_cat").hide(200);
}