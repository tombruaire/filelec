<?php

$unControleur->setTable("type");
$lesTypes = $unControleur->selectAll("*");

$produitsParPage = 8;

$produitsTotales = $unControleur->getIdProduit();

$pagesTotales = ceil($produitsTotales / $produitsParPage);

if (isset($_GET['p']) and !empty($_GET['p']) and $_GET['p'] > 0) {
	$_GET['p'] = intval($_GET['p']);
	$pageCourante = $_GET['p'];
} else {
	$pageCourante = 1;
}

$pagePrecedente = $pageCourante - 1;

$pageSuivante = $pageCourante + 1;

$depart = ($pageCourante-1) * $produitsParPage;

$unControleur->setTable("produit");

if (isset($_POST['Rechercher'])) {
	$mot = $_POST['mot'];
	$tab = array("nomproduit", "prixproduit");
	$lesProduits = $unControleur->selectSearch($mot, $tab);
	if (!$lesProduits) {
		$erreur = "Aucun résultat";
		if (isset($_POST['Refesh'])) {
			header('Location: produits');
		}
	}
} else {
	$lesProduits = $unControleur->selectAllProduits($depart, $produitsParPage);
}

if (isset($_POST['Valider'])) {
	$idtype = $_POST['idtype'];
	$tab = array("idtype");
	$lesProduits = $unControleur->selectSearch($idtype, $tab);
}

require_once("vue/produits.php");

?>