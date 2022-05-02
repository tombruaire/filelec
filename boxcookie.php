<?php

if (isset($_COOKIE['accept_cookie'])) {
	$showcookie = false;
} else {
	$showcookie = true;
}

?>

<?php if ($showcookie) { ?>
<script type="text/javascript">
window.addEventListener("load", function(){window.wpcc.init({"corners":"small","colors":{"popup":{"background":"#cff5ff","text":"#000000","border":"#5e99c2"},"button":{"background":"#5e99c2","text":"#ffffff"}},"position":"bottom-right","border":"thin","content":{"href":"cookie","message":"Nous utilisons les cookies afin de fournir les services et fonctionnalités proposés sur notre site et afin d’améliorer l’expérience de nos utilisateurs. Les cookies sont des données qui sont téléchargés ou stockés sur votre ordinateur ou sur tout autre appareil. En cliquant sur \"J'accepte\", vous acceptez l’utilisation de ces cookies.","link":"En savoir plus","button":"J'accepte"}})});
</script>
<?php } ?>