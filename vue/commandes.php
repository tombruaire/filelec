<form method="post" action="">
	<div class="container">
		<div class="row">
			<div class="d-flex justify-content-center">
				<div class="col-auto text-center text-light border rounded bg-dark my-5">
					<h1>&nbsp;Mes commandes&nbsp;</h1>
				</div>
			</div>
			<div class="d-flex justify-content-center">
				<div class="col-auto">
					<?php if ($lesFactures) { ?>
						<?php foreach($lesFactures as $uneFacture) { ?>
						<input type="hidden" name="idclient" value="<?= $_SESSION['idclient']; ?>">
						<input type="hidden" name="idproduit" value="<?= $uneFacture['idproduit']; ?>">
						<input type="hidden" name="numcommande" value="<?= $uneFacture['numcommande']; ?>">
						<div class="card mb-5 animate__animated animate__zoomIn">
							<div class="card-header">
								<h3 class="text-center">
									Commande n°<?= $uneFacture['numcommande']; ?>
								</h3>
							</div>
							<div class="card-body">
		                        <p class="card-text">
									<b>Nom :</b> <?= $uneFacture['nom']; ?>
								</p>
		                        <p class="card-text">
									<b>Date commande :</b> <?= $uneFacture['datecommande']; ?>
								</p>
								<p class="card-text">
									<b>Adresse de livraison :</b> <?= $uneFacture['adresse']; ?>, <?= $uneFacture['cp']; ?> <?= $uneFacture['ville']; ?> - <?= $uneFacture['pays']; ?>
								</p>
								<p class="card-text">
									<b>Moyen de payement :</b> <?= $uneFacture['mode_payement']; ?>
								</p>
								<p class="card-text">
									<table class="table text-center">
										<thead>
											<tr>
												<th scope="col">Produit(s)</th>
												<th scope="col">Prix Unitaire</th>
												<th scope="col">Quantité</th>
												<th scope="col">Prix total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?= $uneFacture['produit']; ?></td>
												<td><?= number_format($uneFacture['prix'], 2, ',', ' '); ?> €</td>
												<td><?= $uneFacture['quantite']; ?></td>
												<td><?= number_format($uneFacture['montantTotalHT'], 2, ',', ' '); ?> €</td>
											</tr>
										</tbody>
									</table>
								</p>
								<p class="card-text">
									<b>Montant total HT :</b> <?= number_format($uneFacture['montantTotalHT'], 2, ',', ' '); ?> €
				 				</p>
				 				<p class="card-text">
									<b>Montant total TTC :</b> <?= number_format($uneFacture['montantTotalTTC'], 2, ',', ' '); ?> €
				 				</p>
				 				<p class="card-text">
				 					<b>Etat de la commande :</b> <?= $uneFacture['etat']; ?>
				 				</p>
				 				<p class="card-text">
				 					<b>Date de livraison garantie :</b> <?= $uneFacture['datelivraison']; ?>
				 				</p>
							</div>
							<div class="card-footer">
								<div class="d-flex justify-content-center">
									<input type="hidden" name="numcommande" value="<?= $uneFacture['numcommande']; ?>">
									<button type="submit" name="Annuler" onclick="return(confirm('Voulez-vous vraiment annuler cette commande ?'));" class="btn btn-danger me-2">
										Annuler la commande
									</button>
									<a class="btn btn-primary" target="_blank" onclick="window.print();return false;">Imprimer</a>
								</div>
							</div>
						</div>
						<?php } ?>
					<?php } else { ?>
						<div class="card mb-5">
							<div class="card-header">
								<h4 class="text-center">Vous n'avez aucune commande...</h4>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</form>