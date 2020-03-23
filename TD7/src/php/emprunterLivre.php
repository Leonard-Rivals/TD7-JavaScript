<?php
require_once('Model.php');

if(isset($_GET['idLivre']) && isset($_GET['idAdherent'])){
	Model::emprunterLivre($_GET['idLivre'], $_GET['idAdherent']);
}
				
