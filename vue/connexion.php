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

<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100 reveal-1 mb-5">
			<form method="post" action="" class="login100-form validate-form">
				<span class="login100-form-logo">
					<i class="bi bi-person-circle"></i>
				</span>
				<span class="login100-form-title p-b-34 p-t-27">
					Connexion
				</span>
				<div class="wrap-input100 validate-input" data-validate="Veuillez saisir une adresse email">
					<input type="email" name="email" placeholder="Adresse email" class="input100" required>
					<span class="focus-input100" data-placeholder="&#xf207;"></span>
				</div>
				<div class="wrap-input100 validate-input" data-validate="Veuillez saisir un mot de passe">
					<input type="password" name="mdp" placeholder="Mot de passe" class="input100" required>
					<span class="focus-input100" data-placeholder="&#xf191;"></span>
				</div>
				<div align="center">
					<a href="recuperation-mdp" class="text-light">Mot de passe oublié ?</a>
				</div>
				<div class="container-login100-form-btn">
					<button type="submit" name="Connexion" class="btn btn-lg text-light mt-4" style="background-color: #800000; border-color: #AFEEEE;">
						Se connecter
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
