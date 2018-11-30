<?php session_start();
require_once '../includes/session.php';


/**
 * Gestion des tickets - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionTitle = "Ticket";
$sectionSubject = "Modifier";

require_once '../DAO/connectDB.php';
require_once '../metier/Societe.php';
require_once '../metier/Interlocuteur.php';
require_once '../metier/Ticket.php';

/*
 * Traitements base de données
 */
$connexion = new connectDB();

/*
 * Variables à utiliser dans la vue
 */
$detailsTicket;
$afficher='';
$warning;


if (isset($_GET['id']) && $_GET['id'] != '')   $idTicket = $_GET['id'];
if (isset($_POST['id']) && $_POST['id'] != '') $idTicket = $_POST['id'];


/*
 * Traitement des formulaires
 */
if (isset($_GET['action']) && $_GET['action']=='modifierSujet') {
    
    $nouveauchamp = $_GET['modifier'];
    $connexion->updateRaw('ticket', 'sujet', $nouveauchamp, 'id', $idTicket);

} elseif (isset($_GET['action']) && $_GET['action']=='modifierInterlocuteur') {
    
    $nouveauchamp = $_GET['modifier'];
    $connexion->updateRaw('ticket', 'interlocuteurID', $nouveauchamp, 'id', $idTicket);
    
} elseif (isset($_GET['action']) && $_GET['action']=='modifierSociete') {
    
    $nouveauchamp = $_GET['modifier'];
    $connexion->updateRaw('ticket', 'societeID', $nouveauchamp, 'id', $idTicket);
    
} elseif (isset($_GET['action']) && $_GET['action']=='modifierStatus') {    
    
    $nouveauchamp = $_GET['modifier'];
    $connexion->updateRaw('ticket', 'status', $nouveauchamp, 'id', $idTicket);
    
} elseif (isset($_GET['action']) && $_GET['action']=='modifierDate') {
    
    $nouveauchamp = urldecode($_GET['modifier']);
    $connexion->updateRawDate('ticket', 'date', $nouveauchamp, 'id', $idTicket);
    
} elseif (isset($_GET['action']) && $_GET['action']=='modifierUtilisateur') {
    
    $nouveauchamp = urldecode($_GET['modifier']);
    $connexion->updateRaw('ticket', 'utilisateurID', $nouveauchamp, 'id', $idTicket);
    
} elseif (isset($_POST['action']) && $_POST['action']=='supprDetails'){
    
    $detailIDs = $_POST['detailID'];
    $connexion ->deleteArrayFrom('ticketinfo', 'id', $detailIDs);
    
}elseif (isset($_POST['action']) && $_POST['action']=='supprTicket'){
    
    $connexion->deleteArrayFrom('ticket', 'id', $_POST['id']);

    
}






//Modification d'un Ticket dont on connait l'ID
if (isset($idTicket)) {
            
    $ticketExiste = true;
    
    /*
     * Affichage des details du ticket
     */
    $detailsTicket = $connexion -> getDetailsTicketFromId($idTicket);
    if($detailsTicket == '') $ticketExiste = false;

    $ticketEnCours = new Ticket($detailsTicket[0]['id'], $detailsTicket[0]['sujet'], $detailsTicket[0]['interlocuteurID'], $detailsTicket[0]['societeID'], $detailsTicket[0]['status'], $detailsTicket[0][5],$detailsTicket[0]['utilisateurID']);

    //Affichage des details du ticket
    if($ticketExiste) {
        foreach ($detailsTicket as $detailTicket) {
            
            if($detailTicket['type'] == 0) $type = "Detail : ";
            else $type ="Action : ";
                    
        }
    } else $warning = "Le ticket demandé n'existe pas !";
    
    
    
    
    
}
// On a pas de variable passé à la page
else {
    
    //$afficher = "Pas de ticket selectionné !";
    
}
echo $afficher;


$connexion = null;
require_once '../vues/vModifierTicket.php';
?>