<?php error_reporting(0);

$unControleur->setTable("mesQuestions");
$lesQuestions = $unControleur->selectAll("*");

$unControleur->setTable("client");
if (isset($_POST['Valider'])) {
	$email = $_POST['email'];
	if ($email != "") {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$unClient = $unControleur->verifEmail($email);
			if (isset($unClient['email'])) {
				if ($unClient['bloque'] == 0) {
					$unControleur->setTable("mesQuestions");
					$enonce = $_POST['enonce'];
					$reponse = $_POST['reponse'];
					if ($reponse != "") {
						$where = array("enonce"=>$enonce, "reponse"=>$reponse, "email"=>$email);
						$reponseCorrect = $unControleur->selectWhere("*", $where);
						if ($reponseCorrect['reponse'] == $reponse) {
							$unControleur->setTable("client");
							$mdp = $_POST['mdp'];
							$mdp2 = $_POST['mdp2'];
							if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!&?;%:#+=<>*._-])[A-Za-z\d@$!&?;%:#+=<>*._-]{8,}$/", $mdp)) {
								if ($mdp == $mdp2) {
									$where = array("email"=>$email);
									$tab = array(
										"mdp"=>sha1($mdp),
										"date_dernier_changement_mdp"=>date("Y-m-d H:i:s", strtotime("+2 hour"))
									);
									$unControleur->update($tab, $where);
									echo "<script>alert('Votre mot de passe a bien été modifié ! Veuillez vous reconnecter.');window.location.href='/filelec/connexion';</script>";
								} else {
									$erreur = "Les mots de passe ne correspondent pas.";
								}
							} else {
								$erreur = "Votre mot de passe doit contenir au moins 1 lettre majuscule, 1 lettre minuscule, 1 chiffre, 1 caractère spécial (@$!&?;%:#+=<>*._-) et 8 caractères minimum.";
							}
						} else {
							$erreur = "Mauvaise réponse ou adresse email incorrecte.";
						}
					} else {
						$erreur = "Veuillez saisir une réponse.";
					}
				} else {
					$erreur = "Votre compte est bloqué.";
				}
			} else {
				$erreur = "Veuillez vérifier votre adresse email.";
			}
		} else {
			$erreur = "Format de l'adresse email invalide !";
		}
	} else {
		$erreur = "Veuillez saisir votre adresse email.";
	}
}

require_once("vue/recuperation-mdp.php");

?>