<?php if (isset($erreur)) { ?>
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong><?= $erreur; ?></strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div class="container d-flex flex-column">
	<div class="row h-100">
		<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100 mb-5">
			
			<div class="d-table-cell align-middle">
				<div class="card bg-dark mt-4">
					<div class="card-header bg-dark">
						<h1 class="text-light text-center h2">Mot de passe oublié</h1>
					</div>
					<form method="post" action="">
						<div class="card-body bg-dark rounded">
							<div class="m-sm-4">
								<div class="mb-3">
									<input type="email" name="email" placeholder="Adresse email" class="form-control form-control-lg">
								</div>
								<style type="text/css">
		                            [type=email].form-control:focus {box-shadow: inset 0 0 0;}
		                        </style>
							</div>
							<div class="m-sm-4">
								<div class="mb-3">
									<select name="enonce" class="form-select form-control form-control-lg">
										<?php foreach ($lesQuestions as $uneQuestion) { ?>
											<option value="<?= $uneQuestion['enonce']; ?>">
												<?= $uneQuestion['enonce']; ?>
											</option>
										<?php } ?>
									</select>
									<input type="text" name="reponse" id="reponse" class="form-control form-control-lg mt-2">
								</div>
							</div>
							<div class="m-sm-4">
								<div class="mb-3">
									<input type="password" name="mdp" placeholder="Nouveau mot de passe" class="form-control form-control-lg">
								</div>
								<div class="mb-3">
									<input type="password" name="mdp2" placeholder="Confirmation du mot de passe" class="form-control form-control-lg">
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="row d-flex justify-content-center">
								<div class="col-4">
									<button type="submit" name="Valider" class="btn btn-lg btn-success text-light active w-100 mb-3">
										Valider
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
