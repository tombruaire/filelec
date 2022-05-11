<?php if (isset($erreur)) { ?>
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong><?= $erreur; ?></strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<form method="post" action="">
	<div class="container mt-4">
		<div class="row">
			<div class="d-flex justify-content-center">
				<div class="col-auto text-center border rounded bg-light my-5">
					<h1>&nbsp;Mon panier&nbsp;</h1>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="card">
					<div class="card-body">
						<table class="table text-center">
							<thead>
								<tr>
									<th scope="col">Numéro</th>
									<th scope="col">Produit</th>
									<th scope="col">Prix</th>
									<th scope="col">Quantité</th>
									<th scope="col">Total</th>
									<th scope="col">Opération</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($lesPaniers) { ?>
									<?php foreach ($lesPaniers as $unPanier) {
										$total = $total + $unPanier['prixproduit'] * $unPanier['quantite']; ?>
										<tr>
											<td><?= $unPanier['idproduit']; ?></td>
											<input type="hidden" name="idproduit" value="<?= $unPanier['idproduit']; ?>">
											<td><?= $unPanier['nomproduit']; ?></td>
											<input type="hidden" name="nomproduit" value="<?= $unPanier['nomproduit']; ?>">
											<td>
												<?= number_format($unPanier['prixproduit'], 2, ',', ' '); ?> €
												<input type="hidden" class="iprice" value="<?= $unPanier['prixproduit']; ?>">
											</td>
											<td><?= $unPanier['quantite']; ?></td>
											<td><?= number_format($unPanier['montantTotalHT'], 2, ',', ' '); ?> €</td>
											<td>
												<input type="hidden" name="idclient" value="<?= $_SESSION['idclient']; ?>">
												<button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editQteProduit">
													<i class="bi bi-pencil-square"></i>
												</button>
												<a href="panier?action=sup&numcommande=<?= $unPanier['numcommande']; ?>&idproduit=<?= $unPanier['idproduit']; ?>&idclient=<?= $unPanier['idclient']; ?>" class="btn btn-sm btn-outline-danger">
													<i class="bi bi-x-lg"></i>
												</a>
												<input type="hidden" name="nomProduit" value="<?= $unPanier['nomproduit']; ?>">
											</td>
										</tr>
									<?php } ?>
								<?php } else { ?>
									<tr>
										<td colspan="6" style="font: 600 16px system-ui;">
											Vous n'avez aucun article dans votre panier.
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card mb-5">
					<div class="card-body">
						<h3>Montant Total :  </h3>
						<h4 class="text-end mb-3"><?= $total; ?> €</h4>
						<?php if ($lesPaniers) { ?>
						<?php if (isset($_SESSION['idclient'])) { ?>
	                        <input type="hidden" name="idclient" value="<?= $_SESSION['idclient']; ?>">
							<input type="hidden" name="nom" value="<?= $_SESSION['nom']; ?>">
							<input type="hidden" name="adresse" value="<?= $_SESSION['adresse']; ?>">
							<input type="hidden" name="cp" value="<?= $_SESSION['cp']; ?>">
							<input type="hidden" name="ville" value="<?= $_SESSION['ville']; ?>">
							<input type="hidden" name="pays" value="<?= $_SESSION['pays']; ?>">
							<style type="text/css">
								input[type="radio"] {display: none;}
								label {color: black; font-family: 'Poppins', sans-serif; font-size: 12pt; border: 2px solid #01cc65; border-radius: 5px; padding: 10px 50px; display: flex; align-items: center; cursor: pointer;}
								label:before {content: ""; height: 30px; width: 30px; border: 3px solid #01cc65; border-radius: 50%; margin-right: 20px;}
								input[type="radio"]:checked + label {background-color: #01cc65; color: white;}
								input[type="radio"]:checked + label:before {height: 30px; width: 30px; border: 10px solid white; background-color: #01cc65;}
							</style>
							<div class="mb-3">
								<div class="form-check mb-3">
									<input type="radio" name="mode_payement" id="option1" value="Carte bancaire" checked>
									<label class="form-check-label" for="option1">
									 	Carte bancaire
									</label>
								</div>
								<div class="form-check">
									<input type="radio" name="mode_payement" id="option2" value="PayPal">
									<label class="form-check-label" for="option2">
									 	PayPal
									</label>
								</div>
							</div>
							<div class="d-flex justify-content-center">
								<button name="payement" class="btn btn-success btn-lg w-100">
									Valider la commande
								</button>
							</div>
						<?php } } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="modal fade" id="editQteProduit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title">Modifier la quantité d'un produit</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<form method="post" action="">
      			<div class="modal-body">
	        		<div class="mb-3">
	        			<select name="idproduit" class="form-select form-control">
	        				<?php foreach ($lesPaniers as $unProduit) { ?>
	        				<option value="<?= $unProduit['idproduit']; ?>">
	        					<?= $unProduit['nomproduit']; ?>
	        				</option>
	        				<?php } ?>
	        			</select>
	        			<input type="number" name="quantite" class="form-control mt-2" min="1" value="1">
	        		</div>
	      		</div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
	        		<button type="submit" name="ModifierQte" class="btn btn-primary">Modifier</button>
	      		</div>
      		</form>
    	</div>
  	</div>
</div>
