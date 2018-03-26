function addEquipment(id){
  var value, array, newRow, newCell, text, length;

  value = $( 'input[value="'+id+'"]' );
  if(value.length > 0){
    alert("vous avez déja ajouté cet équipement !");
    return;
  }

  $("<input type='hidden'/>")
    .attr("value", id)
    .attr("name", "equipment[]")
    .appendTo("#orderForm");

  array = $('#arrayEquipment')[0];

  length = array.rows.length;
  if( length == 1) $('#empty').html('');

  newRow = array.insertRow(length);


  newCell = newRow.insertCell(0);
  text = document.createTextNode('nom du l\'équipement');
  newCell.appendChild(text);

  newCell = newRow.insertCell(1);
  text = document.createTextNode('nom du type');
  newCell.appendChild(text);

  newCell = newRow.insertCell(2);
  newCell.innerHTML = '<a class="text-danger point-cursor" onclick="deleteEquipment('+ id +', '+ (length) +')"><i class="fa fa-trash"></i></a>';

}

function deleteEquipment(id, indexRow) {
  var value, array;

  value = $( 'input[value="'+id+'"]' );
  if(value.length != 1){
    alert("il y a eu une erreur!");
    return;
  }
  value.remove();

  array = $('#arrayEquipment')[0];
  array.deleteRow(indexRow);

  if(array.rows.length == 1) $('#empty').html('<center> Aucun équipement n\'a été ajouté.</center>');
}
