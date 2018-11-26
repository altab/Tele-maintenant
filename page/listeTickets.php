<?php session_start();

$_SESSION['origine'] = "/page/listeTickets.php";
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");


/**
 * Gestion des clients - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionTitle = "Liste des tickets";
$sectionSubject = "Liste";



require_once '../vues/vListeTickets.php';
?>