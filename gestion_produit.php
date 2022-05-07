<?php error_reporting(0);

$unControleur->setTable("produit");

$produitView = 0;

if (isset($_GET['view'])) {
	$unControleur->setTable("produit");
	$produitView = 1;
	$idproduit = $_GET['view'];
	$where1 = array("idproduit"=>$idproduit);
	$leProduit = $unControleur->selectWhere("*", $where1);
	$unControleur->setTable("commentaire");
	$where2 = array("idproduit"=>$idproduit);
	$nbCommentaires = $unControleur->countWhere($where2);
	$unControleur->setTable("vcommentaire");
	$where3 = array("idproduit"=>$idproduit);
	$lesCommentaires = $unControleur->selectAllCommentaires($where3);

	$editCom = null;

	$unControleur->setTable("commentaire");
	if (isset($_GET['action']) && isset($_GET['idcom']) && isset($_GET['idproduit'])) {
		$action = $_GET['action'];
		$idcom = $_GET['idcom'];
		$idproduit2 = $_GET['idproduit'];
		switch ($action) {
			case 'delete': // SUPPRESSION DU COMMENTAIRE
				$where4 = array(
					"idcom"=>$idcom, 
					"idproduit"=>$idproduit2, 
					"idclient"=>$_SESSION['idclient'],
					"client_id"=>$_SESSION['idclient']
				);
				$unControleur->setTable("commentaire");
				$unControleur->delete($where4);
				$redirection = <<<EOT
				<script type='text/javascript'>window.location.replace("produit?view=$idproduit2");</script>
				EOT;
				echo($redirection);
				break;
			case 'edit': // ÉDITION DU COMMENTAIRE
				$where5 = array(
					"idcom"=>$idcom, 
					"idproduit"=>$idproduit2, 
					"idclient"=>$_SESSION['idclient']
				);
				$editCom = $unControleur->selectWhere("*", $where5);
				break;
		}
	}

	if (isset($_POST['Edit'])) {
		$unControleur->setTable("commentaire");
		$whereEdit = array(
			"idcom"=>$idcom, 
			"idproduit"=>$idproduit2, 
			"idclient"=>$_SESSION['idclient'],
			"client_id"=>$_SESSION['idclient'],
		);
		$tab = array(
			"contenu"=>$_POST['contenu'],
			"dateheurepost"=>date("Y-m-d H:i:s", strtotime("+1 hour"))
		);
		$unControleur->update($tab, $whereEdit);
		$redirection = <<<EOT
			<script type='text/javascript'>window.location.replace("produit?view=$idproduit2");</script>
		EOT;
		echo($redirection);
	}

	if (isset($_POST['Poster'])) {
		$unControleur->setTable("commentaire");
		$tab = array(
			"idproduit"=>$idproduit,
			"idclient"=>$_SESSION['idclient'],
			"contenu"=>$_POST['contenu'],
			"clien_id"=>$_SESSION['idclient'],
			"dateheurepost"=>date("Y-m-d H:i:s", strtotime("+1 hour"))
		);
		$unControleur->insert($tab);
		$redirection = <<<EOT
		<script type='text/javascript'>window.location.replace("produit?view=$idproduit");</script>
		EOT;
		echo($redirection);
	}

	$unControleur->setTable("commande");
	$unControleur->setTable("panier");
	if (isset($_POST['Ajouter'])) {
		$unControleur->setTable("panier");
		$where = array("idproduit"=>$_POST['idproduit'], "idclient"=>$_SESSION['idclient']);
		$leProduit = $unControleur->selectWhere("*", $where);
		if ($leProduit['idproduit'] != $_POST['idproduit']) {
			$tab = array(
				"idclient"=>$_SESSION['idclient'],
				"datelivraison"=>date("Y-m-d H:i:s", strtotime("+2 days")),
				"idproduit"=>$_POST['idproduit'],
				"quantite"=>$_POST['quantite']
			);
			$unControleur->appelProc("insertCommande", $tab);
			echo '<script language="javascript">document.location.replace("panier");</script>';
		} else {
			echo "<script>alert('Produit déjà dans le panier');window.location.href='/filelec/produits';</script>";
		}
	}

}

require_once("vue/produit.php");

?>
