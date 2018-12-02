<?php session_start();
require_once '../includes/session.php';


/*
 * XXX SELECT * FROM interlocuteur left join societe on interlocuteur.societeID = societe.id 
 * TODO refactoring
 */

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

$interlocuteurs;
$societeEnCours;
$interlocuteurEnCours;
$sujetEnCours;
$detailEnCours;
$actionEnCours;
$statusTicket;
$utilisateurID = $_SESSION['utilisateurID'];


if (!isset($_GET['societe'])) {
    $tabInterlocuteurs = $connexion->selectFromWhere('*','interlocuteur','','');
    
    foreach ($tabInterlocuteurs as $value) {
        
        $interlocuteurs[] = new Interlocuteur($value['id'], $value['nom'], $value['prenom'], $value['telephone'], $value['email'], $value['societeID']);
        
    }
    
}

// Formulaire de recherche Société
if (isset($_GET['societe']) && $_GET['societe'] != '') {
    
//echo "soc";
    
    $sPOST = htmlentities($_GET['societe']);

    
    $societeEnCours = $connexion->selectFromWhere('*','societe','nom', $sPOST);

    $societe = new Societe($societeEnCours[0]['id'], $societeEnCours[0]['nom'], $societeEnCours[0]['adresse'], $societeEnCours[0]['telephone'], $societeEnCours[0]['email']);
    
    $societeEnCours = $societe -> getNom();

    $socID=$societe-> getId();

    $tabInterlocuteurs = $connexion->selectFromWhere('*','interlocuteur','societeID', $socID);
    
    // On reinitialise le tableu avant d'y mettre les interlocuteurs d'une seule société
    $interlocuteurs = null;
   foreach ($tabInterlocuteurs as $value) {

        $interlocuteurs[] = new Interlocuteur($value['id'], $value['nom'], $value['prenom'], $value['telephone'], $value['email'], $value['societeID']);
        
    }
    
    $tabTicketsSociete = tabTicketBySocieteByUser($socID,'');

}
// Formulaire de recherche Interlocuteur
elseif ((isset($_GET['nomInterlocuteur']) && $_GET['nomInterlocuteur'] != '')
    || (isset($_GET['prenomInterlocuteur']) && $_GET['prenomInterlocuteur'] != '')
    || (isset($_GET['telephone']) && $_GET['telephone'] != '')
    || (isset($_GET['email']) && $_GET['email'] != '') ) {


//         echo "rech inter";
//         var_dump($_GET);
        /*
         * ETAPE 1 - Validation de l'interlocuteur en cours
         */
      
        if (isset($_GET['societeEnCours'])) {
            $societeEnCours = $_GET['societeEnCours'];
            // Récuperation de l'ID de la Societe  partir de son nom
            $socID =  recupSocieteIdFromNom($societeEnCours, $connexion);
        } else { 
            $socID = '';
        }
        
          // On prepare la requete en fonction des infos collectées par ordre d'importance
        if (isset($_GET['nomInterlocuteur']) && $_GET['nomInterlocuteur'] != '') {
            $whereElement = 'nom';
            $whereValue = $_GET['nomInterlocuteur'];
        } elseif (isset($_GET['prenomInterlocuteur']) && $_GET['prenomInterlocuteur'] != '') {
            $whereElement = 'prenom';
            $whereValue = $_GET['prenomInterlocuteur'];
        } elseif (isset($_GET['telephone']) && $_GET['telephone'] != '') {
            $whereElement = 'telephone';
            $whereValue = $_GET['telephone'];
        } elseif (isset($_GET['email']) && $_GET['email'] != '') {
            $whereElement = 'email';
            $whereValue = $_GET['email'];
        } else {
            $whereElement = '';
            $whereValue = '';
        }
        
        $tabInterlocuteurs =  $connexion->selectFromWhere('*', 'interlocuteur',  $whereElement, $whereValue);        
        $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], $tabInterlocuteurs[0]['nom'], $tabInterlocuteurs[0]['prenom'], $tabInterlocuteurs[0]['telephone'], $tabInterlocuteurs[0]['email'], $tabInterlocuteurs[0]['societeID']);

        /*
         * Etape 2 on reconstruit la liste des interlocuteurs de la société au cas on on voudrait changer
         */
        
        if(!$socID) $socID = $tabInterlocuteurs[0]['societeID'];
        $tabInterlocuteurs = $connexion->selectFromWhere('*','interlocuteur','societeID', $socID);
        
        foreach ($tabInterlocuteurs as $value) {
            
            $interlocuteurs[] = new Interlocuteur($value['id'], $value['nom'], $value['prenom'], $value['telephone'], $value['email'], $value['societeID']);
            
        }
        
        if (!isset($societeEnCours)) {
            $socID = $interlocuteurEnCours->getSocieteID();
            $societe = $connexion->selectFromWhere('*','societe','id', $socID);
            $societeEnCours = $societe[0]['nom'];
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
       
       $connexion -> insertTicket($sujet, $interlocuteurIdPost, $societeIDPost, 1, $utilisateurID);
       
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
    
//           echo "detailticket";

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
                                   $queryTicketID[0]['date'],
                                   $queryTicketID[0]['utilisateurID']);
        
        $statusTicket = $sujetEnCours->getStatus();
        
        $sujetId = $sujetEnCours->getId();
        
        $detailEnCours = $connexion -> selectFromWhereAnd('*','ticketinfo','ticketID', $sujetId, 'type', 0 );
        $actionEnCours = $connexion -> selectFromWhereAnd('*','ticketinfo','ticketID', $sujetId, 'type', 1  );

}
//traitement detail ticket
elseif ((isset($_GET['action']) && $_GET['action'] == 'nouveauDetail') ) {

//         echo "trait deatil";
    
    
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
            $queryTicketID[0]['date'],
            $queryTicketID[0]['utilisateurID']);
        
        $statusTicket = $sujetEnCours->getStatus();
        /*
         * Etape 3 - on ajoute le detail en base
         */
        $info =  $_GET['detail'];
        $connexion -> insertDetail(0, $info, $sujetEnCours->getId(), $utilisateurID) ;
        
        
        $sujetId = $sujetEnCours->getId();
        $detailEnCours = $connexion -> selectFromWhereAndSorted('*','ticketinfo','ticketID', $sujetId, 'type', 0, 'id', 'DESC' );
        $actionEnCours = $connexion -> selectFromWhereAndSorted('*','ticketinfo','ticketID', $sujetId, 'type', 1, 'id', 'DESC' );        
        
}
// On ajoute une action
elseif ((isset($_GET['action']) && $_GET['action'] == 'nouvelleAction') ) {
    
//     echo "ajoutaction";
    
     /*
     * Etape 1 - On reconstruit la page
     */
    $societeIDPost = $_GET['societeID'];
    $querySocieteID = $connexion -> selectFromWhere('*','societe','id', $societeIDPost);
    $societeEnCours = $querySocieteID[0]['nom'];
    
    $interlocuteurIdPost = $_GET['interlocuteurID'];
    $tabInterlocuteurs =  $connexion->selectFromWhere('*', 'interlocuteur',  'id', $interlocuteurIdPost);
    $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], 
                                                $tabInterlocuteurs[0]['nom'], 
                                                $tabInterlocuteurs[0]['prenom'], 
                                                $tabInterlocuteurs[0]['telephone'], 
                                                $tabInterlocuteurs[0]['email'], 
                                                $tabInterlocuteurs[0]['societeID']);
    
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
        $queryTicketID[0]['date'],
        $queryTicketID[0]['utilisateurID']);
    
    $statusTicket = $sujetEnCours->getStatus();
    /*
     * Etape 3 - on recupere le detail en base
     */
    $sujet = $sujetEnCours->getId();
    $detailEnCours = $connexion -> selectFromWhereAndSorted('*','ticketinfo','ticketID', $sujet, 'type', 0, 'id', 'DESC');
    
    
    /*
     * Etape 4 - on ajoute le detail en base
     */
    $infoAction =  $_GET['actionTicket'];
    $connexion -> insertDetail(1, $infoAction, $sujetEnCours->getId()) ;
    
    $actionEnCours = $connexion -> selectFromWhereAndSorted('*','ticketinfo','ticketID', $sujet, 'type', 1 , 'id', 'DESC' );

    
}
// On Cloture le ticket
elseif ((isset($_POST['action']) && $_POST['action'] == 'changerStatusTicket') ) {
    
    /*
     * Etape 1 - On reconstruit la page
     */
    $societeIDPost = $_POST['societeID'];
    $querySocieteID = $connexion -> selectFromWhere('*','societe','id', $societeIDPost);
    $societeEnCours = $querySocieteID[0]['nom'];
    
    $interlocuteurIdPost = $_POST['interlocuteurID'];
    $tabInterlocuteurs =  $connexion->selectFromWhere('*', 'interlocuteur',  'id', $interlocuteurIdPost);
    $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], 
                                                $tabInterlocuteurs[0]['nom'], 
                                                $tabInterlocuteurs[0]['prenom'], 
                                                $tabInterlocuteurs[0]['telephone'], 
                                                $tabInterlocuteurs[0]['email'], 
                                                $tabInterlocuteurs[0]['societeID']);
    
    
    
    /*
     * Etape - 2 on affiche le detail du ticket
     */
    $ticketID = $_POST['ticketID'];
    
    if (isset($_POST['ticketID']) && $_POST['ticketID'] != '') {
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
        $queryTicketID[0]['date'],
        $queryTicketID[0]['utilisateurID']);
    
    
    
    /*
     * Etape 3 - on recupere le detail en base
     */
    $sujet = $sujetEnCours->getId();
    $detailEnCours = $connexion -> selectFromWhereAndSorted('*','ticketinfo','ticketID', $sujet, 'type', 0, 'id', 'DESC');
    $actionEnCours = $connexion -> selectFromWhereAndSorted('*','ticketinfo','ticketID', $sujet, 'type', 1 , 'id', 'DESC' );
    
    $id = $sujetEnCours->getId();
    if($sujetEnCours->getStatus() == 1) $connexion -> updateRaw('ticket', 'status', 0, 'id', $id);
    else $connexion -> updateRaw('ticket', 'status', 1, 'id', $id);
    
    // On reconstruit l'objet à jour avant d'laffichage de la page$queryTicketID = $connexion -> selectFromWhere('*','ticket','id', $IDTicket );
    $sujetEnCours = null;
