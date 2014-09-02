$(document).ready(function(){
     
    $("body").on("click","#check_tout_le_projo",function(){
        	var allcheck = document.getElementsByClassName("check_control");
        	for(i=0;i<allcheck.length;i++){
        		allcheck[i].checked=false; 
        	}
        	var check = document.getElementById("check_tout_le_projo");
        	check.checked=true; 
    });
    $("body").on("click","#check_categories",function(){
        	var allcheck = document.getElementsByClassName("check_control");
        	for(i=0;i<allcheck.length;i++){
        		allcheck[i].checked=false; 
        	}
        	var check = document.getElementById("check_categories");
        	check.checked=true; 
    });
    $("body").on("click","#check_activites",function(){
        	var allcheck = document.getElementsByClassName("check_control");
        	for(i=0;i<allcheck.length;i++){
        		allcheck[i].checked=false; 
        	}
        	var check = document.getElementById("check_activites");
        	check.checked=true; 
    });



    $("body").on("click","#check_duree_projo",function(){
            var allcheck = document.getElementsByClassName("check_control2");
            for(i=0;i<allcheck.length;i++){
                allcheck[i].checked=false; 
            }
            var check = document.getElementById("check_duree_projo");
            check.checked=true; 
    });
    $("body").on("click","#check_periode",function(){
            var allcheck = document.getElementsByClassName("check_control2");
            for(i=0;i<allcheck.length;i++){
                allcheck[i].checked=false; 
            }
            var check = document.getElementById("check_periode");
            check.checked=true; 
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