<?php session_start();

$_SESSION['origine'] = "/page/ticket.php";
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");



/**
 * Gestion des tickets - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Nouveau";


require_once '../DAO/connectDB.php';
require_once '../metier/Societe.php';
require_once '../metier/Interlocuteur.php';
require_once '../metier/Ticket.php';

/*
 * Traitements base de données
 */
$connexion = new connectDB();


//on recupere les societes
$societes = $connexion->selectFromWhere('*','Societe','', '');


$interlocuteurs=null;
$societeEnCours;


// Formulaire de recherche Société
if (isset($_POST['societe']) && $_POST['societe'] != '') {
    
    $sPOST = htmlentities($_POST['societe']);
    
    $societeID = $connexion->selectFromWhere('*','societe','nom', $sPOST);
    
    $societe = new Societe($societeID[0]['id'], $societeID[0]['nom'], $societeID[0]['adresse'], $societeID[0]['telephone'], $societeID[0]['email']);
    
    $societeEnCours = $societe -> getNom();
    
    $tabInterlocuteurs = $connexion->selectFromWhere('*','interlocuteur','societeID', $societe-> getId());
    
    foreach ($tabInterlocuteurs as $value) {
        
        $interlocuteurs[] = new Interlocuteur($value['id'], $value['nom'], $value['prenom'], $value['telephone'], $value['email'], $value['societeID']);
        
    }
    
}
// Formulaire de recherche Interlocuteur
elseif ((isset($_POST['nomInterlocuteur']) && $_POST['nomInterlocuteur'] != '')
    || (isset($_POST['prenomInterlocuteur']) && $_POST['prenomInterlocuteur'] != '')
    || (isset($_POST['telephone']) && $_POST['telephone'] != '')
    || (isset($_POST['email']) && $_POST['email'] != '') ) {
        
        
        /*
         * ETAPE 1 - Validation de l'interlocuteur en cours
         */
        $societeEnCours = $_POST['societeEnCours'];
        // Récuperation de l'ID de la Societe  partir de son nom
        $socID =  recupSocieteIdFromNom($societeEnCours, $connexion);
        
        
        // On prepare la requete en fonction des infos collectées par ordre d'importance
        if (isset($_POST['nomInterlocuteur']) && $_POST['nomInterlocuteur'] != '') {
            $whereElement = 'nom';
            $whereValue = $_POST['nomInterlocuteur'];
        } elseif (isset($_POST['prenomInterlocuteur']) && $_POST['prenomInterlocuteur'] != '') {
            $whereElement = 'prenom';
            $whereValue = $_POST['prenomInterlocuteur'];
        } elseif (isset($_POST['telephone']) && $_POST['telephone'] != '') {
            $whereElement = 'telephone';
            $whereValue = $_POST['telephone'];
        } elseif (isset($_POST['email']) && $_POST['email'] != '') {
            $whereElement = 'email';
            $whereValue = $_POST['email'];
        } else {
            $whereElement = '';
            $whereValue = '';
        }
        
        $tabInterlocuteurs =  $connexion->selectFromWhereAnd('*', 'interlocuteur',  $whereElement, $whereValue, 'societeID', $socID);
        
        $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], $tabInterlocuteurs[0]['nom'], $tabInterlocuteurs[0]['prenom'], $tabInterlocuteurs[0]['telephone'], $tabInterlocuteurs[0]['email'], $tabInterlocuteurs[0]['societeID']);
        
        /*
         * Etape 2 on reconstruit la liste des interlocuteurs de la société au cas on on voudrait changer
         */
        $tabInterlocuteurs = $connexion->selectFromWhere('*','interlocuteur','societeID', $socID);
        
        foreach ($tabInterlocuteurs as $value) {
            
            $interlocuteurs[] = new Interlocuteur($value['id'], $value['nom'], $value['prenom'], $value['telephone'], $value['email'], $value['societeID']);
            
        }
        
        /*
         * Etape 3 - Création du tableau des tickets de l'interlocuteur en cours
         */
        
        //on recupere tous les tickets de la société
        $tabTickets =  $connexion->selectFromWhereAnd('*', 'ticket', 'societeID', $socID, 'interlocuteurID', $interlocuteurEnCours -> getId());
        $tabTicketsSociete;
        
        if ($tabTickets) {
            
            foreach ($tabTickets as $ticket) {
                
                $tabTicketsSociete[] = new Ticket($ticket['id'], $ticket['sujet'], $ticket['interlocuteurID'], $ticket['societeID'], $ticket['status']);
                
            }
            
        }
        
        
        
}

function recupSocieteIdFromNom($societeEnCours, $connexion) {
    
    $querySocieteID = $connexion -> selectFromWhere('*','Societe','nom', $societeEnCours);
    $societeID = $querySocieteID[0]['id'];
    
    return $societeID;
    
}

$connexion = null; //fermeture de la connexion
require_once '../vues/vTicket.php';
?>