//    $detailEnCours = null;
    
    $queryTicketID = $connexion -> selectFromWhere('*','ticket','id', $IDTicket );
    $sujetEnCours = new Ticket($queryTicketID[0]['id'],
        $queryTicketID[0]['sujet'],
        $queryTicketID[0]['interlocuteurID'],
        $queryTicketID[0]['societeID'],
        $queryTicketID[0]['status'],
        $queryTicketID[0]['date'],
        $queryTicketID[0]['utilisateurID']);
    $statusTicket = $sujetEnCours->getStatus();
    
    //on recupere tous les tickets de la société
    $tabTicketsSociete = tabTicketBySocieteByUser($societeIDPost, $interlocuteurIdPost);
    
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
    
    if(isset($interlocuteurEnCoursId)&&$interlocuteurEnCoursId!='')  $tabTickets =  $connexion->selectFromWhereAnd('*', 'ticket', 'societeID', $socID, 'interlocuteurID', $interlocuteurEnCoursId);
    else $tabTickets =  $connexion->selectFromWhere('*', 'ticket', 'societeID', $socID);
    
   
    $tabTicketsSociete;
    
    if ($tabTickets) {
        
        foreach ($tabTickets as $ticket) {
            
            $tabTicketsSociete[] = new Ticket($ticket['id'], 
                                              $ticket['sujet'], 
                                              $ticket['interlocuteurID'], 
                                              $ticket['societeID'], 
                                              $ticket['status'], 
                                              $ticket['date'],
                                              $ticket['utilisateurID']);
            
        }
        
    }
    
    if(!isset($tabTicketsSociete)) $tabTicketsSociete='';
    
    $connexion = null;
    
    return $tabTicketsSociete;
}

$connexion = null; //fermeture de la connexion
require_once '../vues/vTicket.php';
?>