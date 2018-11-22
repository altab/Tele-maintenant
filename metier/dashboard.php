<?php session_start();

if (isset($_SESSION['login'])) echo  "<!-- Utilisateur : ".$_SESSION['login']."-->";
else {
    $_SESSION['origine'] = "/metier/dashboard.php";
    header("Location:  http://".$_SERVER['SERVER_NAME']."/metier/login.php");
}



/**
 * Gestion du dashboard - Opreations de traitement
 * @author Philippe Cohen
 */

$sectionSubject = "Accueil";



require_once '../vues/vDashboard.php';
?>