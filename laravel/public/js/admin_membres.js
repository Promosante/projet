function init_admin(){
	$("#simpleTable").stupidtable();
	$("#tri_structure").hide(); 
	$(".ligne_structure").hide();

}


function control_structure(check_id,btn_tri_id,ligne_class){

	var obj = document.getElementById(check_id);
	if(obj.checked){
    	$("#"+btn_tri_id).show(200);
    	$("."+ligne_class).show(200);
    }
    else{
    	$("#"+btn_tri_id).hide(200);
    	$("."+ligne_class).hide(200);
    }
}

