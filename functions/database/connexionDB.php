<?php
class ConnectDB {

    public $bdd;

	function __construct(){
	    try {
	        $this->bdd = new PDO('mysql:host=localhost;dbname=battlekart;charset=utf8', 'root', '');
	        $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
	    } catch (Exception $e) {
	        die('Erreur : ' . $e->getMessage());
	    }
	}
}
?>
