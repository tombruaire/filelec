<?php

require_once("modele/modele.class.php");

class Controleur {

	private $unModele;

	public function __construct($hostname, $database, $username, $password) {
		$this->unModele = new Modele($hostname, $database, $username, $password);
	}

	public function setTable($uneTable) {
		$this->unModele->setTable($uneTable);
	}

	public function selectAll($chaine = "*") {
		return $this->unModele->selectAll($chaine);
	}

	public function selectAllMessages($where) {
		return $this->unModele->selectAllMessages($where);
	}

	public function selectWhere($chaine = "*", $where) {
		return $this->unModele->selectWhere($chaine, $where);
	}

	public function insert($tab) {
		$this->unModele->insert($tab);
	}

	public function delete($where) {
		$this->unModele->delete($where);
	}

	public function deleteAll() {
		$this->unModele->deleteAll();
	}

	public function update($tab, $where) {
		$this->unModele->update($tab, $where);
	}

	public function selectSearch($mot, $tab) {
		return $this->unModele->selectSearch($mot, $tab);
	}

	public function count() {
		return $this->unModele->count();
	}

	public function countWhere($where) {
		return $this->unModele->countWhere($where);
	}

	public function getIdProduit() {
		return $this->unModele->getIdProduit();
	}

	public function selectAllProduits($depart, $produitsParPage) {
		return $this->unModele->selectAllProduits($depart, $produitsParPage);
	}

	public function selectAllCommentaires($where) {
		return $this->unModele->selectAllCommentaires($where);
	}

	public function setActif($valeur, $email) {
		$this->unModele->setActif($valeur, $email);
	}

	public function auth($lvl) {
		$this->unModele->auth($lvl);
	}

	public function selectClientWhereCookie() {
		return $this->unModele->selectClientWhereCookie();
	}

	public function selectWhereRowCount($where) {
		return $this->unModele->selectWhereRowCount($where);
	}

	public function appelProc($nom, $tab) {
		$this->unModele->appelProc($nom, $tab);
	}

	public function selectAllByPanier($where) {
		return $this->unModele->selectAllByPanier($where);
	}

	public function verifEmail($email) {
		return $this->unModele->verifEmail($email);
	}

	public function verifQteProduit($qteproduit) {
		return $this->unModele->verifQteProduit($qteproduit);
	}

	public function generateMdp() {
		return $this->unModele->generateMdp();
	}

}

?>
