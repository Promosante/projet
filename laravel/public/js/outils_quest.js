
function add_question(){
  var obj = document.getElementById('question_container');
  var n = obj.childNodes.length;

  $(obj).append('{{Form::label("nom_supp","Nom de la catégorie (exact)",["class"=>"form-label"])}}',null);
}
 

 //{{Form::text('question_".n"', 'Question ".n"' ,['class'=>'form-control'])}}
