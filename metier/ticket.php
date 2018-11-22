<?php session_start();

if (isset($_SESSION['login'])) echo  "<!-- Utilisateur : ".$_SESSION['login']."-->";
else {
    $_SESSION['origine'] = "/metier/ticket.php";
    header("Location:  http://".$_SERVER['SERVER_NAME']."/metier/login.php");
}


/**
 * Gestion des tickets - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Nouveau";



require_once '../vues/vTicket.php';
?>