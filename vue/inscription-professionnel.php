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
    <div class="container mt-4 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="card" style="max-width: 40rem;">
                <div class="card-header">
                    <h3 class="text-center">
                        Inscription d'un Professionnel
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Votre nom</label>
                        <input type="text" name="nom" id="nom" maxlength="30" pattern="^[a-zA-Z][a-zA-Z]{1,30}$" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">Votre numéro de téléphone</label>
                        <input type="tel" name="tel" id="tel" minlength="10" maxlength="10" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Votre adresse email</label>
                        <input type="email" name="email" id="email" maxlength="50" pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Votre mot de passe</label>
                        <input type="password" name="mdp" id="mdp" maxlength="255" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" class="form-control" required>
                        <small>Votre mot de passe doit contenir au moins <u>1 lettre majuscule</u>, <u>1 lettre minuscule</u>, <br><u>1 chiffre</u>, <u>1 caractère spécial</u> (@$!&?;%:#+=<*._->) et <u>8 caractères</u> minimum.</small>
                    </div>
                    <div id="box" style="display: none;">
                        <p id="security-mdp"></p>
                    </div>
                    <div class="mb-3">
                        <label for="mdp2" class="form-label">Confirmation du mot de passe</label>
                        <input type="password" name="mdp2" id="mdp2" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Votre adresse de résidence</label>
                        <input type="text" name="adresse" id="adresse" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cp" class="form-label">Votre code postal</label>
                        <input type="text" name="cp" id="cp" maxlength="5" pattern="^[0-9]{5}|2[A-B][0-9]{3}$" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ville" class="form-label">Votre ville</label>
                        <input type="text" name="ville" id="ville" maxlength="50" pattern="^[a-zA-Z][a-zA-Z]{1,50}$" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="pays" class="form-label">Votre pays</label>
                        <input type="text" name="pays" id="pays" maxlength="50" pattern="^[a-zA-Z][a-zA-Z]{1,50}$" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="statut" class="form-label">Votre statut</label>
                        <input type="text" name="statut" id="statut" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="question" class="form-label">Question secrète de sécurité</label>
                        <small>Si vous oubliez votre mot de passe...</small>
                        <select name="enonce" id="question" class="form-select form-control">
                            <?php foreach ($lesQuestions as $uneQuestion) { ?>
                            <option value="<?= $uneQuestion['enonce']; ?>">
                                <?= $uneQuestion['enonce']; ?>
                            </option>
                            <?php } ?>
                        </select>

                        <input type="text" name="reponse" placeholder="Votre réponse" class="form-control mt-2" required>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <button type="submit" name="InscriptionProfessionnel" class="btn btn-lg w-100 text-light fw-bold" style="background-color: #008080; border-color: #AFEEEE;">
                                Créer un compte
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- SUPPRESSION DES ESPACES -->
<script>

	// Suppression des espaces pour le nom
	$("input#nom").on({
		keydown: function(e) {
			if (e.which === 32)
				return false
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

	// Suppression des espaces pour le prénom
	$("input#prenom").on({
		keydown: function(e) {
			if (e.which === 32)
				return false
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

	// Suppression des espaces pour le téléphone
	$("input#tel").on({
		keydown: function(e) {
			if (e.which === 32)
				return false
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

	// Suppression des espaces pour l'adresse email
	$("input#email").on({
		keydown: function(e) {
			if (e.which === 32)
				return false
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

	// Suppression des espaces pour le code postal
	$("input#cp").on({
		keydown: function(e) {
			if (e.which === 32)
				return false
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

</script>
<!-- / SUPPRESSION DES ESPACES -->


<!-- SUPPRESSION DES LETTRES DANS LES INPUT TEL ET CP -->
<script type="text/javascript">
/* Cette fonction permet d'insérer seulement des chiffres compris entre 0 et 9 */
/* Elle est résistante aux : 
- Copier Coller
- Glisser Déposer
- Raccouris clavier
- Opération de menu contextuel
- Touches non typables
- Position d'insertion
- Différentes disposition du clavier */
/* Elle est également supportable sur tous les navigateurs depuis IE 9. */

	function onlyNumber(textbox, inputFilter) {
  		["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    		textbox.addEventListener(event, function() {
      			if (inputFilter(this.value)) {
        			this.oldValue = this.value;
        			this.oldSelectionStart = this.selectionStart;
        			this.oldSelectionEnd = this.selectionEnd;
      			} else if (this.hasOwnProperty("oldValue")) {
        			this.value = this.oldValue;
        			this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      			} else {
        			this.value = "";
      			}
    		});
  		});
	}

	onlyNumber(document.getElementById("tel"), function(value) {
  		return /^\d*?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
	});

	onlyNumber(document.getElementById("cp"), function(value) {
  		return /^\d*?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
	});

</script>
<!-- / SUPPRESSION DES LETTRES DANS LES INPUT TEL ET CP -->

<!-- TÉLÉPHONE : AJOUT D'UN ESPACE APRES LA SAISIE DE 2 CHIFFRES -->
<script type="text/javascript">
	/* OPTIONNEL
	document.getElementById('tel').addEventListener('input', function (e) {
  		e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{2})/g, '$1 ').trim();
	}); */
</script>
<!-- / TÉLÉPHONE : AJOUT D'UN ESPACE APRES LA SAISIE DE 2 CHIFFRES -->

<!-- VÉRIFICATION DE LA SÉCURITÉ DU MOT DE PASSE -->
<script type="text/javascript">

// Déclaration des variables
const password = document.getElementById("mdp"); // ID du champ de mot de passe
const security = document.getElementById("security-mdp"); // ID du texte de la box

// Si l'utilisateur ne saisi aucun caractère, alors on affiche rien
security.innerHTML = "";

// Si l'utilisateur clique sur le champ de mot de passe, la box apparaît mais pas le texte.
password.onfocus = function() {
  document.getElementById("box").style.display = "block";
}

// Si l'utilisateur clique en dehors du champ de mot de passe, la box disparaît.
password.onblur = function() {
  document.getElementById("box").style.display = "none";
}

// Déclaration des variables de caractères
var majuscule = /[A-Z]/g; // Lettres majuscules
var minuscule = /[a-z]/g; // Lettres minuscules
var chiffre = /[0-9]/g;   // Chiffres
var caractere = /[@$!&?;%([\]){}|~/*\\:#+=<>._-]/g; // Caractères spéciaux 
// @ $ ! & ? ; % ( [ ] ) { } | ~ / * \ : # + = < > . _ -

/* Création d'un fonction permettant de détecter les caractères saisis. */

// Si l'utilisateur commence à inscire son mot de passe dans le champ,
// on vérifie les caractères saisis, donc la sécurité.
password.onkeyup = function() {
// Véfification du mot de passe saisi : 
	
	// Sécurité du mot de passe : très faible
	// Si "A" ou "a" ou "1" ou "$" est saisi, alors on affiche la sécurité du mot de passe
  	if( password.value.match(majuscule) /* A */ || 
  		password.value.match(minuscule) /* a */ || 
  		password.value.match(chiffre) /* 1 */ || 
  		password.value.match(caractere) /* $ */ ) {
    	security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='red'><b>Très faible&nbsp;</b></font></p></div></div></div>";

    	// Sécurité du mot de passe : faible
    	// Si "Aa" ou "A1" ou "A$" ou "aA" ou "a1" ou "a$" ou "1a" ou "1A" ou "1$" ou "$A" ou "$a" ou "$1" est saisi, alors on continu
    	if ( (password.value.match(majuscule) && password.value.match(minuscule)) /* Aa */ || 
    		 (password.value.match(majuscule) && password.value.match(chiffre)) /* A1 */ || 
    		 (password.value.match(majuscule) && password.value.match(caractere)) /* A$ */ || 
    		 (password.value.match(minuscule) && password.value.match(majuscule)) /* aA */ || 
    		 (password.value.match(minuscule) && password.value.match(chiffre)) /* a1 */ || 
    		 (password.value.match(minuscule) && password.value.match(caractere)) /* a$ */ || 
    		 (password.value.match(chiffre) && password.value.match(minuscules)) /* 1a */ || 
    		 (password.value.match(chiffre) && password.value.match(majuscule)) /* 1A */ || 
    		 (password.value.match(chiffre) && password.value.match(caractere)) /* 1$ (ne fonctionne pas) */ || 
    		 (password.value.match(caractere) && password.value.match(majuscule)) /* $A  */ || 
    		 (password.value.match(caractere) && password.value.match(minuscule)) /* $a */ || 
    		 (password.value.match(caractere) && password.value.match(chiffre)) /* $1 (ne fonctionne pas) */ ) {
	  		security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='orange'><b>Faible&nbsp;</b></font></p></div></div></div>";

	  		// Sécurité du mot de passe : moyen
	    	// Si "Aa1" ou "A1a" ou "Aa$" ou "A$a" ou "A1$" ou "A$1" ou "aA1" ou "a1A" ou "aA$" ou "a$A" ou "a1$" ou "a$1" ou "1Aa" ou "1aA" ou "1A$" ou "1$A" ou "1a$" ou "1$a" ou "$Aa" ou "$aA" ou "$A1" ou "$1A" ou "$a1" ou "$1a" est saisi, alors on continu 
	    	// (a$) ($a) -> ne fonctionne pas, affiche 'Moyen' au lieu de 'Faible'
	    	// (a$) => (password.value.match(minuscule) && password.value.match(caractere)) 
	    	// ($a) => (password.value.match(caractere) && password.value.match(minuscule))
	  		if ( (password.value.match(majuscule) && 
	  			  password.value.match(minuscule) && 
	  			  password.value.match(chiffre)) /* Aa1 */ ||
	  			  
	  			 (password.value.match(majuscule) && 
	  			  password.value.match(chiffre) && 
	  			  password.value.match(minuscule)) /* A1a */ || 

	  			 (password.value.match(majuscule) && 
	  			  password.value.match(minuscule) && 
	  			  password.value.match(caractere)) /* Aa$ */ || 

	  			 (password.value.match(majuscule) && 
	  			  password.value.match(caractere) && 
	  			  password.value.match(minuscule)) /* A$a */ || 

	  			 (password.value.match(majuscule) && 
	  			  password.value.match(chiffre) && 
	  			  password.value.match(caractere)) /* A1$ */ || 

	  			 (password.value.match(majuscule) && 
	  			  password.value.match(caractere) && 
	  			  password.value.match(chiffre)) /* A$1 */ ||  

	  			 (password.value.match(minuscule) && 
	  			  password.value.match(majuscule) && 
	  			  password.value.match(chiffre)) /* aA1 */ || 

	  			 (password.value.match(minuscule) && 
	  			  password.value.match(chiffre) && 
	  			  password.value.match(majuscule)) /* a1A */ ||

	  			 (password.value.match(minuscule) && 
	  			  password.value.match(majuscule) && 
	  			  password.value.match(caractere)) /* aA$ */ || 

	  			 (password.value.match(minuscule) && 
	  			  password.value.match(caractere) && 
	  			  password.value.match(majuscule)) /* a$A */ || 

	  			 (password.value.match(minuscule) && 
	  			  password.value.match(chiffre) && 
	  			  password.value.match(caractere)) /* a1$ */ || 

	  			 (password.value.match(minuscule) && 
	  			  password.value.match(caractere) && 
	  			  password.value.match(chiffre)) /* a$1 */ || 

	  			 (password.value.match(chiffre) && 
	  			  password.value.match(majuscule) && 
	  			  password.value.match(minuscule)) /* 1Aa */ || 

	  			 (password.value.match(chiffre) && 
	  			  password.value.match(minuscule) && 
	  			  password.value.match(majuscule)) /* 1aA */ || 

	  			 (password.value.match(chiffre) && 
	  			  password.value.match(majuscule) && 
	  			  password.value.match(caractere)) /* 1A$ */ || 

	  			 (password.value.match(chiffre) && 
	  			  password.value.match(caractere) && 
	  			  password.value.match(majuscule)) /* 1$A */ || 

	  			 (password.value.match(chiffre) && 
	  			  password.value.match(minuscule) && 
	  			  password.value.match(caractere)) /* 1a$ */ || 

	  			 (password.value.match(chiffre) && 
	  			  password.value.match(caractere) && 
	  			  password.value.match(minuscule)) /* 1$a */ || 

	  			 (password.value.match(caractere) && 
	  			  password.value.match(majuscule) && 
	  			  password.value.match(minuscule)) /* $Aa */ || 

	  			 (password.value.match(caractere) && 
	  			  password.value.match(minuscule) && 
	  			  password.value.match(majuscule)) /* $aA */ || 

	  			 (password.value.match(caractere) && 
	  			  password.value.match(majuscule) && 
	  			  password.value.match(chiffre)) /* $A1 */ || 

	  			 (password.value.match(caractere) && 
	  			  password.value.match(chiffre) && 
	  			  password.value.match(majuscule)) /* $1A */ || 

	  			 (password.value.match(caractere) && 
	  			  password.value.match(minuscule) && 
	  			  password.value.match(caractere)) /* $a1 */ || 

	  			 (password.value.match(caractere) && 
	  			  password.value.match(chiffre) && 
	  			  password.value.match(minuscule)) /* $1a */

	  			 ) {
		  		security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='yellow'><b>Moyen&nbsp;</b></font></p></div></div></div>";

		  		// Sécurité du mot de passe : fort (ne fonctionne pas)
		    	// Si "Aa1$" ou "Aa$1" ou "A1a$" ou "A1$a" ou "A$a1" ou "A$1a" ou "aA1$" ou "a1A$" ou "a$A1" ou "a$1A" ou "aA$1" ou "a1$A" ou "1Aa$" ou "1A$a" ou "1a$A" ou "1aA$" ou "1$Aa" ou "1$aA" ou "$Aa1" ou "$A1a" ou "$1Aa" ou "$1aA" ou "$a1A" ou "$aA1" est saisi, alors on continu 
		  		if ( (password.value.match(majuscule) && 
	  			  	  password.value.match(minuscule) && 
	  			      password.value.match(chiffre) && 
	  			      password.value.match(caractere)) /* Aa1$ */ ||

		  			 (password.value.match(majuscule) && 
	  			  	  password.value.match(minuscule) && 
	  			      password.value.match(caractere) && 
	  			      password.value.match(chiffre)) /* Aa$1 */ ||

		  			 (password.value.match(majuscule) && 
	  			  	  password.value.match(chiffre) && 
	  			      password.value.match(minuscule) && 
	  			      password.value.match(caractere)) /* A1a$ */ ||

		  			 (password.value.match(majuscule) && 
	  			  	  password.value.match(chiffre) && 
	  			      password.value.match(caractere) && 
	  			      password.value.match(minuscule)) /* A1$a */ ||

		  			 (password.value.match(majuscule) && 
	  			  	  password.value.match(caractere) && 
	  			      password.value.match(minuscule) && 
	  			      password.value.match(chiffre)) /* A$a1 */ ||

		  			 (password.value.match(majuscule) && 
	  			  	  password.value.match(caractere) && 
	  			      password.value.match(chiffre) && 
	  			      password.value.match(minuscule)) /* A$1a */ ||

		  			 (password.value.match(minuscule) && 
	  			  	  password.value.match(majuscule) && 
	  			      password.value.match(chiffre) && 
	  			      password.value.match(caractere)) /* aA1$ */ ||

		  			 (password.value.match(minuscule) && 
	  			  	  password.value.match(chiffre) && 
	  			      password.value.match(majuscule) && 
	  			      password.value.match(caractere)) /* a1A$ */ ||

		  			 (password.value.match(minuscule) && 
	  			  	  password.value.match(caractere) && 
	  			      password.value.match(majuscule) && 
	  			      password.value.match(chiffre)) /* a$A1 */ ||

		  			 (password.value.match(minuscule) && 
	  			  	  password.value.match(caractere) && 
	  			      password.value.match(chiffre) && 
	  			      password.value.match(majuscule)) /* a$1A */ ||

		  			 (password.value.match(minuscule) && 
	  			  	  password.value.match(majuscule) && 
	  			      password.value.match(caractere) && 
	  			      password.value.match(chiffre)) /* aA$1 */ ||

		  			 (password.value.match(minuscule) && 
	  			  	  password.value.match(chiffre) && 
	  			      password.value.match(caractere) && 
	  			      password.value.match(majuscule)) /* a1$A */ ||

		  			 (password.value.match(chiffre) && 
	  			  	  password.value.match(majuscule) && 
	  			      password.value.match(minuscule) && 
	  			      password.value.match(caractere)) /* 1Aa$ */ ||

		  			 (password.value.match(chiffre) && 
	  			  	  password.value.match(majuscule) && 
	  			      password.value.match(caractere) && 
	  			      password.value.match(minuscule)) /* 1A$a */ ||

		  			 (password.value.match(chiffre) && 
	  			  	  password.value.match(minuscule) && 
	  			      password.value.match(caractere) && 
	  			      password.value.match(majuscule)) /* 1a$A */ ||

		  			 (password.value.match(chiffre) && 
	  			  	  password.value.match(minuscule) && 
	  			      password.value.match(majuscule) && 
	  			      password.value.match(caractere)) /* 1aA$ */ ||

		  			 (password.value.match(chiffre) && 
	  			  	  password.value.match(caractere) && 
	  			      password.value.match(majuscule) && 
	  			      password.value.match(minuscule)) /* 1$Aa */ ||

		  			 (password.value.match(chiffre) && 
	  			  	  password.value.match(caractere) && 
	  			      password.value.match(minuscule) && 
	  			      password.value.match(majuscule)) /* 1$aA */ ||

		  			 (password.value.match(caractere) && 
	  			  	  password.value.match(majuscule) && 
	  			      password.value.match(minuscule) && 
	  			      password.value.match(chiffre)) /* $Aa1 */ ||

		  			 (password.value.match(caractere) && 
	  			  	  password.value.match(majuscule) && 
	  			      password.value.match(chiffre) && 
	  			      password.value.match(minuscule)) /* $A1a */ ||

		  			 (password.value.match(caractere) && 
	  			  	  password.value.match(chiffre) && 
	  			      password.value.match(majuscule) && 
	  			      password.value.match(minuscule)) /* $1Aa */ ||

		  			 (password.value.match(caractere) && 
	  			  	  password.value.match(chiffre) && 
	  			      password.value.match(minuscule) && 
	  			      password.value.match(majuscule)) /* $1aA */ ||

		  			 (password.value.match(caractere) && 
	  			  	  password.value.match(minuscule) && 
	  			      password.value.match(chiffre) && 
	  			      password.value.match(majuscule)) /* $a1A */ ||

		  			 (password.value.match(caractere) && 
	  			  	  password.value.match(minuscule) && 
	  			      password.value.match(majuscule) && 
	  			      password.value.match(chiffre)) /* $aA1 */

				) {
		  			security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='#00FF00'><b>Fort&nbsp;</b></font></p></div></div></div>";

		  			// Sécurité du mot de passe : très fort
			  		// Si le mot de passe saisi est supérieur ou égal à 8 caractères,
			  		// on dit l'utilisateur que son mot de passe est très sécurisé.
			  		// Test : $a1A$1Aa
			  		if (password.value.length >= 8) {
				  		security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='gold'><b>Très fort&nbsp;</b></font></p></div></div></div>";
				  	} else {
				  		// Si le mot de passe de l'utilisateur est inférieur à 8,
				  		// on affiche à nouveau la 4ème condition
				  		security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='#00FF00'><b>Fort&nbsp;</b></font></p></div></div></div>";
				  	}
		  		} else {
		  			// Si l'utilisateur enlève un caractère,
			  		// on affiche à nouveau la 3ème condition
			  		security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='yellow'><b>Moyen&nbsp;</b></font></p></div></div></div>";
		  		}
		  	} else {
		  		// Si l'utilisateur enlève un caractère,
		  		// on affiche à nouveau la 2ème condition
		  		security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='orange'><b>Faible&nbsp;</b></font></p></div></div></div>";
		  	}
	  	} else {
	  		// Si l'utilisateur enlève un caractère,
	  		// on affiche à nouveau la 1ère condition
	  		security.innerHTML = "<div class='row'><div class='col-auto'><div class='bg-dark rounded'><p class='text-light'>&nbsp;Sécurité du mot de passe : <font color='red'><b>Très faible&nbsp;</b></font></p></div></div></div>";
	  	}
	} else {
		// Si l'utilisateur ne saisi aucun caractère,
		// alors on affiche rien
	 	security.innerHTML = "";
	}
}
</script>
<!-- / VÉRIFICATION DE LA SÉCURITÉ DU MOT DE PASSE -->