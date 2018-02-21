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