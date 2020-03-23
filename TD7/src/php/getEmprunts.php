<?php
require_once('Model.php');
	$tab_livres = Model::getLivresEmprunte($_GET['id']);
	echo json_encode($tab_livres);
