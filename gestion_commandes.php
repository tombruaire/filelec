<?php error_reporting(0);

if (isset($_SESSION['idclient'])) {

	$unControleur->setTable("facture");
	$where = array("idclient"=>$_SESSION['idclient']);
	$leClient = $unControleur->selectWhere("*", $where);
	if ($leClient['idclient'] == $_SESSION['idclient']) {
		$unControleur->setTable("vfacture");
		$lesFactures = $unControleur->selectAll("*");
	}

	if (isset($_POST['Annuler'])) {
		$unControleur->setTable("facture");
		$where = array(
			"idclient"=>$_POST['idclient'],
			"idproduit"=>$_POST['idproduit'],
			"numcommande"=>$_POST['numcommande']
		);
		$unControleur->delete($where);
		echo '<script language="javascript">document.location.replace("commandes");</script>';
	}

	require_once("vue/commandes.php");

} else {
	header('Location: connexion');
}

?>
