<?php session_start();
require_once '../includes/session.php';

require_once '../DAO/connectDB.php';
$connexion = new connectDB();

/**
 * Gestion des tickets - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Nouveau";



require_once '../vues/vDashboard.php';
?>