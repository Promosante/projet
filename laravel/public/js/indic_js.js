

function init_indic(){
	$("#hidden_outils_stuff").hide();
	$("#outils_container").hide();
	$("#new_indic_container").show();
}

function show_indic_assos(){
	$("#hidden_outils_stuff").hide();
	$("#outils_container").show();
	$("#new_indic_container").hide();
}

$(document).ready(function(){
	$("#shadow").css("height",$(document).height()).hide();
});

function toggle_slide(){
	$('#shadow').toggle("fade");
	$("#hidden_outils_stuff").show(200);
}

function ok_unlight_this(){
	$('#shadow').toggle("fade");
	$("#hidden_outils_stuff").hide(200);
}