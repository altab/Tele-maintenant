<?php session_start();
require_once '../includes/session.php';


/**
 * Gestion des clients - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionTitle = "Liste des tickets";
$sectionSubject = "Liste";

/*
 * Traitements base de données
 */
require_once '../DAO/connectDB.php';
$connexion = new connectDB();

/*
 * Liste des includes
 */

require_once '../metier/Societe.php';
require_once '../metier/Interlocuteur.php';
require_once '../metier/Ticket.php';

/*
 * Variables à utiliser dans la vue
 */
$societeID;
$interlocuteurID;
$listeInterlocuteurs; //tableau de données specifiques
$listeTickets; // tableau de Ticket
$interlocuteurEncours;
$societeEnCours;
$StatusID;




/*
 * Par defaut on afffiche toutes les societes et tous les interlocuteurs
 */
$listeSocietes = $connexion ->selectFromWhere('id, nom', 'societe', '', '');




/*
 * Traitement des retours de formulaires
 */
if(isset($_GET['societeID']) && $_GET['societeID'] != '') {
    
    $societes = $connexion->selectFromWhere('*', 'societe', 'id', $_GET['societeID']);
    $societeEnCours = new Societe($societes[0]['id'], $societes[0]['nom'], $societes[0]['adresse'], $societes[0]['telephone'], $societes[0]['email']);

    $societeID = $societeEnCours->getId();
    
    $interlocuteurs = $connexion->selectFromWhere('*', 'interlocuteur', 'societeID', $_GET['societeID'] );
    
    foreach($interlocuteurs as $interlocuteur) {
        
        $listeInterlocuteurs[] = new Interlocuteur($interlocuteur['id'], $interlocuteur['nom'], $interlocuteur['prenom'], $interlocuteur['telephone'], $interlocuteur['email'], $interlocuteur['societeID']);
        
    }
    
    $tabListeTickets =  $connexion->selectFromWhere('*', 'ticket', 'societeID', $_GET['societeID']);
    
    if(isset($tabListeTickets)) {
        
        foreach ($tabListeTickets as $tabTicket)
            $listeTickets[] = new Ticket($tabTicket['id'], $tabTicket['sujet'], $tabTicket['interlocuteurID'], $tabTicket['societeID'], $tabTicket['status'], $tabTicket['date'],$tabTicket['utilisateurID']);
    
    }
    
    
    if(isset($_GET['interlocuteurID']) && $_GET['interlocuteurID'] != 'Tous') {
        
        global $interlocuteurEnCours, $societeID, $interlocuteurID, $listeTickets;
        
        
        $tabInterlocuteur = $connexion->selectFromWhere('*', 'interlocuteur', 'id', $_GET['interlocuteurID']);        
        
        $interlocuteurEnCours = new Interlocuteur($tabInterlocuteur[0]['id'], $tabInterlocuteur[0]['nom'], $tabInterlocuteur[0]['prenom'], $tabInterlocuteur[0]['telephone'], $tabInterlocuteur[0]['email'], $tabInterlocuteur[0]['societeID']);
        
        $tabListeTickets =  $connexion->selectFromWhere('*', 'ticket', 'interlocuteurID',$_GET['interlocuteurID']);
        
        $listeTickets = null;
        if(isset($tabListeTickets)) {
            
            foreach ($tabListeTickets as $tabTicket)
                $listeTickets[] = new Ticket($tabTicket['id'], $tabTicket['sujet'], $tabTicket['interlocuteurID'], $tabTicket['societeID'], $tabTicket['status'], $tabTicket['date'], $tabTicket['utilisateurID']);
                
        }

        $societeID = $interlocuteurEnCours->getSocieteID();
        $interlocuteurID = $interlocuteurEnCours->getId();
               
    }
    
    if(isset($_GET['status']) && $_GET['status'] != '') {
        
        $StatusID = $_GET['status'];
        
        if(!isset($_GET['interlocuteurID'])) {
            $strInterlocuteurID = 'interlocuteurID';
            $valInterlocuteurID = '*';
            $interlocuteurID = null;
        } else {
            $strInterlocuteurID = 'interlocuteurID';
            $valInterlocuteurID = $_GET['interlocuteurID'];
            $interlocuteurID = $_GET['interlocuteurID'];
        }

        if($StatusID == '0' || $StatusID == '1')
            $tabListeTickets =  $connexion->selectFromWhereAnd('*', 'ticket', $strInterlocuteurID, $valInterlocuteurID, 'status', $StatusID);
        else 
            $tabListeTickets =  $connexion->selectFromWhere('*', 'ticket', $strInterlocuteurID, $valInterlocuteurID);
            
        $listeTickets = null;
        if(isset($tabListeTickets)) {
            
            foreach ($tabListeTickets as $tabTicket)
                $listeTickets[] = new Ticket($tabTicket['id'], $tabTicket['sujet'], $tabTicket['interlocuteurID'], $tabTicket['societeID'], $tabTicket['status'], $tabTicket['date'], $tabTicket['utilisateurID']);
                
        }
        
       
    }
    
 
} 
// On a un interlocuteur mais pas de société
elseif (isset($_GET['interlocuteurID']) && $_GET['interlocuteurID'] != 'Tous') {

        $interlocuteurID = $_GET['interlocuteurID'];
        
        $soc = $connexion->selectFromWhere('societeID', 'interlocuteur', 'id', $interlocuteurID);
    
        header("Location:  http://".$_SERVER['SERVER_NAME']."/page/listeTickets.php?societeID=".$soc[0]['societeID']."&interlocuteurID=$interlocuteurID&action=choixInterlocuteur");
    
}else {
    
    $interlocuteurs = $connexion ->selectFromWhere('*', 'interlocuteur', '', '');
    
    foreach($interlocuteurs as $interlocuteur) {
        
        $listeInterlocuteurs[] = new Interlocuteur($interlocuteur['id'], $interlocuteur['nom'], $interlocuteur['prenom'], $interlocuteur['telephone'], $interlocuteur['email'], $interlocuteur['societeID']);
        
    }
    
    
}

function tri($a, $b)
{
    return strcmp($b->getId(), $a->getId());
}
if(isset($listeTickets) && is_array($listeTickets)) usort($listeTickets, "tri");
   



$connexion = null;
require_once '../vues/vListeTickets.php';
?>