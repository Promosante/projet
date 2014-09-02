

$(document).ready(function(){
	
	$(".groupe_propose").hide();
  $("#groupe_0").show();
  
	$("body").on("change","#groupe_affect",function(){
		
		$(".groupe_propose").hide();
	 	var index = document.getElementById('groupe_affect').selectedIndex;
	 	$("#groupe_"+index).show();
	});

	 $("body").on("click","#fake_gen",function(){
      $("#gen_compte_instruc").hide(200);
      $("#gen_compte_instruc").attr('id','gen_compte_instruc_h');
    });

    $("body").on("click","#fake_gen",function(){
      $("#gen_compte_instruc_h").show(200);
      $("#gen_compte_instruc_h").attr('id','gen_compte_instruc');
    });

    $("body").on("click","#cancel_gen",function(){
      $("#gen_compte_instruc").hide(200);
      $("#gen_compte_instruc").attr('id','gen_compte_instruc_h');
    });
	 

});



$(function(){
  $("#gen_compte_instruc").hide(200);
  $("#gen_compte_instruc").attr('id','gen_compte_instruc_h');
})