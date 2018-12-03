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
$listeInterlocuteur=null;
$interlocuteurEnCours;
$warning;
$InterlocuteurModif;



 if(isset($_GET['action']) && $_GET['action']=='creerInterlocuteur') {
    
    // On met l'interlocuteur en Base et on recupere son ID
    $connexion->insertInterlocuteur($_GET['nomInterlocuteur'], $_GET['prenomInterlocuteur'], $_GET['telInterlocuteur'], $_GET['emailInterlocuteur'],$_GET['societeInterlocuteur'] );    
    $idInterlocuteur = $connexion->selectLastId('interlocuteur', 'societeID',$_GET['societeInterlocuteur']);
    $interlocuteurID = $idInterlocuteur['id'];  
    
    //On créé l'objet issu de la saisie
    $tabInterlocuteur = $connexion->selectFromWhere('*', 'interlocuteur', 'id', $interlocuteurID);
    $interlocuteurEnCours = new Interlocuteur($tabInterlocuteur[0]['id'], $tabInterlocuteur[0]['nom'], $tabInterlocuteur[0]['prenom'], $tabInterlocuteur[0]['telephone'], $tabInterlocuteur[0]['email'], $tabInterlocuteur[0]['societeID']);
    
     $warning = "L'interlocuteur a été correctement ajoutée !";
     
     //On remet le tableau à jour
     $tabListeInterlocuteurs = $connexion->selectFromWhere('*', 'interlocuteur', '', '');
     
    
 } elseif (isset($_GET['action']) && $_GET['action']=='modifierInterlocuteur') {;
    
    $InterlocuteurID;
    
    if (isset($_GET['idInterlocuteur']) && $_GET['idInterlocuteur']!='') {
        
        
        
        $InterlocuteurID = $_GET['idInterlocuteur'];
        
        if (isset($_GET['nomInterlocuteur']) && $_GET['nomInterlocuteur']!='') {
            $nom =  $_GET['nomInterlocuteur'];
            $connexion->updateRaw('interlocuteur', 'nom', $nom, 'id', $InterlocuteurID);
            $warning = "L'interlocuteur a été mise à jour !";
        }
        if (isset($_GET['prenomInterlocuteur']) && $_GET['prenomInterlocuteur']!=''){
            $connexion->updateRaw('interlocuteur', 'prenom', $_GET['prenomInterlocuteur'], 'id', $InterlocuteurID);
            $warning = "L'interlocuteur a été mise à jour !";
        }
        if (isset($_GET['telInterlocuteur']) && $_GET['telInterlocuteur']!=''){
            $connexion->updateRaw('interlocuteur', 'telephone', $_GET['telInterlocuteur'], 'id', $InterlocuteurID);
            $warning = "L'interlocuteur a été mise à jour !";
        }
        if (isset($_GET['emailInterlocuteur']) && $_GET['emailInterlocuteur']!=''){
            $connexion->updateRaw('interlocuteur', 'email', $_GET['emailInterlocuteur'], 'id', $InterlocuteurID);
            $warning = "L'interlocuteur a été mise à jour !";
        }
        if (isset($_GET['societeInterlocuteur']) && $_GET['societeInterlocuteur']!=''){
            $connexion->updateRaw('interlocuteur', 'societeID', $_GET['societeInterlocuteur'], 'id', $InterlocuteurID);
            $warning = "L'interlocuteur a été mise à jour !";}
        
        
        
    }
//     echo "cOOO000000000000OOOOOOL";
//     echo $InterlocuteurID;

    //On créé l'objet issu de la saisie
    $tabInterlocuteur = null;
    $tabInterlocuteur = $connexion->selectFromWhere('*', 'interlocuteur', 'id', $InterlocuteurID);
     
    $interlocuteurEnCours = null;
    $interlocuteurEnCours = new Interlocuteur($tabInterlocuteur[0]['id'], 
                                                $tabInterlocuteur[0]['nom'], 
                                                $tabInterlocuteur[0]['prenom'], 
                                                $tabInterlocuteur[0]['telephone'], 
                                                $tabInterlocuteur[0]['email'],
                                                $tabInterlocuteur[0]['societeID']);
    
    // On remet le ableau à jour
    $tabListeInterlocuteurs = $connexion->selectFromWhere('*', 'interlocuteur', '', '');
    
 } elseif (isset($_POST['action']) && $_POST['action']=='supprimerInterlocuteur') {
     
     if ( ((isset($_POST['idInterlocuteurSuppr']) && $_POST['idInterlocuteurSuppr']!=''))
         && ((!isset($statusUser) || $statusUser==1)) ) {
             
             $verifTicketSociete = $connexion->selectFromWhere('*', 'ticket', 'interlocuteurID', $_POST['idInterlocuteurSuppr']);
             
             //si on a pas de ticket associé on peut supprimer la Sté
             if(!$verifTicketSociete) {
                 $connexion->deleteArrayFrom('interlocuteur', 'id', $_POST['idInterlocuteurSuppr']);
                 
                 $warning = "L'interlocuteur a été définitivement supprimé !";
                 $warningColor = 'bg-danger text-white';
             } else {
                 $warning = "L'interlocuteur n'a pas été supprimé car des tickets lui sont encore associé !";
                 $warningColor = 'bg-danger text-white';
             }
             
             //on remet le tableau à jour
             $tabListeInterlocuteurs = $connexion->selectFromWhere('*', 'interlocuteur', '', '');
                  
         }
         
}else {
     $tabListeInterlocuteurs = $connexion->selectFromWhere('*', 'interlocuteur', '', '');
}
 
 if(isset($interlocuteurEnCours)) $InterlocuteurModif = $interlocuteurEnCours;
 
 foreach ($tabListeInterlocuteurs as $interlocuteur)
     $listeInterlocuteur[] = new Interlocuteur($interlocuteur['id'], $interlocuteur['nom'], $interlocuteur['prenom'], $interlocuteur['telephone'], $interlocuteur['email'], $interlocuteur['societeID']);
     
 

$connexion = null;
require_once '../vues/vInterlocuteurs.php';
?>