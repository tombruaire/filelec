<?php

$dateAlert = date("Y-m-d H:i:s", strtotime("-3 month")); // Date actuel moins 3 mois
$dateLimite = date("Y-m-d H:i:s", strtotime("-3 month -4 day")); // Date actuel moins 3 mois moins 4 jours

if (isset($_POST['Connexion'])) {
	$unControleur->setTable("client"); // Séléction de la table 'client'
	$email = $_POST['email'];
	$mdp = sha1($_POST['mdp']);
	if ($email != "") { // Si le champ (input) de l'email n'est va vide
		if ($mdp != "") { // Si le champ (input) du mot de passe n'est pas vide

			// Vérification de l'adresse email saisie par le client
			$where = array("email"=>$email);
			$unClient = $unControleur->selectWhere("*", $where);
			
			if (!$unClient) { // Si l'adresse email saisie ne se trouve pas dans la base de données
				$erreur = "Adresse email incorrecte !";
			} else if ($unClient['bloque'] == 1) { // Le compte du client est bloqué (1)
				$erreur = "Suite à de nombreuses tentatives infructueuses, votre compte a été bloqué.";
			} else if ($unClient['mdp'] == $mdp) { // Si le le mdp du client est correcte
				
				// Vérification du compte du client
				if ($unClient['bloque'] == 0) { // Si compte du client n'est pas bloqué (0)

					// Remise à 0 du nombre de tentatives infructueuses (en fonction de l'id du client)
					$where2 = array("idclient"=>$unClient['idclient']); // (en fonction de l'id du client)
					$tab = array("nbTentatives"=>0);
					$unControleur->update($tab, $where2);

	            	// Changement du mot de passe au bout de 3 mois (expiration du mot de passe)
	            	if ($unClient['date_dernier_changement_mdp'] < $dateAlert) { // Si la date du dernier changement du mot de passe est inférieure (<) à la date actuel : moins 3 mois

	            		if ($unClient['date_dernier_changement_mdp'] > $dateLimite) {
		            		echo '<script language="javascript">alert("Vous devez changer de mot de passe.")</script>';
		            	}

	            		// SI LA DATE DU DERNIER CHANGEMENT MDP EST INFÉRIEUR À LA DATE DU JOUR MOINS 3 MOIS

	            		$unControleur->setTable("vclient");
            			$_SESSION['idclient'] = $unClient['idclient'];
						$_SESSION['nom'] = $unClient['nom'];
						$_SESSION['email'] = $unClient['email'];
						$_SESSION['tel'] = $unClient['tel'];
						$_SESSION['adresse'] = $unClient['adresse'];
						$_SESSION['cp'] = $unClient['cp'];
						$_SESSION['ville'] = $unClient['ville'];
						$_SESSION['pays'] = $unClient['pays'];
						$_SESSION['role'] = $unClient['role'];
						$_SESSION['type'] = $unClient['type'];
						$_SESSION['date_creation_mdp'] = $unClient['date_creation_mdp'];
						$_SESSION['date_dernier_changement_mdp'] = $unClient['date_dernier_changement_mdp'];
						$_SESSION['date_creation_compte'] = $unClient['date_creation_compte'];
						// Si le client est un Particulier, on initialise son 'prénom'
						if ($unClient['type'] == 'Particulier') {
							$unControleur->setTable("particulier");
							$where = array("email"=>$email);
							$unParticulier = $unControleur->selectWhere("*", $where);
							$_SESSION['prenom'] = $unParticulier['prenom'];
						}
						// Si le client est Professionnel, on initialise son 'statut'
						if ($unClient['type'] == 'Professionnel') {
							$unControleur->setTable("professionnel");
							$where = array("email"=>$email);
							$unProfessionnel = $unControleur->selectWhere("*", $where);
							$_SESSION['statut'] = $unProfessionnel['statut'];
						}

	            		// Vérifier si le client a changer son mot de passe avant les 4 jours de délais (maximum).
	            		if ($unClient['date_dernier_changement_mdp'] < $dateLimite) { // Si la date du dernier changement du mot de passe est inférieure à la date actuel : moins 3 mois et moins 4 jours (4 jours après la première alerte (premier if()))
	            			
	            			// Génération d'un nouveau mot de passe via une fonction (function)
	            			$newmdp = $unControleur->generateMdp();

	            			// Changement du mot de passe du client (en fonction de son id)
	            			$unControleur->setTable("client");
	            			$tab = array(
	            				"mdp"=>sha1($newmdp),
	            				"date_dernier_changement_mdp"=>date("Y-m-d H:i:s", strtotime("+2 hour"))
	            			);
	            			$where = array("idclient"=>$unClient['idclient']); // (en fonction de son id)
	            			$unControleur->update($tab, $where);

	            			// Envoi du nouveau mot de passe au client (email)
	            			$header = "MIME-Version: 1.0\r\n";
							$header .= 'From: "Filelec"<EMAIL_DU_COMPTE_NON_SECURISE>'."\n"; // Voir dossier 'sendmail'
							$header .= 'Content-Type:text/html; charset=utf-8"'."\n";
							$header .= 'Content-Transfer-Encoding: 8bit';

							$email = $unClient['email'];

							$newmdp = $newmdp;

							$message = '
<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<body>
<div role="article" aria-roledescription="email" aria-label="Verify Email Address" lang="en">
    <table style="font-family: Montserrat, -apple-system, "Segoe UI", sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="--bg-opacity: 1; font-family: Montserrat, -apple-system, "Segoe UI", sans-serif;">
                <table class="sm-w-full" style="font-family: "Montserrat", Arial, sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td align="center" class="sm-px-24" style="font-family: "Montserrat", Arial, sans-serif;">
                            <table style="font-family: "Montserrat", Arial, sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="sm-px-24" style="--bg-opacity: 1; background-color: rgb(24, 26, 27); font-family: Montserrat, -apple-system, "Segoe UI", sans-serif; font-size: 14px; line-height: 24px; padding: 48px; text-align: left; --text-opacity: 1; color: #626262; color: rgba(98, 98, 98, var(--text-opacity));" bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                                        <p style="font-weight: 600; font-size: 18pt; margin-bottom: 0; color: #f8f9fa!important; text-align: center;">
                                        	<style type="text/css">.ii a[href] {color: aqua!important;}</style>
                                            Bonjour, 
                                        </p>
                                        <p class="sm-leading-32" style="font-weight: 600; font-size: 20px; margin: 0 0 16px; --text-opacity: 1; color: #263238; margin-top: 5%; color: #f8f9fa!important; text-align: center;">
                                            Voici votre nouveau mot de passe : '.$newmdp.'
                                        </p><br>
                                        <table style="font-family: "Montserrat",Arial,sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td style="font-family: "Montserrat",Arial,sans-serif; padding-top: 32px; padding-bottom: 32px;">
                                                    <div style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); height: 1px; line-height: 1px;"></div>
                                                </td>
                                            </tr>
                                        </table>
                                        <p style="margin: 0 0 16px; text-align: center; color: #f8f9fa!important;">
                                            Ceci est un mail automatique, merci de ne pas répondre.
                                        </p>
                                    </td>
                                </tr>
                            <tr>
                            <td style="font-family: "Montserrat",Arial,sans-serif; height: 20px;" height="20"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</div>
</body>
</html>
';
							
							// Envoi de l'email à l'adresse saisie (se trouvant dans la base de données)
							mail($email, "Nouveau mot de passe", $message, $header);

							// Affichage d'une alerte JavaScript disant que le mot de passe du client a été modifié
							echo '<script language="javascript">alert("Votre mot de passe a été modifié. Veuillez consulter votre boîte de réception.")</script>';
							
							// Fermeture de la session du client (id doit se reconnecter avec le nouveau mot de passe généré)
							unset($_SESSION);
        					session_destroy();
	            		} else {
	            			echo '<script language="javascript">document.location.replace("/filelec/");</script>';
	            		}
	            	} // Fin 1er if : changement mdp
	            	else { // SI ON OBTIENT LA CONNEXION (identifiants et date_dernier_changement_mdp corrects)

	            		// Remise à 0 du nombre de tentatives du client
	            		$unControleur->setTable("client");
	            		$tab = array("nbTentatives"=>0);
	            		$where = array("idclient"=>$unClient['idclient']);
						$unControleur->update($tab, $where);

	            		// Changement du mot de passe du client après un nombre de connexion

	            		// 1) Ajout de 1 au compteur de connexion (à chaque connexion)
	            		$unControleur->setTable("client");
	            		$tab = array("nbConnexion"=>($unClient['nbConnexion']+1));
	            		$where = array("idclient"=>$unClient['idclient']);
	            		$unControleur->update($tab, $where);

	            		// 2) Vérification du nombre de connexion du client
	            		if ($unClient['nbConnexion'] + 1 > 50) { // Si le nombre de connexion est supérieur à 50
	            			
	            			// 3) Génération d'un nouveau mot de passe
	            			$newmdp = $unControleur->generateMdp();

	            			// 4) Remise à 0 du nombre de connexion et changement du mot de passe
	            			$unControleur->setTable("client");
	            			$tab = array(
								"nbConnexion"=>0,
								"mdp"=>sha1($newmdp),
								"date_dernier_changement_mdp"=>date("Y-m-d H:i:s", strtotime("+2 hour"))
							);
							$where = array("idclient"=>$unClient['idclient']);
							$unControleur->update($tab, $where);

							// 5.a) Envoi du nouveau mot de passe au client (email)
							$header = "MIME-Version: 1.0\r\n";
							$header .= 'From: "Filelec"<EMAIL_DU_COMPTE_NON_SECURISE>'."\n"; // Voir dossier 'sendmail'
							$header .= 'Content-Type:text/html; charset=utf-8"'."\n";
							$header .= 'Content-Transfer-Encoding: 8bit';

							$email = $unClient['email'];

							$newmdp = $newmdp;

							$message = '
<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<body>
<div role="article" aria-roledescription="email" aria-label="Verify Email Address" lang="en">
    <table style="font-family: Montserrat, -apple-system, "Segoe UI", sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="--bg-opacity: 1; font-family: Montserrat, -apple-system, "Segoe UI", sans-serif;">
                <table class="sm-w-full" style="font-family: "Montserrat", Arial, sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td align="center" class="sm-px-24" style="font-family: "Montserrat", Arial, sans-serif;">
                            <table style="font-family: "Montserrat", Arial, sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="sm-px-24" style="--bg-opacity: 1; background-color: rgb(24, 26, 27); font-family: Montserrat, -apple-system, "Segoe UI", sans-serif; font-size: 14px; line-height: 24px; padding: 48px; text-align: left; --text-opacity: 1; color: #626262; color: rgba(98, 98, 98, var(--text-opacity));" bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                                        <p style="font-weight: 600; font-size: 18pt; margin-bottom: 0; color: #f8f9fa!important; text-align: center;">
                                        	<style type="text/css">.ii a[href] {color: aqua!important;}</style>
                                            Bonjour, 
                                        </p>
                                        <p class="sm-leading-32" style="font-weight: 600; font-size: 20px; margin: 0 0 16px; --text-opacity: 1; color: #263238; margin-top: 5%; color: #f8f9fa!important; text-align: center;">
                                            Voici votre nouveau mot de passe : '.$newmdp.'
                                        </p><br>
                                        <table style="font-family: "Montserrat",Arial,sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td style="font-family: "Montserrat",Arial,sans-serif; padding-top: 32px; padding-bottom: 32px;">
                                                    <div style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); height: 1px; line-height: 1px;"></div>
                                                </td>
                                            </tr>
                                        </table>
                                        <p style="margin: 0 0 16px; text-align: center; color: #f8f9fa!important;">
                                            Ceci est un mail automatique, merci de ne pas répondre.
                                        </p>
                                    </td>
                                </tr>
                            <tr>
                            <td style="font-family: "Montserrat",Arial,sans-serif; height: 20px;" height="20"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
</div>
</body>
</html>
';

	        				// 5.b)Envoi de l'email à l'adresse saisie (se trouvant dans la base de données)
							mail($email, "Nouveau mot de passe", $message, $header);

							// 6) Affichage d'un message d'alerte disant que le mot de passe du client a été modifié
							// echo '<script language="javascript">alert("Suite à de nombreuses connexion, votre mot de passe a été modifié. Veuillez consulter votre boîte de réception.")</script>';
							$erreur = "Suite à de nombreuses connexion, votre mot de passe a été modifié. Veuillez consulter votre boîte de réception.";
							
							// 7) Fermeture de la session du client (id doit se reconnecter avec le nouveau mot de passe généré)
							unset($_SESSION);
        					session_destroy();
	            		} else { 
	            		// SI LA DATE DU DERNIER CHANGEMENT MDP N'EST PAS INFÉRIEUR À LA DATE DU JOUR MOINS 3 MOIS
	            			
	            			$unControleur->setTable("vclient");
	            			// Initialisation des informations du client
	            			$_SESSION['idclient'] = $unClient['idclient'];
							$_SESSION['nom'] = $unClient['nom'];
							$_SESSION['email'] = $unClient['email'];
							$_SESSION['tel'] = $unClient['tel'];
							$_SESSION['adresse'] = $unClient['adresse'];
							$_SESSION['cp'] = $unClient['cp'];
							$_SESSION['ville'] = $unClient['ville'];
							$_SESSION['pays'] = $unClient['pays'];
							$_SESSION['role'] = $unClient['role'];
							$_SESSION['type'] = $unClient['type'];
							$_SESSION['date_creation_mdp'] = $unClient['date_creation_mdp'];
							$_SESSION['date_dernier_changement_mdp'] = $unClient['date_dernier_changement_mdp'];
							$_SESSION['date_creation_compte'] = $unClient['date_creation_compte'];
							// Si le client est un Particulier, on initialise son 'prénom'
							if ($unClient['type'] == 'Particulier') {
								$unControleur->setTable("particulier");
								$where = array("email"=>$email);
								$unParticulier = $unControleur->selectWhere("*", $where);
								$_SESSION['prenom'] = $unParticulier['prenom'];
							}
							// Si le client est Professionnel, on initialise son 'statut'
							if ($unClient['type'] == 'Professionnel') {
								$unControleur->setTable("professionnel");
								$where = array("email"=>$email);
								$unProfessionnel = $unControleur->selectWhere("*", $where);
								$_SESSION['statut'] = $unProfessionnel['statut'];
							}

	            			echo '<script language="javascript">document.location.replace("/filelec/");</script>';
	            		}
	            	} // Fin : SI ON OBTIENT LA CONNEXION (identifiants et date_dernier_changement_mdp corrects)
	            } else {
					$erreur = "Votre compte est bloqué.";
				}
	        } else {
	        	$erreur = "Veuillez vérifier vos identifiants !";
	        	// Nombre de tentatives
				$unControleur->setTable("client");
				$where = array("idclient"=>$unClient['idclient']);
				$tab = array("nbTentatives"=>($unClient['nbTentatives']+1));
				$unControleur->update($tab, $where);
				if ($unClient['nbTentatives'] + 1 > 5) { // Si le nombre de tentatives est supérieur à 5, on bloque le compte du client

					// On remet le nombre de tentatives à 0
					$unControleur->setTable("client");
					$tab = array("nbTentatives"=>0);
					$unControleur->update($tab, $where);

					// On bloque le compte du client
					$unControleur->setTable("client");
					$tab = array("bloque"=>1);
					$where = array("idclient"=>$unClient['idclient']);
					$unControleur->update($tab, $where);

				}
	        }
	    } else {
			$erreur = "Veuillez saisir votre mot de passe.";
		}
	} else {
		$erreur = "Veuillez saisir votre adresse email.";
	}
}








	            	

require_once("vue/connexion.php");

?>
