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

<div class="container mt-4">
	<div class="row">
		<div class="d-flex justify-content-center">
			<div class="col-lg-5 col-md-5 col-sm-12">
				<form method="post" action="">
					<div class="card rounded mb-5 animate__animated animate__jackInTheBox">
						<div class="card-header">
							<h3 class="text-center">
								<?= $leProduit['nomproduit']; ?>
							</h3>
						</div>
						<div class="card-body">
							<div class="d-flex justify-content-center">
								<img src="assets/images/produits/<?= $leProduit['imageproduit']; ?>" width="300" class="img-fluit" alt="<?= $leProduit['nomproduit']; ?>">
							</div>
							<figcaption class="blockquote-footer mt-3">
    							<cite title="Description"><?= $leProduit['descriptionproduit']; ?></cite>
  							</figcaption>
  							<h4 class="text-center font-weight-bold mb-3">
  								<?= number_format($leProduit['prixproduit'], 2, ',', ' '); ?> €
  							</h4>
  							<?php if (isset($_SESSION['idclient'])) { ?>
  							<div class="mb-3">
								<div class="row d-flex justify-content-center">
									<div class="col-auto">
										<input type="number" name="quantite" min="1" max="<?= $leProduit['qteproduit']; ?>" value="1" class="form-control">
									</div>
								</div>
							</div>
							<p class="card-text">Encore 
								<b><?= $leProduit['qteproduit']; ?></b> 
								<?php if ($leProduit['qteproduit'] < 2) { ?>
									exemplaire disponible.
								<?php } else { ?>
									exemplaires disponible.
								<?php } ?>
							</p>
							<?php } ?>
							<input type="hidden" name="idproduit" value="<?= $leProduit['idproduit']; ?>">
						</div>
						<?php if (isset($_SESSION['idclient'])) { ?>
						<div class="card-footer" style="background-color: #fff;">
							<div class="d-flex justify-content-center">
								<button type="submit" name="Ajouter" class="btn btn-success">
									+ Ajouter au panier
								</button>
							</div>
						</div>
						<?php } else { ?>
							<p class="card-text text-center">
								<i>Vous devez vous connecter pour pouvoir acheter ce produit.</i>
							</p>
						<?php } ?>
						<div class="d-flex justify-content-center mt-4 mb-3">
							<a href="javascript:history.back()" class="btn btn-secondary">Retour</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div style="margin-bottom: 50px!important;">
			<div class="row d-flex justify-content-center">
				<div class="col-lg-9 col-md-9 col-sm-12">
					<div class="container mt-5">
					    <div class="row justify-content-center">
					        <div class="col-md-8">
					            <div class="headings d-flex justify-content-between align-items-center mb-3">
					                <div class="card">
					                	<div class="card-header">
					                		<h5>Commentaires (<?= $nbCommentaires; ?>)</h5>
					                	</div>
					                </div>
					            </div>
					            <div class="card p-3 mt-2">
					            	<?php if (isset($_SESSION['idclient'])) { ?>
					            	<form method="post" action="">
					            		<div class="card-body">
					            			<div class="input-group mb-3">
					            				<textarea name="contenu" placeholder="Votre message" class="form-control" aria-describedby="basic-addon2"><?= ($editCom != null ? $editCom['contenu'] : null); ?></textarea>
					            				<?php if ($editCom != null) { ?>
					            				<button type="submit" name="Edit" class="btn">
					            					<span class="input-group-text btn-primary" id="basic-addon2">
					            						Poster
					            					</span>
					            				</button>
					            				<?php } else { ?>
					            				<button type="submit" name="Poster" class="btn">
					            					<span class="input-group-text btn-success" id="basic-addon2">
					            						Poster
					            					</span>
					            				</button>
					            				<?php } ?>
					            			</div>
					            		</div>
					            	</form>
					            	<?php } else { ?>
					            	<p class="card-text text-center">
					            		<i>Vous devez vous connecter pour pouvoir poster un commentaire.</i>
					            	</p>
					            	<?php } ?>
					            </div>
					            <?php foreach ($lesCommentaires as $unCommentaire) { ?>
					            <div class="card p-3 mt-2 animate__animated animate__fadeInUp">
					                <div class="d-flex justify-content-between align-items-center">
					                    <div class="user d-flex flex-row align-items-center">
				                    		<span>
				                    			<small class="font-weight-bold text-primary">
				                    				<b><?= $unCommentaire['idclient']; ?></b>
				                    			</small><br>
				                    			<small class="font-weight-bold">
				                    				<?= $unCommentaire['contenu']; ?>
				                    			</small>
				                    		</span> 
					                    </div> 
					                    <small><?= $unCommentaire['dateheurepost']; ?></small>
					                </div>
					                <?php if (isset($_SESSION['idclient']) && $_SESSION['idclient'] == $unCommentaire['client_id']) { ?>
					                <div class="action d-flex justify-content-between mt-2 align-items-center">
					                    <div class="reply px-4"> 
					                    	<small>
					                    		<a href="produit?view=<?= $leProduit['idproduit']; ?>&action=edit&idcom=<?= $unCommentaire['idcom']; ?>&idproduit=<?= $unCommentaire['idproduit']; ?>" class="me-2" style="text-decoration: none;" class="text-primary">
					                    			Modifier
					                    		</a>
					                    	</small> 
					                    	<span class="dots" style="height: 4px; width: 4px; margin-bottom: 2px; background-color: #bbb; border-radius: 50%; display: inline-block;"></span> 
					                    	<small>
				                    			<a href="produit?view=<?= $leProduit['idproduit']; ?>&action=delete&idcom=<?= $unCommentaire['idcom']; ?>&idproduit=<?= $unCommentaire['idproduit']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer votre commentaire ?'));" class="ms-2" style="text-decoration: none; color: red;">
				                    				Supprimer
				                    			</a>
					                    	</small> 
					                    </div>
					                </div>
					            	<?php } ?>
					            </div>
					        	<?php } ?>
					        </div>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>