<?php session_start();

if (isset($_SESSION['login'])) echo  "<!-- Utilisateur : ".$_SESSION['login']."-->";
else {
    $_SESSION['origine'] = "/metier/clients.php";
    header("Location:  http://".$_SERVER['SERVER_NAME']."/metier/login.php");
}


/**
 * Gestion des clients - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Liste";



require_once '../vues/vClients.php';
?>