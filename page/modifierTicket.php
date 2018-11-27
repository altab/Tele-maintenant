<?php session_start();

$_SESSION['origine'] = "/page/modifierTicket.php";
if (!isset($_SESSION['login'])) header("Location:  http://".$_SERVER['SERVER_NAME']."/page/login.php");

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


//Modification d'un Ticket dont on connait l'ID
if (isset($_GET['action']) && $_GET['action'] == 'modifierID') {
    
    if (isset($_GET['id']) && $_GET['id'] != '') $idTicket = $_GET['id'];
    
    $afficher =  "Le ticket à modifier est le : ".$idTicket."<br><br>";
    
    /*
     * Affichage du ticket
     */
    $infosTicket = $connexion -> selectFromWhere('*','ticket','id', $idTicket);//SELECT * FROM `ticket` WHERE `id`=68
    foreach ($infosTicket as $infoTicket) {
        
        $afficher .=  "<br>id = ".$infoTicket['id'];
        $afficher .=  "<br>sujet = ".$infoTicket['sujet'];
        $afficher .=  "<br>interlocuteurID = ".$infoTicket['interlocuteurID'];
        $afficher .=  "<br>societeID = ".$infoTicket['societeID'];
        $afficher .=  "<br>status = ".$infoTicket['status'];
        $afficher .=  "<br>date = ".$infoTicket['date'];
        $afficher .=  "<br><br><br>";
        
    }
    
    /*
     * Affichage des details du ticket
     */
    $detailsTicket = $connexion -> getDetailsTicketFromId($idTicket);
    //var_dump($infosTicket);
    
    foreach ($detailsTicket as $detailTicket) {
        
        if($detailTicket['type'] == 0) $type = "Detail : ";
        else $type ="Action : ";
        
        $afficher .=  "<br>".$type.$detailTicket['info'];
        $afficher .=  "-> ID : ".$detailTicket['id'];
        
    }
    
}



$connexion = null;
require_once '../vues/vModifierTicket.php';
?>