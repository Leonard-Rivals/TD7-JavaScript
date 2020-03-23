<?php
require_once('Model.php');
//Requete avec un id renvoie l'id correspondant
if(isset($_GET['idAdherent'])){
	$tab_adherent = Model::selectAdherent($_GET['idAdherent']);
	echo json_encode($tab_adherent);
}
//Requete sans id renvoie tous les adherents
else{
	$tab_adherent = Model::getAllAdherents();
	echo json_encode($tab_adherent);
}
