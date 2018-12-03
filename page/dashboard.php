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
$utilisateurID = $_SESSION['utilisateurID'];

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


$tabTicketsOperateur;


//$listeTicketsOperateur = $listeTicketsOperateur1 + $listeTicketsOperateur2;
// construction du tableau des tickets en cours pour l'utilisateur
    
$listeTicketsOperateur2 = $connexion->selectFromWhereAnd('*', 'ticket', 'utilisateurID', $utilisateurID, 'status', '1');
if (isset($listeTicketsOperateur2)) {
    foreach ($listeTicketsOperateur2 as $ticketsOperateur)
        $tabTicketsOperateur[] = new Ticket($ticketsOperateur['id'],
                                            $ticketsOperateur['sujet'],
                                            $ticketsOperateur['interlocuteurID'],
                                            $ticketsOperateur['societeID'],
                                            $ticketsOperateur['status'],
                                            $ticketsOperateur['date'],
                                            $ticketsOperateur['utilisateurID']);
}

$listeTicketsOperateur1 = $connexion->selectFromWhere('*', 'ticket', 'utilisateurID', '99999', 'status', '2');
if (isset($listeTicketsOperateur1)) {
    foreach ($listeTicketsOperateur1 as $ticketsOperateur)
        $tabTicketsOperateur[] = new Ticket($ticketsOperateur['id'],
                                            $ticketsOperateur['sujet'],
                                            $ticketsOperateur['interlocuteurID'],
                                            $ticketsOperateur['societeID'],
                                            $ticketsOperateur['status'],
                                            $ticketsOperateur['date'],
                                            $ticketsOperateur['utilisateurID']);
}

if (isset($tabTicketsOperateur)) rsort($tabTicketsOperateur);


$connexion = null;
require_once '../vues/vDashboard.php';
?>