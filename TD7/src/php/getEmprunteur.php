<?php
require_once('Model.php');
	$tab_adherent = Model::getEmprunteur($_GET['id']);
	echo json_encode($tab_adherent);
