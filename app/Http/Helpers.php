<?php

function backoffice_role($rank) {
	switch($rank) {
		case 1:
			return "Administrateur";
		case 2:
			return "Gestionnaire";
		case 3:
			return "Manager";
		default:
			return "Default role";
	}
}

function iCheckScript() {
	return "<script>
	$(function () {
	    $('input').iCheck({
	      checkboxClass: 'icheckbox_square-blue icheckbox_margin',
	      radioClass: 'iradio_square-blue',
	      increaseArea: '20%'
	  });
	});
	</script>";
}