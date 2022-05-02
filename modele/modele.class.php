<?php

class Modele {

	private $pdo;
	private $uneTable;

	public function __construct($hostname, $database, $username, $password) {
		$this->pdo = null;
		try {
			$this->pdo = new PDO("mysql:host=".$hostname.";dbname=".$database.";charset=utf8", $username, $password);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		} catch (PDOException $e) {
			die("Erreur de connexion à la base de données : " . $e->getMessage());
		}
	}

	public function setTable($uneTable) {
		$this->uneTable = $uneTable;
	}

	public function selectAll($chaine) {
		if ($this->pdo != null) {
			$requete = "SELECT ".$chaine." FROM ".$this->uneTable;
			$select = $this->pdo->prepare($requete);
			$select->execute();
			return $select->fetchAll();
		} else {
			return null;
		}
	}

	public function selectAllMessages($where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($where as $key => $value) {
				$champs[] = $key. " = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champs);
			$requete = "SELECT * FROM vmessage WHERE ".$chaineWhere." ORDER BY date_envoi DESC";
			$select = $this->pdo->prepare($requete);
			$select->execute($donnees);
			return $select->fetchAll();
		} else {
			return null;
		}
	}

	public function selectWhere($chaine, $where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($where as $key => $value) {
				$champs[] = $key. " = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champs);
			$requete = "SELECT ".$chaine." FROM ".$this->uneTable." WHERE ".$chaineWhere;
			$select = $this->pdo->prepare($requete);
			$select->execute($donnees);
			return $select->fetch();
		} else {
			return null;
		}
	}

