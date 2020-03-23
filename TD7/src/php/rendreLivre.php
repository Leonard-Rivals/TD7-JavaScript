<?php
require_once('Model.php');

if(isset($_GET['id'])){
	Model::rendreLivre($_GET['id']);
}
				
