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
$interlocuteurEnCours;
$sujetEnCours;
$detailEnCours;


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
        $interlocuteurEnCoursId = $interlocuteurEnCours -> getId();
        $tabTicketsSociete = tabTicketBySocieteByUser($socID, $interlocuteurEnCoursId);
        
        
        
}
//Creation d'un ticket 
elseif ((isset($_GET['action']) && $_GET['action'] == 'nouveauTicket')
     && (isset($_GET['sujet']) && $_GET['sujet'] != '')
     && (isset($_GET['interlocuteurID']) && $_GET['interlocuteurID'] != '')
     && (isset($_GET['societeID']) && $_GET['societeID'] != '') ) {
    
       /*
        * Etape 1 - On reconstruit la page
        */       
       $societeIDPost = $_GET['societeID'];
       $querySocieteID = $connexion -> selectFromWhere('*','societe','id', $societeIDPost);
       $societeEnCours = $querySocieteID[0]['nom'];
       
       $interlocuteurIdPost = $_GET['interlocuteurID'];
       $tabInterlocuteurs =  $connexion->selectFromWhere('*', 'interlocuteur',  'id', $interlocuteurIdPost);
       $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], $tabInterlocuteurs[0]['nom'], $tabInterlocuteurs[0]['prenom'], $tabInterlocuteurs[0]['telephone'], $tabInterlocuteurs[0]['email'], $tabInterlocuteurs[0]['societeID']);
       
       //on recupere tous les tickets de la société
       $tabTicketsSociete = tabTicketBySocieteByUser($societeIDPost, $interlocuteurIdPost);
       
       /*
        * Etape - 2 on ajoute le ticket à la base
        */
       
       $sujet = $_GET['sujet'];
       $connexion -> insertTicket($sujet, $interlocuteurIdPost, $societeIDPost, 1);
       
       $ticketID = $connexion ->  selectLastId('ticket', 'interlocuteurID', $interlocuteurIdPost);
       $ticketID = $ticketID['id'];
       
       header("Location:  http://".$_SERVER['SERVER_NAME']."/page/ticket.php?action=detailTicket&sujet=$sujet&interlocuteurID=$interlocuteurIdPost&societeID=$societeIDPost&ticketID=$ticketID#ajouterTicket");
       
       //$newTicket = new Ticket($id, $sujet, $interlocuteurID, $societeID, $status)
       
    
}
//Ajout detail ticket
elseif ((isset($_GET['action']) && $_GET['action'] == 'detailTicket') 
     && (isset($_GET['interlocuteurID']) && $_GET['interlocuteurID'] != '')
     && (isset($_GET['societeID']) && $_GET['societeID'] != '')
     && (isset($_GET['ticketID']) && $_GET['ticketID'] != '') ) {
        
        /*
         * Etape 1 - On reconstruit la page
         */
        $societeIDPost = $_GET['societeID'];
        $querySocieteID = $connexion -> selectFromWhere('*','societe','id', $societeIDPost);
        $societeEnCours = $querySocieteID[0]['nom'];
        
        $interlocuteurIdPost = $_GET['interlocuteurID'];
        $tabInterlocuteurs =  $connexion->selectFromWhere('*', 'interlocuteur',  'id', $interlocuteurIdPost);
        $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], $tabInterlocuteurs[0]['nom'], $tabInterlocuteurs[0]['prenom'], $tabInterlocuteurs[0]['telephone'], $tabInterlocuteurs[0]['email'], $tabInterlocuteurs[0]['societeID']);
        
        //on recupere tous les tickets de la société
        $tabTicketsSociete = tabTicketBySocieteByUser($societeIDPost, $interlocuteurIdPost);
        
        /*
         * Etape - 2 on affiche le detail du ticket
         */
        $ticketID = $_GET['ticketID'];
        
        if (isset($_GET['ticketID']) && $_GET['ticketID'] != '') {
            $IDTicket= $ticketID;
        } else {
            $lastTicketFromInterlocuteur = $connexion -> selectLastId('ticket', 'interlocuteurID', $interlocuteurIdPost);
            $IDTicket = $lastTicketFromInterlocuteur['id'];
        }
        
        
        
        $queryTicketID = $connexion -> selectFromWhere('*','ticket','id', $IDTicket );
        
        
        $sujetEnCours = new Ticket($queryTicketID[0]['id'], 
                                   $queryTicketID[0]['sujet'], 
                                   $queryTicketID[0]['interlocuteurID'], 
                                   $queryTicketID[0]['societeID'], 
                                   $queryTicketID[0]['status'], 
                                   $queryTicketID[0]['date']);
        
        $detailEnCours = $connexion -> selectFromWhere('*','ticketinfo','ticketID', $sujetEnCours->getId() );


}
//traitement detail ticket
elseif ((isset($_POST['action']) && $_POST['action'] == 'nouveauDetail') ) {
        
        /*
         * Etape 1 - On reconstruit la page
         */
        $societeIDPost = $_POST['societeID'];
        $querySocieteID = $connexion -> selectFromWhere('*','societe','id', $societeIDPost);
        $societeEnCours = $querySocieteID[0]['nom'];
        
        $interlocuteurIdPost = $_POST['interlocuteurID'];
        $tabInterlocuteurs =  $connexion->selectFromWhere('*', 'interlocuteur',  'id', $interlocuteurIdPost);
        $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], $tabInterlocuteurs[0]['nom'], $tabInterlocuteurs[0]['prenom'], $tabInterlocuteurs[0]['telephone'], $tabInterlocuteurs[0]['email'], $tabInterlocuteurs[0]['societeID']);
        
        //on recupere tous les tickets de la société
        $tabTicketsSociete = tabTicketBySocieteByUser($societeIDPost, $interlocuteurIdPost);
        
        /*
         * Etape - 2 on affiche le detail du ticket
         */
        $ticketID = $_POST['ticketID'];
        
        if (isset($_GET['ticketID']) && $_POST['ticketID'] != '') {
            $IDTicket= $ticketID;
        } else {
            $lastTicketFromInterlocuteur = $connexion -> selectLastId('ticket', 'interlocuteurID', $interlocuteurIdPost);
            $IDTicket = $lastTicketFromInterlocuteur['id'];
        }
        
        
        
        $queryTicketID = $connexion -> selectFromWhere('*','ticket','id', $IDTicket );
        
        
        $sujetEnCours = new Ticket($queryTicketID[0]['id'],
            $queryTicketID[0]['sujet'],
            $queryTicketID[0]['interlocuteurID'],
            $queryTicketID[0]['societeID'],
            $queryTicketID[0]['status'],
            $queryTicketID[0]['date']);
        
        /*
         * Etape 3 - on ajoute le detail en base
         */
        $info =  $_POST['detail'];
        $connexion -> insertDetail(0, $info, $sujetEnCours->getId()) ;
        
        $detailEnCours = $connexion -> selectFromWhere('*','ticketinfo','ticketID', $sujetEnCours->getId() );
        
        
        /*
         * TODO Afficher le detail dans le champs ou il a été tapé
         */
        
        
}


