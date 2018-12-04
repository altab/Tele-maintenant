<?php session_start();
require_once '../includes/session.php';


/**
 * Gestion des clients - Operations de traitement
 * @author Philippe Cohen
 */

/*
 * Traitements base de données
 */
require_once '../DAO/connectDB.php';
$connexion = new connectDB();

require_once '../metier/Societe.php';
require_once '../metier/Interlocuteur.php';

$sectionSubject = "Ajouter";

/*
 * Liste des variables
 */
$societeEnCours;
$warning;
$listeSociete=null;
$warningColor;
$tabListeSocietes;





if(isset($_GET['action']) && $_GET['action']=='creerSociete') {
        
    // On met la societe en BAse et on recupere son ID
    $connexion->insertSociete($_GET['nomSociete'], $_GET['adresseSociete'], $_GET['telSociete'], $_GET['emailSociete']);
    $idSociete = $connexion->selectLastId('societe', 'nom', $_GET['nomSociete']); //SELECT id FROM ticket WHERE interlocuteurID=2 ORDER BY id DESC LIMIT 0,1
    $SocieteID = $idSociete['id'];  
    
    //On créé l'objet issu de la saisie
    $tabSociete = $connexion->selectFromWhere('*', 'societe', 'id', $SocieteID);
    $societeEnCours = new Societe($tabSociete[0]['id'], $tabSociete[0]['nom'], $tabSociete[0]['adresse'], $tabSociete[0]['telephone'], $tabSociete[0]['email']);

    if (isset($societeEnCours)&&$societeEnCours!='') {
        $modificationsEffectuees=true;
    }
    
    if(isset($modificationsEffectuees) && $modificationsEffectuees==true) {
        $warning = "La société a été créée !";
        $warningColor = ' bg-success text-white';
    }
    
    //on remet le tebleau à jour
    $tabListeSocietes=null;
    $tabListeSocietes = $connexion->selectFromWhere('*', 'societe', '', '');
    
} elseif (isset($_GET['action']) && $_GET['action']=='modifierSociete') {
    
    $SocieteID;
    
    if (isset($_GET['idSociete']) && $_GET['idSociete']!='') {
        
        $SocieteID = $_GET['idSociete'];
        
         
        if (isset($_GET['nomSociete']) && $_GET['nomSociete']!=''){
            $connexion->updateRaw('societe', 'nom', $_GET['nomSociete'], 'id', $SocieteID);
            $modificationsEffectuees=true;}
            
            if (isset($_GET['telSociete']) && $_GET['telSociete']!=''){
            $connexion->updateRaw('societe', 'telephone', $_GET['telSociete'], 'id', $SocieteID);
            $modificationsEffectuees=true;}
            
            if (isset($_GET['emailSociete']) && $_GET['emailSociete']!=''){
            $connexion->updateRaw('societe', 'email', $_GET['emailSociete'], 'id', $SocieteID);
            $modificationsEffectuees=true;}
            
            if (isset($_GET['adresseSociete']) && $_GET['adresseSociete']!=''){
            $connexion->updateRaw('societe', 'adresse', $_GET['adresseSociete'], 'id', $SocieteID);
            $modificationsEffectuees=true;}
        
    }
    
   
    
    //On créé l'objet issu de la saisie
    $tabSociete = $connexion->selectFromWhere('*', 'societe', 'id', $SocieteID);
    $societeEnCours = new Societe($tabSociete[0]['id'], $tabSociete[0]['nom'], $tabSociete[0]['adresse'], $tabSociete[0]['telephone'], $tabSociete[0]['email']);
   
    
    
    if(isset($modificationsEffectuees) && $modificationsEffectuees==true) {
        $warning = "La société a été mise à jour !";
        $warningColor = 'bg-success text-white';
    }
    
    
    //on remet le tableau à jour
    $tabListeSocietes = $connexion->selectFromWhere('*', 'societe', '', '');
    
    
} elseif (isset($_POST['action']) && $_POST['action']=='supprimerSociete') {

    if ( ((isset($_POST['idSocieteSuppr']) && $_POST['idSocieteSuppr']!='')) 
      && ((!isset($statusUser) || $statusUser==1)) ) {
          
         $verifTicketSociete = $connexion->selectFromWhere('*', 'ticket', 'societeID', $_POST['idSocieteSuppr']);
         $verifInterlocuteurSociete = $connexion->selectFromWhere('*', 'interlocuteur', 'societeID', $_POST['idSocieteSuppr']);
         
         //si on a pas de ticket associé on peut supprimer la Sté
         if(!$verifTicketSociete && !$verifInterlocuteurSociete) {
            $connexion->deleteArrayFrom('societe', 'id', $_POST['idSocieteSuppr']);
         
            $warning = "La société a été définitivement supprimée !";
            $warningColor = 'bg-danger text-white';
         } else {
             $warning = "La société n'a pas été supprimée car des tickets ou des Interlocuteurs lui sont toujours associé !";
             $warningColor = 'bg-danger text-white';
         }
         
         //on remet le tableau à jour
         $tabListeSocietes = $connexion->selectFromWhere('*', 'societe', '', '');
         
          
      }
  
} else {
    
    $tabListeSocietes = $connexion->selectFromWhere('*', 'societe', '', '');
    
}

if (isset($tabListeSocietes)) {
    foreach ($tabListeSocietes as $societe)
        $listeSociete[] = new Societe($societe['id'], $societe['nom'], $societe['adresse'], $societe['telephone'], $societe['email']);
} else {
    $warning = "Aucune société à afficher";
    $warningColor = "bg-warning text-dark";
}

if(isset($societeEnCours)) $societeModif = $societeEnCours;

$connexion = null;
require_once '../vues/vClients.php';
?>