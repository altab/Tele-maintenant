<?php session_start();
require_once '../includes/session.php';


require_once '../DAO/connectDB.php';
require_once '../metier/Societe.php';
require_once '../metier/Interlocuteur.php';
require_once '../metier/Ticket.php';

/**
 * Gestion du dashboard - Opreations de traitement
 * @author Philippe Cohen
 */

$sectionSubject = "Accueil";


require_once '../DAO/connectDB.php';
$connexion = new connectDB();

$nbFromTicket = $connexion->countFromTableWhere('ticket','','');
$nbTickets = $nbFromTicket['COUNT(*)'];

$nbCloturesFromTicket = $connexion->countFromTableWhere('ticket','status',0);
$nbCloturesTickets = $nbCloturesFromTicket['COUNT(*)'];

$nbFromClient = $connexion->countFromTableWhere('societe','','');
$nbClients = $nbFromClient['COUNT(*)'];

$nbFromInterlocuteur = $connexion->countFromTableWhere('interlocuteur','','');
$nbInterlocuteurs = $nbFromInterlocuteur['COUNT(*)'];

$connexion = null;
require_once '../vues/vDashboard.php';
?>