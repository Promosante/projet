$(function() {
    $( "#slider" ).slider({
      range: true,
      values:[1,31],
      min: 1,
      max: 31, 
      step: 1,
      slide: function( event, ui ) {

        var str= 'Période du ' + ui.values[ 0 ] +' au '+ ui.values[ 1 ];

        $("#periode" ).val( str );
      } 
    });
    
    var str = 'Période du ' + $( "#slider" ).slider( "values", 0 ) +' au '+ $( "#slider" ).slider( "values", 1 );
    $( "#periode" ).val( str );

  });

 
function show_details(id_div,id_barre){

hide_details();
  $("#"+id_div).show(200);
$("#"+id_barre).css('background-color','#8ACFFF');
  
}
 

function show_periode_details(id_div,id_bar,id_act_bar){
  hide_periode_details();
  $("#"+id_div).show(200);
  $("#"+id_bar).css('background-color','#8ACFFF');
  $("#"+id_act_bar).css('background-color','#8ACFFF');

}

function hide_details(){
  $(".barres0").css('background-color','#e0e0e0');
  $(".barres1").css('background-color','#5cb85c');
  $(".details").hide();
}

function  hide_periode_details(id_act_bar){
  $(".barres0").css('background-color','#e0e0e0');
  $(".barres1").css('background-color','#5cb85c');
  $("#"+id_act_bar).css('background-color','#8ACFFF');
  $(".details_periodes").hide();
}