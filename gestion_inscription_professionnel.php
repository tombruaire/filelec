<?php

if (isset($_SESSION['idclient'])) {
    header('Location: /filelec/');
    exit();
}

$unControleur->setTable("question");
$lesQuestions = $unControleur->selectAll("*");

if (isset($_POST['InscriptionProfessionnel'])) {
	$unControleur->setTable("professionnel");
	$nom = $_POST['nom'];
	$tel = $_POST['tel'];
	$email = $_POST['email'];
	$mdp = $_POST['mdp'];
	$mdp2 = $_POST['mdp2'];
	$adresse = $_POST['adresse'];
	$cp = $_POST['cp'];
	$ville = $_POST['ville'];
	$pays = $_POST['pays'];
	$statut = $_POST['statut'];
	$enonce = $_POST['enonce'];
	$reponse = $_POST['reponse'];
	if ($nom != "") {
		if (preg_match("#^[A-Z][a-zA-Z]{1,50}$#", $nom)) {
			$telLength = strlen($tel);
			if ($telLength == 10) {
				$unControleur->setTable("client");
				$where = array("tel"=>$tel);
				$checkTelClient = $unControleur->selectWhere("tel", $where);
				if (!$checkTelClient) {
					$unControleur->setTable("professionnel");
					$where1 = array("tel"=>$tel);
					$checkTelProfessionnel = $unControleur->selectWhere("tel", $where1);
					if (!$checkTelProfessionnel) {
						if ($email != "") {
							if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
								if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$#", $_POST['email'])) {
									$unControleur->setTable("client");
									$where2 = array("email"=>$email);
									$checkEmailClient = $unControleur->selectWhere("email", $where2);
									if (!$checkEmailClient) {
										$unControleur->setTable("professionnel");
										$where3 = array("email"=>$email);
										$checkEmailProfessionnel = $unControleur->selectWhere("email", $where2);
										if (!$checkEmailProfessionnel) {
											if ($mdp != "") {
												if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!&?;%:#+=<>*._-])[A-Za-z\d@$!&?;%:#+=<>*._-]{8,}$/", $mdp)) {
													if ($mdp == $mdp2) {
														if ($adresse != "") {
															if ($cp != "") {
																if (preg_match("#^[0-9]{5}|2[A-B][0-9]{3}$#", $cp)) {
																	if ($ville != "") {
																		if ($pays != "") {
																			if (preg_match("#^[a-zA-Z][a-zA-Z0-9-_\.]{1,50}$#", $pays)) {
																				if ($statut != "") {
																					if (preg_match("#^[a-zA-Z][a-zA-Z0-9-_\.]{1,50}$#", $statut)) {
																						$tab1 = array(
																							"nom"=>$nom,
																							"tel"=>$tel,
																							"email"=>$email,
																							"mdp"=>$mdp,
																							"adresse"=>$adresse,
																							"cp"=>$cp,
																							"ville"=>$ville,
																							"pays"=>$pays,
																							"numSIRET"=>'521 868 267 00014',
																							"statut"=>$statut,
																							"etat"=>'Prospect',
																							"role"=>'Client'
																						);
																						$unControleur->appelProc("insertProfessionnel", $tab1);
																						if ($reponse != "") {
																							$unControleur->setTable("reponse");
																							$tab2 = array(
																								"enonce"=>$enonce,
																								"reponse"=>$reponse,
																								"email"=>$email,
																								"mdp"=>$mdp
																							);
																							$unControleur->appelProc("insertReponse", $tab2);
																							echo '<script language="javascript">document.location.replace("connexion");</script>';
																							exit();
																						} else {
																							$erreur = "Veuillez saisir une réponse.";
																						}
																					} else {
																						$erreur = "Le statut ne doit pas dépasser 50 caractères !";
																					}
																				} else {
																					$erreur = "Veuillez saisir un statut.";
																				}
																			} else {
																				$erreur = "Le pays ne doit pas dépasser 50 caractères !";
																			}
																		} else {
																			$erreur = "Veuillez saisir un pays.";
																		}
																	} else {
																		$erreur = "Veuillez saisir une ville";
																	}
																} else {
																	$erreur = "Format du code postal invalide !";
																}
															} else {
																$erreur = "Veuillez saisir un code postal.";
															}
														} else {
															$erreur = "Veuillez saisir une adresse.";
														}
													} else {
														$erreur = "Les mots de passe ne correspondent pas !";
													}
												} else {
													$erreur = "Votre mot de passe doit contenir au moins 1 lettre majuscule, 1 lettre minuscule, 1 chiffre, 1 caractère spécial (@$!&?;%:#+=<>*._-) et 8 caractères minimum.";
												}
											} else {
												$erreur = "Veuillez saisir un mot de passe.";
											}
										} else {
											$erreur = "Adresse email déjà utilisé.";
										}
									} else {
										$erreur = "Adresse email déjà utilisé.";
									}
								} else {
									$erreur = "Format de l'adresse email invalide !";
								}
							} else {
								$erreur = "Format de l'adresse email invalide !";
							}
						} else {
							$erreur = "Veuillez saisir une adresse email.";
						}
					} else {
						$erreur = "Ce numéro de téléphone est déjà utilisé !";
					}
				} else {
					$erreur = "Ce numéro de téléphone est déjà utilisé !";
				}
			} else {
				$erreur = "Le numéro de téléphone doit contenir 10 chiffres !";
			}
		} else {
			$erreur = "Le nom ne doit dépasser 50 caractères !";
		}
	} else {
		$erreur = "Veuillez saisir un nom.";
	}
}

require_once("vue/inscription-professionnel.php");

?>
