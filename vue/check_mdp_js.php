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
var MAJUSCULE = /[A-Z]/g; // Lettres MAJUSCULES
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
  	if( password.value.match(MAJUSCULE) /* A */ || 
  		password.value.match(minuscule) /* a */ || 
  		password.value.match(chiffre) /* 1 */ || 
  		password.value.match(caractere) /* $ */ ) {
    	security.innerHTML = "<p class='text-dark'><i class='fas fa-shield-alt'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sécurité du mot de passe : <font color='#FF6347'>Très faible</font></p>";

    	// Sécurité du mot de passe : faible
    	// Si "Aa" ou "A1" ou "A$" ou "aA" ou "a1" ou "a$" ou "1a" ou "1A" ou "1$" ou "$A" ou "$a" ou "$1" est saisi, alors on continu
    	if ( (password.value.match(MAJUSCULE) && password.value.match(minuscule)) /* Aa */ || 
    		 (password.value.match(MAJUSCULE) && password.value.match(chiffre)) /* A1 */ || 
    		 (password.value.match(MAJUSCULE) && password.value.match(caractere)) /* A$ */ || 
    		 (password.value.match(minuscule) && password.value.match(MAJUSCULE)) /* aA */ || 
    		 (password.value.match(minuscule) && password.value.match(chiffre)) /* a1 */ || 
    		 (password.value.match(minuscule) && password.value.match(caractere)) /* a$ */ || 
    		 (password.value.match(chiffre) && password.value.match(minuscules)) /* 1a */ || 
    		 (password.value.match(chiffre) && password.value.match(MAJUSCULE)) /* 1A */ || 
    		 (password.value.match(chiffre) && password.value.match(caractere)) /* 1$ (ne fonctionne pas) */ || 
    		 (password.value.match(caractere) && password.value.match(MAJUSCULE)) /* $A  */ || 
    		 (password.value.match(caractere) && password.value.match(minuscule)) /* $a */ || 
    		 (password.value.match(caractere) && password.value.match(chiffre)) /* $1 (ne fonctionne pas) */ ) {
	  		security.innerHTML = "<p class='text-dark'><i class='fas fa-shield-alt'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sécurité du mot de passe : <font color='orange'>Faible</font></p>";

	  		// Sécurité du mot de passe : moyen
	    	// Si "Aa1" ou "A1a" ou "Aa$" ou "A$a" ou "A1$" ou "A$1" ou "aA1" ou "a1A" ou "aA$" ou "a$A" ou "a1$" ou "a$1" ou "1Aa" ou "1aA" ou "1A$" ou "1$A" ou "1a$" ou "1$a" ou "$Aa" ou "$aA" ou "$A1" ou "$1A" ou "$a1" ou "$1a" est saisi, alors on continu
	  		if ( (password.value.match(MAJUSCULE) && 
	  			  password.value.match(minuscule) && 
	  			  password.value.match(chiffre)) /* Aa1 */ ||
	  			  
	  			 (password.value.match(MAJUSCULE) && 
	  			  password.value.match(chiffre) && 
	  			  password.value.match(minuscule)) /* A1a */ || 
	  			 
	  			 (password.value.match(minuscule) && password.value.match(MAJUSCULE) && password.value.match(chiffre)) || 
	  			 (password.value.match(minuscule) && password.value.match(chiffre) && password.value.match(majuscule)) || 
	  			 (password.value.match(chiffre) && password.value.match(minuscule) && password.value.match(MAJUSCULE)) || 
	  			 (password.value.match(chiffre) && password.value.match(MAJUSCULE) && password.value.match(minuscule)) ) {
		  		security.innerHTML = "<p class='text-dark'><i class='fas fa-shield-alt'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sécurité du mot de passe : <font color='aqua'>Moyen</font></p>";

		  		// Sécurité du mot de passe : fort
		  		// Si le mot de passe saisi est supérieur à 8 caractères,
		  		// on dit l'utilisateur que son mot de passe est sécurisé.
		  		if (password.value.length > 8) {
			  		security.innerHTML = "<p class='text-dark'><i class='fas fa-shield-alt'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sécurité du mot de passe : <font color='#00FF00'>Très fort</font></p>";
			  	} else {
			  		// Si le mot de passe de l'utilisateur est inférieur à 8,
			  		// on affiche à nouveau la 3ème condition
			  		security.innerHTML = "<p class='text-dark'><i class='fas fa-shield-alt'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sécurité du mot de passe : <font color='aqua'>Moyen</font></p>";
			  	}
		  	} else {
		  		// Si l'utilisateur enlève un caractère,
		  		// on affiche à nouveau la 2ème condition
		  		security.innerHTML = "<p class='text-dark'><i class='fas fa-shield-alt'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sécurité du mot de passe : <font color='orange'>Faible</font></p>";
		  	}
	  	} else {
	  		// Si l'utilisateur enlève un caractère,
	  		// on affiche à nouveau la 1ère condition
	  		security.innerHTML = "<p class='text-dark'><i class='fas fa-shield-alt'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sécurité du mot de passe : <font color='#FF6347'>Très faible</font></p>";
	  	}
	} else {
		// Si l'utilisateur ne saisi aucun caractère,
		// alors on affiche rien
	 	security.innerHTML = "";
	}
}
</script>
<!-- / VÉRIFICATION DE LA SÉCURITÉ DU MOT DE PASSE -->
