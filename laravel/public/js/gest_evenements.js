
function init_evenement(){
	$(".lieux_propose").hide();
	$(".periodes_propose").hide();
	$(".interv_propose").hide();
	$(".groupe_propose").hide();
  	$(".sous_groupe_propose").hide();
}

$(document).ready(function(){


  	$("body").on("change","#groupe_affect",function(){
		$(".sous_groupe_propose").hide();
	 	var index = document.getElementById('groupe_affect').selectedIndex;
	 	$("#groupe_"+index).show();
	});

	 $("body").on("change","#act_sel",function(){

	 		$(".lieux_propose").hide();
	 		$(".periodes_propose").hide();
	 		$(".interv_propose").hide();

	 		var id = $("#act_sel").children("option").filter(":selected").text();
	 		$("#"+id+'P').show();
	 		$("#"+id+'L').show();
	 		$("#"+id+'I').show();
	 		$("#groupe_affect").show();
	 		var index = document.getElementById('groupe_affect').selectedIndex;
	 		$("#groupe_"+index).show();
	 }); 

});
