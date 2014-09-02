function init_visu(){
	$(".periode_choix").hide();
    $(".evenements_choix").hide();
}

function show_periode(){
    $(".periode_choix").hide();
     $(".evenements_choix").hide();
    var index = document.getElementById('cr_act_sel').selectedIndex;   
    $("#cr_p_sel_"+index).show();
}

function show_evenements(i){
    $(".evenements_choix").hide();
    var index = document.getElementById('cr_p_sel_'+i).selectedIndex;   
    $("#cr_p_sel_"+i+"_"+index).show();
}
