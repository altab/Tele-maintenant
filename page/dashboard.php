<?php session_start();

$_SESSION['origine'] = "/page/dashboard.php";
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");


require_once '../DAO/connectDB.php';
require_once '../metier/Societe.php';
require_once '../metier/Interlocuteur.php';
require_once '../metier/Ticket.php';

/**
 * Gestion du dashboard - Opreations de traitement
 * @author Philippe Cohen
 */

$sectionSubject = "Accueil";


require_once '../vues/vDashboard.php';
?>