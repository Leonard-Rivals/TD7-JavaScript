<?php
require_once('Model.php');
	$tab_livres = Model::getAllLivrePris();
	echo json_encode($tab_livres);
