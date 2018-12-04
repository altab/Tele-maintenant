<?php
$_SESSION['origine'] = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // Déconnecte après 30mn
    session_unset();
    session_destroy();
    header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // mise à jour du timestamp
if (isset($_SESSION['role'])&&$_SESSION['role']!='') $statusUser = $_SESSION['role'];

$nomUtilisateurEnCours =  $_SESSION['nomUtilisateur'];
