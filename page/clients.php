<?php session_start();

$_SESSION['origine'] = "/page/clients.php";
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");


/**
 * Gestion des clients - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Liste";



require_once '../vues/vClients.php';
?>