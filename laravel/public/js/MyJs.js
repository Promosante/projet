//fix display when sorting a table
function refresh_result(source_id,page_id,line_name,max_page,nb_el,nb_per_page){
  var obj;
  var stop=0;
  var source = document.getElementById(source_id);

  if(source.getAttribute('class')=='btn btn-default trick'){
      var objs=document.getElementsByClassName('trick');
      for(i=0;i<objs.length;i++){
        $(objs[i]).attr('class','btn btn-default trick' );
      }
      $(source).attr('class','btn btn-info trick' );
  }
  for(i=1;((i<max_page)&&(stop==0));i++){
    obj = document.getElementById(page_id+i);
    if(obj.getAttribute('class') == 'btn btn-info btn-sm'){
        stop=1;

        setTimeout(function() { 
          pagine_results(page_id,line_name,i-1,max_page,nb_el,nb_per_page);
        },100);
    }
  }
}



//fix display when paginate a table
function pagine_results(page_id,line_name,page_nb,max_page,nb_el,nb_per_page){

      $("#"+page_id+page_nb).attr('class','btn btn-info btn-sm');
      for(i=1;i<max_page;i++){
        if(i!==page_nb){
          $("#"+page_id+i).attr('class','btn btn-default btn-sm');
        }
      }
      var tab=document.getElementsByName(line_name);
      for(i=1;i<nb_el+1;i++){
        if((i<(page_nb-1)*nb_per_page+1)||(i>=page_nb*nb_per_page+1)){
          $(tab[i-1]).hide();

        }
        else{
           $(tab[i-1]).show();
        }
      }
}



function hilight_line(line_number,line_id,check_id,class_on_name,class_off_name){

  var obj = document.getElementById(line_id+line_number);
  var check = document.getElementById(check_id+line_number);

  if( obj.getAttribute('class') == class_on_name ){
      $(obj).attr('class',class_off_name );
      check.checked=false;
  }
  else{
     $(obj).attr('class',class_on_name);
     check.checked=true;
  }
    
}

function hilight_line_for_details(line_id,line_name,nb_el,class_on_name,class_off_name){

  var all_lines =document.getElementsByName(line_name);

  for(i=1;i<nb_el+1;i++){
      $("#d_"+i).hide(200);
      $(all_lines[i-1]).attr('class',class_off_name );
  }

  var obj = document.getElementById(line_id);
  $(obj).attr('class',class_on_name );

  var index = parseInt(line_id.substring(2,line_id.length));
  $("#d_"+index).show(200);
}


function toggle_perso(n){
    var obj = document.getElementById('lieu_container_'+n);
    var boutton = document.getElementById('hide_lieu_in_cat_view_'+n);
    var logo = document.getElementById('logo_lieux_in_cat_view_'+n);

    if( logo.getAttribute('class') == 'glyphicon glyphicon-eye-close' ){
      $(logo).attr('class','glyphicon glyphicon-eye-open' );
      $(boutton).attr('class','btn btn-success' );
      $(obj).hide(200);
      }
    else{
      $(logo).attr('class','glyphicon glyphicon-eye-close' );
      $(boutton).attr('class','btn btn-danger' );
      $(obj).show(200);
    }
}


$(document).ready(function(){
              //handler on click
              var col_g = document.getElementById("colonnegauche");
              var col_d = document.getElementById("colonnedroite");
              var h = Math.max( col_g.offsetHeight, col_d.offsetHeight );
              $(col_g).attr('style','height:'+h+'px');
              $(col_d).attr('style','height:'+h+'px');

             
              

              $("#details_lieu").hide();
              
              $("#shadow").css("height",$(document).height()).hide();

              $("body").on("click","#fake_supp_gest_cat_show",function(){
                  $("#alert_supp_gest_cat").show(200);
                  $("#fake_supp_gest_cat_show").attr('id','fake_supp_gest_cat_hide');
              });

              $("body").on("click","#fake_supp_gest_cat_hide",function(){
                  $("#alert_supp_gest_cat").hide(200);
                  $("#fake_supp_gest_cat_hide").attr('id','fake_supp_gest_cat_show');
              });
              $("body").on("click","#cancel_supp_gest_cat",function(){
                  $("#alert_supp_gest_cat").hide(200);
                  $("#fake_supp_gest_cat_hide").attr('id','fake_supp_gest_cat_show');
              });
              
              

              $("#simpleTable").stupidtable();

 });

function SetCookie (name, value) {
  var argv=SetCookie.arguments;
  var argc=SetCookie.arguments.length;
  var expires=(argc > 2) ? argv[2] : null;
  var path=(argc > 3) ? argv[3] : null;
  var domain=(argc > 4) ? argv[4] : null;
  var secure=(argc > 5) ? argv[5] : false;
  document.cookie=name+"="+escape(value)+
    ((expires==null) ? "" : ("; expires="+expires.toGMTString()))+
    ((path==null) ? "" : ("; path="+path))+
    ((domain==null) ? "" : ("; domain="+domain))+
    ((secure==true) ? "; secure" : "");
}

function GetCookie(name) {
  var arg=name+"=";
  var alen=arg.length;
  var clen=document.cookie.length;
  var i=0;
  while (i<clen) {
    var j=i+alen;
    if (document.cookie.substring(i, j)==arg)
                        return getCookieVal (j);
                i=document.cookie.indexOf(" ",i)+1;
                        if (i==0) break;}
  return null;
}

function getCookieVal(offset) {
  var endstr=document.cookie.indexOf (";", offset);
  if (endstr==-1)
          endstr=document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}