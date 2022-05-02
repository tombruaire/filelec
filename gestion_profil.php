<?php

if (isset($_SESSION['idclient'])) {

	$leClient = null;

	$unControleur->setTable("client");

	if (isset($_GET['action']) && isset($_GET['idclient'])) {
		$action = $_GET['action'];
		$idclient = $_GET['idclient'];
		$where = array("idclient"=>$idclient);
		switch ($action) {
			case 'edit':
				$leClient = $unControleur->selectWhere("*", $where);
				break;
		}
	}

	require_once("vue/profil.php");

	if (isset($_POST['Modifier'])) {
		$unControleur->setTable("client");
		$mdp = $_POST['mdp'];
		if ($mdp != "") {
			if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!&?;%:#+=<>*._-])[A-Za-z\d@$!&?;%:#+=<>*._-]{8,}$/", $mdp)) {
				$unControleur->setTable("histoClient");
				$where = array("mdp"=>sha1($mdp), "idclient"=>$_SESSION['idclient']);
				$unMdp = $unControleur->selectWhere("*", $where);
				if (!$unMdp) { // Si le mot de passe n'est pas identique à l'ancien.
					if (isset($_SESSION['type']) && $_SESSION['type'] == 'Particulier') {
						$tab = array(
							"nom"=>$_POST['nom'],
							"prenom"=>$_POST['prenom'],
							"tel"=>$_POST['tel'],
							"email"=>$_POST['email'],
							"mdp"=>$mdp,
							"adresse"=>$_POST['adresse'],
							"cp"=>$_POST['cp'],
							"ville"=>$_POST['ville'],
							"pays"=>$_POST['pays'],
							"etat"=>'Prospect',
							"role"=>'client',
							"bloque"=>0,
							"nbConnexion"=>0,
							"date_dernier_changement_mdp"=>date("Y-m-d H:i:s", strtotime("+2 hour"))
						);
						$unControleur->appelProc("updateParticulier", $tab);
					} else if (isset($_SESSION['type']) && $_SESSION['type'] == 'Professionnel') {
						$tab = array(
							"nom"=>$_POST['nom'],
							"tel"=>$_POST['tel'],
							"email"=>$_POST['email'],
							"mdp"=>$mdp,
							"adresse"=>$_POST['adresse'],
							"cp"=>$_POST['cp'],
							"ville"=>$_POST['ville'],
							"pays"=>$_POST['pays'],
							"statut"=>$_POST['statut'],
							"etat"=>'Prospect',
							"role"=>'client',
							"bloque"=>0,
							"nbConnexion"=>0,
							"date_dernier_changement_mdp"=>date("Y-m-d H:i:s", strtotime("+2 hour"))
						);
						$unControleur->appelProc("updateProfessionnel", $tab);
					}
					echo '<script language="javascript">document.location.replace("deconnexion");</script>';
				} else {
					echo '<script language="javascript">alert("Le mot de passe ne peut pas être identique à l\'ancien.")</script>';
					echo '<script language="javascript">alert("Échec de la mise à jour du profil.")</script>';
					echo '<script language="javascript">alert("Veuillez recommencer.")</script>';
				}
			} else {
				echo '<script language="javascript">alert("Votre mot de passe doit contenir au moins 1 lettre majuscule, 1 lettre minuscule, 1 chiffre, 1 caractère spécial (@$!&?;%:#+=<>*._-) et 8 caractères minimum.")</script>';
				echo '<script language="javascript">alert("Échec de la mise à jour du profil.")</script>';
				echo '<script language="javascript">alert("Veuillez recommencer.")</script>';
			}
		} else {
			echo '<script language="javascript">alert("Vous devez saisir un nouveau mot de passe.")</script>';
			echo '<script language="javascript">alert("Échec de la mise à jour du profil.")</script>';
				echo '<script language="javascript">alert("Veuillez recommencer.")</script>';
		}
	}

	if (isset($_POST['Supprimer'])) {
		$unControleur->setTable("client");
		$email = $_POST['email'];
		$mdp = sha1($_POST['mdp']);
		$where = array("email"=>$email, "mdp"=>$mdp);
		$unClient = $unControleur->selectWhere("email, mdp", $where);
		if ($unClient) {
			$tab = array("email"=>$email);
			if (isset($_SESSION['type']) && $_SESSION['type'] == 'Particulier') {
				$unControleur->appelProc("deleteParticulier", $tab);
			} else if (isset($_SESSION['type']) && $_SESSION['type'] == 'Professionnel') {
				$unControleur->appelProc("deleteProfessionnel", $tab);
			}
			echo '<script language="javascript">document.location.replace("deconnexion");</script>';
		}
	}

} else {
	header('Location: /filelec/');
}

?>