	public function insert($tab) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($tab as $key => $value) {
				$champs[] = ":".$key;
				$donnees[":".$key] = $value;
			}
			$chaine = implode(", ", $champs);
			$requete = "INSERT INTO ".$this->uneTable." VALUES (null, ".$chaine.") ";
			$insert = $this->pdo->prepare($requete);
			$insert->execute($donnees);
		} else {
			return null;
		}
	}

	public function delete($where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($where as $key => $value) {
				$champs[] = $key." = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaine = implode(" AND ", $champs);
			$requete = "DELETE FROM ".$this->uneTable." WHERE ".$chaine;
			$delete = $this->pdo->prepare($requete);
			$delete->execute($donnees);
		} else {
			return null;
		}
	}

	public function deleteAll() {
		if ($this->pdo != null) {
			$requete = "DELETE FROM ".$this->uneTable;
			$delete = $this->pdo->prepare($requete);
			$delete->execute();
		} else {
			return null;
		}
	}

	public function update($tab, $where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($tab as $key => $value) {
				$champs[] = $key." =:".$key;
				$donnees[":".$key] = $value;
			}
			$chaine = implode(", ", $champs);
			$champsWhere = array();
			foreach ($where as $key => $value) {
				$champsWhere[] = $key." =:".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champsWhere);
			$requete = "UPDATE ".$this->uneTable." SET ".$chaine." WHERE ".$chaineWhere;
			$update = $this->pdo->prepare($requete);
			$update->execute($donnees);
		} else {
			return null;
		}
	}

	public function selectSearch($mot, $tab) {
		if ($this->pdo != null) {
			$donnees = array();
			$champs = array();
			foreach ($tab as $key) {
				$champs[] = $key." LIKE :mot";
				$donnees[":mot"] = "%".$mot."%";
			}
			$chaineWhere = implode(" OR ", $champs);
			$requete = "SELECT * FROM ".$this->uneTable." WHERE ".$chaineWhere;
			$select = $this->pdo->prepare($requete);
			$select->execute($donnees);
			return $select->fetchAll();
		} else {
			return null;
		}
	}

	public function count() {
		if ($this->pdo != null) {
			$requete = "SELECT count(*) as nb FROM ".$this->uneTable;
			$select = $this->pdo->prepare($requete);
			$select->execute();
			return $select->fetch()["nb"];
		} else {
			return null;
		}
	}

	public function countWhere($where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($where as $key => $value) {
				$champs[] = $key. " = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champs);
			$requete = "SELECT count(*) as nb FROM ".$this->uneTable." WHERE ".$chaineWhere;
			$select = $this->pdo->prepare($requete);
			$select->execute($donnees);
			return $select->fetch()["nb"];
		} else {
			return null;
		}
	}

	public function getIdProduit() {
		if ($this->pdo != null) {
			$requete = "SELECT idproduit FROM produit";
			$select = $this->pdo->query($requete);
			return $select->rowCount();
		} else {
			return null;
		}
	}

	public function selectAllProduits($depart, $produitsParPage) {
		if ($this->pdo != null) {
			$requete = "SELECT * FROM produit ORDER BY idproduit LIMIT :depart, :produitsParPage";
			$select = $this->pdo->prepare($requete);
			$select->bindValue(':depart', $depart, PDO::PARAM_INT);
			$select->bindValue(':produitsParPage', $produitsParPage, PDO::PARAM_INT);
			$select->execute();
			return $select->fetchAll();
		} else {
			return null;
		}
	}

	public function selectAllCommentaires($where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($where as $key => $value) {
				$champs[] = $key. " = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champs);
			$requete = "SELECT idcom, idproduit, idclient, contenu, client_id, dateheurepost FROM vcommentaire WHERE ".$chaineWhere. " ORDER BY idcom DESC";
			$select = $this->pdo->prepare($requete);
			$select->execute($donnees);
			return $select->fetchAll();
		} else {
			return null;
		}
	}

	public function setActif($valeur, $email) {
		if ($this->pdo != null) {
			$requete = "UPDATE clients SET lvl = :valeur WHERE email = :email";
			$update = $this->pdo->prepare($requete);
			$update->bindValue(':valeur', $valeur, PDO::PARAM_INT);
			$update->bindValue(':email', $email, PDO::PARAM_STR);
			$update->execute();
		} else {
			return null;
		}
	}

	public function selectClientWhereCookie() {
		if ($this->pdo != null) {
			$requete = "SELECT * FROM client WHERE email = ? and mdp = ?";
		    $select = $this->pdo->prepare($requete);
		    $select->execute(array($_COOKIE['email'], $_COOKIE['mdp']));
		    $select->fetch();
		    return $select->rowCount();
		} else {
			return null;
		}
	}

	public function selectWhereRowCount($where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($where as $key => $value) {
				$champs[] = $key. " = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champs);
			$requete = "SELECT * FROM ".$this->uneTable." WHERE ".$chaineWhere;
			$select = $this->pdo->prepare($requete);
			$select->execute($donnees);
			$select->fetch();
			return $select->rowCount();
		} else {
			return null;
		}
	}

    public function appelProc($nom, $tab) {
    	if ($this->pdo != null) {
    		$champs = array();
			$donnees = array();
			foreach ($tab as $key=>$value) {
				$champs[] = ":".$key;
				$donnees[":".$key] = $value;
			}
			$chaineArguments = implode(",", $champs);
    		$requete = "call ".$nom." (".$chaineArguments.");";
    		$appel = $this->pdo->prepare($requete);
			$appel->execute($donnees);
    	} else {
    		return null;
    	}
    }

	public function selectAllByPanier($where) {
		if ($this->pdo != null) {
			$champs = array();
			$donnees = array();
			foreach ($where as $key => $value) {
				$champs[] = $key. " = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champs);
			$requete = "SELECT * FROM ".$this->uneTable." WHERE ".$chaineWhere;
			$select = $this->pdo->prepare($requete);
			$select->execute($donnees);
			return $select->fetchAll();
		} else {
			return null;
		}
	}

	public function verifEmail($email) {
		$requete = "SELECT * FROM ".$this->uneTable." WHERE email = :email";
		$select = $this->pdo->prepare($requete);
		$select->bindValue(':email', $email, PDO::PARAM_STR);
		$select->execute();
		$resultat = $select->fetch();
		return $resultat;
	}

	public function verifQteProduit($qteproduit) {
		$requete = "SELECT * FROM produit WHERE qteproduit = :qteproduit";
		$select = $this->pdo->prepare($requete);
		$select->bindValue(':qteproduit', $qteproduit, PDO::PARAM_STR);
		$select->execute();
		$resultat = $select->fetch();
		return $resultat;
	}

	public function generateMdp() {
		$chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789/;%\()@&!";
	    
	    $mdp = ""; // Mot de passe vide par défaut
	    
	    // 5 lettres majuscules choisis aléatoirement
	    $mdp .= $chaine[rand(0,25)]; // 1 lettre majuscule choisi aléatoirement
	    $mdp .= $chaine[rand(0,25)]; // 1 lettre majuscule choisi aléatoirement
	    $mdp .= $chaine[rand(0,25)]; // 1 lettre majuscule choisi aléatoirement
	    $mdp .= $chaine[rand(0,25)]; // 1 lettre majuscule choisi aléatoirement
	    $mdp .= $chaine[rand(0,25)]; // 1 lettre majuscule choisi aléatoirement
	   
	   	// 5 lettres minuscules choisis aléatoirement
	    $mdp .= $chaine[rand(26,51)]; // 1 lettre minuscule choisi aléatoirement
	    $mdp .= $chaine[rand(26,51)]; // 1 lettre minuscule choisi aléatoirement
	    $mdp .= $chaine[rand(26,51)]; // 1 lettre minuscule choisi aléatoirement
	    $mdp .= $chaine[rand(26,51)]; // 1 lettre minuscule choisi aléatoirement
	    $mdp .= $chaine[rand(26,51)]; // 1 lettre minuscule choisi aléatoirement
	    
	    // 2 chiffres choisis aléatoirement
	    $mdp .= $chaine[rand(52,60)]; // 1 chiffre choisi aléatoirement
	    $mdp .= $chaine[rand(52,60)]; // 1 chiffre choisi aléatoirement

	    // 5 caractères spécial choisis aléatoirement
	    $mdp .= $chaine[rand(61,69)]; // 1 caractère spécial choisi aléatoirement
	    $mdp .= $chaine[rand(61,69)]; // 1 caractère spécial choisi aléatoirement
	    $mdp .= $chaine[rand(61,69)]; // 1 caractère spécial choisi aléatoirement
	    $mdp .= $chaine[rand(61,69)]; // 1 caractère spécial choisi aléatoirement
	    $mdp .= $chaine[rand(61,69)]; // 1 caractère spécial choisi aléatoirement
	    
	    $mdp = str_shuffle($mdp); // str_shuffle mélange les caractères d'une chaine de caractères
	    return $mdp;
	}

}

?>