function recupSocieteIdFromNom($societeEnCours) {
    
    $connexionBD = new connectDB();
    
    $querySocieteID = $connexionBD -> selectFromWhere('*','Societe','nom', $societeEnCours);
    $societeID = $querySocieteID[0]['id'];
    
    return $societeID;
    
    $connexionBd = null;
    
}

function tabTicketBySocieteByUser($socID,$interlocuteurEnCoursId) {
    
    $connexion = new connectDB();
    
    $tabTickets =  $connexion->selectFromWhereAnd('*', 'ticket', 'societeID', $socID, 'interlocuteurID', $interlocuteurEnCoursId);
    $tabTicketsSociete;
    
    if ($tabTickets) {
        
        foreach ($tabTickets as $ticket) {
            
            $tabTicketsSociete[] = new Ticket($ticket['id'], 
                                              $ticket['sujet'], 
                                              $ticket['interlocuteurID'], 
                                              $ticket['societeID'], 
                                              $ticket['status'], 
                                              $ticket['date']);
            
        }
        
    }
    
    if(!isset($tabTicketsSociete)) $tabTicketsSociete='';
    
    $connexion = null;
    
    return $tabTicketsSociete;
}

$connexion = null; //fermeture de la connexion
require_once '../vues/vTicket.php';
?>