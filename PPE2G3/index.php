<?php
session_start();
//include du fichier CONTROLEUR
include 'Controleur.php';
//SI le controleur n'existe pas déjà, on l'instancie
if (!isset ($_SESSION['Controleur']))
	{
	$monControleur = new Controleur();
	}

//affichage de l'entête
$monControleur->afficheEntete();
//affichage du menu
$monControleur->afficheMenu();
//SI on souhaite voir un vue particulière, on passe celle-ci en paramètre (elle est récupérée à travers la méthode GET)
if ((isset($_GET['vue']))&& (isset($_GET['action'])))
	$monControleur->affichePage($_GET['action'],$_GET['vue']);
//affichage du pied de page
$monControleur->affichePiedPage();
?>