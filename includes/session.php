<?php
$_SESSION['origine'] = "/page/ticket.php";
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // Déconnecte après 30mn
    session_unset();
    session_destroy();
    header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); // mise à jour du timestamp