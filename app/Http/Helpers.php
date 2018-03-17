<?php

global $days;
$days = ['dates.days.monday', 'dates.days.tuesday', 'dates.days.wednesday', 'dates.days.thursday', 'dates.days.friday', 'dates.days.saturday', 'dates.days.sunday'];

function backoffice_role($rank) {
	switch($rank) {
		case 1:
			return "Administrateur";
		case 2:
			return "Gestionnaire";
		case 3:
			return "Responsable client";
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

function iCheckRadioScript() {
	return '<script>
		$(\'input[type="checkbox"].minimal, input[type="radio"].minimal\').iCheck({
	      checkboxClass: \'icheckbox_minimal-blue\',
	      radioClass   : \'iradio_minimal-blue\'
	    })
    </script>';
}

function getDay($index) {

	global $days;

	return Lang::get($days[$index]);
}

function planHasAdvantage($plan, $idAdvantage) {
	foreach ($plan->advantages as $advantage) {
		if($advantage->id_plan_advantage == $idAdvantage) return true;
	}
	return false;
}