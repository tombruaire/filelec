<?php

if (!isset($_SESSION['idclient'])) {
    header('Location: /filelec/connexion');
    exit();
}

$unControleur->setTable("vmessage");
$where = array("id_dest"=>$_SESSION['idclient']);
$lesMessages = $unControleur->selectAllMessages($where);

if (isset($_GET['action']) && isset($_GET['idmessage'])) {
    $unControleur->setTable("message");
    $action = $_GET['action'];
    $idmessage = $_GET['idmessage'];
    $where = array('idmessage'=>$idmessage);
    if ($action == 'sup') {
        $unControleur->delete($where);
        echo '<script language="javascript">document.location.replace("messages");</script>';
    }
}

if (isset($_POST['Envoyer'])) {
    $unControleur->setTable("message");
    $tab = array(
        "id_exp"=>$_POST['idclient'],
        "id_dest"=>$_POST['id_dest'],
        "date_envoi"=>date("Y-m-d H:i:s", strtotime("+1 hour")),
        "contenu"=>$_POST['contenu'],
        "lu"=>0
    );
    $unControleur->insert($tab);
    echo '<script language="javascript">document.location.replace("messages");</script>';
}

require_once("vue/messages.php");

?>
