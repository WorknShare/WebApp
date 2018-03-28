function addEquipment(){
  var value, array, newRow, newCell, text, length, id, content;
  id = $('#equipment').val();
  content = $('#equipment option:selected').text();
  value = $( 'input[value="'+id+'"]' );
  if(value.length > 0){
    alert("vous avez déja ajouté cet équipement !");
    return;
  }

  $("<input type='hidden'/>")
    .attr("value", id)
    .attr("name", "equipments[]")
    .appendTo("#orderForm");

  array = $('#arrayEquipment')[0];

  length = array.rows.length;
  if( length == 1) $('#empty').html('');

  newRow = array.insertRow(length);

  newCell = newRow.insertCell(0);
  text = document.createTextNode(content);
  newCell.appendChild(text);

  content = $('#type option:selected').text();
  newCell = newRow.insertCell(1);
  text = document.createTextNode(content);
  newCell.appendChild(text);

  content = $('#equipment option:selected').text();
  newCell = newRow.insertCell(2);
  newCell.innerHTML = '<a class="text-danger point-cursor" onclick="deleteEquipment(this, '+ id +')"><i class="fa fa-trash"></i></a>';

}

function deleteEquipment(input, id) {
  var value, array, parent;

  value = $( 'input[value="'+id+'"]' );

  if(value.length != 1){
    alert("il y a eu une erreur!");
    return;
  }
  value.remove();

  parent = input.parentNode.parentNode;
  parent.parentNode.removeChild(parent);

  array = $('#arrayEquipment')[0];
  if(array.rows.length == 1) $('#empty').html('<center> Aucun équipement n\'a été ajouté.</center>');
}
