<?php
require_once('Model.php');
$types = array();
array_push($types, 'adherent');
array_push($types, 'livre');

if(isset($_GET['type']) && isset($_GET['nom'])){
	if(in_array($_GET['type'], $types)){
				Model::createSomething($_GET['type'],$_GET['nom']);
	}
}
