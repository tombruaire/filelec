<?php
$unControleur->setTable("produit");
$nbProduits = $unControleur->count();
$unControleur->setTable("client");
$nbClients = $unControleur->count();
$unControleur->setTable("commentaire");
$nbCommentaires = $unControleur->count();
?>

<section class="py-6 reveal">
	<div class="container">
		<div class="row d-flex justify-content-center mb-5 border border-section-2 border-5" style="background-color: #4682B4; border-radius:.25rem!important;">
			<div class="mb-3 text-center mt-4">
				<h2 class="h1 reveal-1" style="color: #F0FFFF;">
					Filelec en quelques chiffres
				</h2>
			</div> 
			<div class="col-md-6 col-lg-3 mb-3 reveal-3">
				<div class="card border">
					<div class="card-body">
						<h5 class="text-center mt-2">
							<i class="bi bi-camera-reels-fill me-2"></i>
							<?= $nbProduits; ?> Produits
						</h5>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-3 mb-3 reveal-4">
				<div class="card border">
					<div class="card-body">
						<h5 class="text-center mt-2">
							<i class="bi bi-people-fill me-2"></i> 
							<?= $nbClients; ?> Clients
						</h5>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-3 mb-3 reveal-5">
				<div class="card border">
					<div class="card-body">
						<h5 class="text-center mt-2">
							<i class="bi bi-chat-left-fill me-2"></i> 
							<?= $nbCommentaires; ?> Commentaires
						</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
