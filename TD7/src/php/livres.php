<?php
require_once('Model.php');
	$tab_livres = Model::getAllLivreDispo();
	echo json_encode($tab_livres);
}
