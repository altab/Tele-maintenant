<?php session_start();

$_SESSION['origine'] = "/page/rechercher.php";
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");

/**
 * Gestion des tickets - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Nouveau";



require_once '../vues/vDashboard.php';
?>