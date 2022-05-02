<?php
session_start();
require_once("controleur/config_bdd.php");
require_once("controleur/controleur.class.php");
$unControleur = new Controleur($hostname, $database, $username, $password);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Filelec</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- FICHIERS CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/scroll.animate.css">
    <link rel="stylesheet" type="text/css" href="assets/zoombox/zoombox.css">
    <link rel="stylesheet" type="text/css" href="assets/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pagination.css">
    <link rel="stylesheet" type="text/css" href="assets/css/searchBar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/selectedBox.css">
    <link rel="stylesheet" type="text/css" href="assets/css/footer.css">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css">
    <script src="assets/js/fontawesome.js"></script>
    <!-- BOX COOKIES -->
    <link rel="stylesheet" type="text/css" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css"/>
    <script src="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.js" defer></script>
    <!-- / BOX COOKIES -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <?php if (isset($_GET['page']) && $_GET['page'] == "connexion") { ?>
        <link rel="stylesheet" type="text/css" href="assets/css/util.css">
        <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <?php } elseif (isset($_GET['page']) && $_GET['page'] == "inscription-particulier") { ?>
        <link rel="stylesheet" type="text/css" href="assets/css/util.css">
        <link rel="stylesheet" type="text/css" href="assets/css/main.css">
        <link rel="stylesheet" type="text/css" href="assets/css/inscription.css">
    <?php } elseif (isset($_GET['page']) && $_GET['page'] == "inscription-professionnel") { ?>
        <link rel="stylesheet" type="text/css" href="assets/css/util.css">
        <link rel="stylesheet" type="text/css" href="assets/css/main.css">
        <link rel="stylesheet" type="text/css" href="assets/css/inscription.css">
    <?php } ?>
    <!-- / FICHIERS CSS -->
</head>
<body style="background-image: url(assets/images/bg.jpg); background-position: center center; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">

<?php require_once("boxcookie.php"); ?>

<!-- MENU DE NAVIGATION -->
<nav id="navbar">
    <div class="logo">
        <a href="/filelec/" style="text-decoration: none; color: white;">Filelec</a>
    </div>
    <label for="btn" class="icon">
        <span class="fa fa-bars"></span>
    </label>
    <input type="checkbox" id="btn">
    <ul>
        <li><a href="/filelec/">Accueil</a></li>
        <li><a href="produits">Produits</a></li>
        <li><a href="faq">F.A.Q.</a></li>
        <li><a href="contact">Contact</a>
    <?php if (!isset($_SESSION['idclient'])) { ?>
        <li><a href="connexion" class="text-info">CONNEXION</a></li>
        <li><a href="inscription" style="color: #00FF00;">INSCRIPTION</a></li>
    <?php } else { ?>
        <li><a href="commandes" style="color: #00FA9A;">Commandes</a></li>
        <li><a href="panier" class="text-warning">Panier</a></li>
        <li><a href="messages" style="color: rgb(13,110,253);">Messages</a></li>
        <li><a href="profil" style="color: #00FFFF;">Profil</a></li>
        <li><a href="deconnexion" style="color: #FF0000;"><i class="bi bi-power fs-5"></i></a></li>
    <?php } ?>
    </ul>
</nav>
<!-- / MENU DE NAVIGATION -->

<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = "home";
}

switch ($page) {
    case "home" :
        require_once("home.php");
        break;
    case "faq" :
        require_once("vue/faq.php");
        break;
    case "contact" :
        require_once("gestion_contact.php");
        break;
    case "mentions-legales" :
        require_once("vue/mentions-legales.php");
        break;
    case "rgpd" :
        require_once("vue/rgpd.php");
        break;
    case "cookie" :
        require_once("vue/cookie.php");
        break;
    case "cgv" :
        require_once("vue/cgv.php");
        break;
    case "produits" :
        require_once("gestion_produits.php");
        break;
    case "produit" :
        require_once("gestion_produit.php");
        break;
    case "connexion" :
        if (!isset($_SESSION['idclient'])) {
            require_once("gestion_connexion.php");
        } else {
            header('Location: /filelec/');
        }
        break;
    case "inscription" :
        if (!isset($_SESSION['idclient'])) {
            require_once("gestion_inscription.php");
        } else {
            header('Location: /filelec/');
        }
        break;
    case "inscription-particulier" :
        if (!isset($_SESSION['idclient'])) {
            require_once("gestion_inscription_particulier.php");
        } else {
            header('Location: /filelec/');
        }
        break;
    case "inscription-professionnel" :
        if (!isset($_SESSION['idclient'])) {
            require_once("gestion_inscription_professionnel.php");
        } else {
            header('Location: /filelec/');
        }
        break;
    case "profil" :
        if (isset($_SESSION['idclient'])) {
            require_once("gestion_profil.php");
        } else {
            header('Location: connexion');
        }
        break;
    case "panier" :
        require_once("gestion_panier.php");
        break;
    case "commandes" :
        require_once("gestion_commandes.php");
        break;
    case "messages" :
        require_once("gestion_messagerie.php");
        break;
    case "recuperation-mdp" :
        require_once("gestion_mdp.php");
        break;
    case "deconnexion" :
        setcookie('email', '', time() - 3600);
        setcookie('mdp', '', time() - 3600);
        unset($_SESSION);
        session_destroy();
        header('Location: connexion');
        break;
    case "facture" : 
        require_once("gestion_facture.php");
        break;
    default :
        require_once("404.php");
}

?>

<!-- FOOTER -->
<?php if (isset($_GET['page']) && $_GET['page'] == "inscription") { ?>
<div class="footer-basic fixed-bottom" style="background-color: #171933;">
<?php } else { ?>
<div class="footer-basic" style="background-color: #171933;">
<?php } ?>
    <footer>
        <div class="d-flex justify-content-center mb-4">
            <a href="javascript:void(0)" class="me-5">
                <i class="bi bi-facebook text-info fs-2"></i>
            </a>
            <a href="javascript:void(0)">
                <i class="bi bi-instagram instagram fs-2"></i>
            </a>
        </div>
        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="/filelec/">Accueil</a>
            </li>
            <li class="list-inline-item">
                <a href="mentions-legales">Mentions légales</a>
            </li>
            <li class="list-inline-item">
                <a href="rgpd">RGPD</a>
            </li>
            <li class="list-inline-item">
                <a href="cookie">Cookies</a>
            </li>
            <li class="list-inline-item">
                <a href="cgv">CGV</a>
            </li>
        </ul>
        <p class="copyright">Filelec © 2022 - Tout droits réservés.</p>
    </footer>
</div>
<!-- / FOOTER -->

<!-- FICHIERS JAVASCRIPT -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/scroll.animate.js"></script>
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="assets/zoombox/zoombox.js"></script>
<!-- / FICHIERS JAVASCRIPT -->

<!-- ZOOMBOX (Image d'accueil) -->
<script type="text/javascript">
    $(function () {
        $('a.zoombox').zoombox();
    })(jQuery);
</script>
<!-- / ZOOMBOX -->

<script>
    $('.icon').click(function () {
        $('span').toggleClass("cancel");
    });
</script>

<!-- DÉSACTIVATION DE LA TOUCHE F12 DU CLAVIER -->
<!--
<script type="text/javascript">
    document.onkeypress = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            return false;
        }
    }
    document.onmousedown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            return false;
        }
    }
    document.onkeydown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            return false;
        }
    }
</script>
-->

<!-- DÉSACTIVATION DU CLIQUE DROIT DE LA SOURIS -->
<!--
<script type="text/javascript">
    window.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    }, false);
</script>
-->

</body>
</html>
