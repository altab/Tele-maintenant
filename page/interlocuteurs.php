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


// if(isset($_GET['action']) && $_GET['action']=='creerSociete') {
    
//     // On met la societe en BAse et on recupere son ID
//     $connexion->insertSociete($_GET['nomSociete'], $_GET['adresseSociete'], $_GET['telSociete'], $_GET['emailSociete']);
//     $idSociete = $connexion->selectLastId('societe', 'nom', $_GET['nomSociete']); //SELECT id FROM ticket WHERE interlocuteurID=2 ORDER BY id DESC LIMIT 0,1
//     $SocieteID = $idSociete['id'];  
    
//     //On créé l'objet issu de la saisie
//     $tabSociete = $connexion->selectFromWhere('*', 'societe', 'id', $SocieteID);
//     $societeEnCours = new Societe($tabSociete[0]['id'], $tabSociete[0]['nom'], $tabSociete[0]['adresse'], $tabSociete[0]['telephone'], $tabSociete[0]['email']);
    
//     $warning = "La société a été correctement ajoutée !";
    
// //    var_dump($societeEnCours);
    
// } elseif (isset($_GET['action']) && $_GET['action']=='modifierSociete') {
    
//     $SocieteID;
    
//     if (isset($_GET['idSociete']) && $_GET['idSociete']!='') {
        
//         $SocieteID = $_GET['idSociete'];
        
//         if (isset($_GET['nomSociete']) && $_GET['nomSociete']!='')
//             $connexion->updateRaw('societe', 'nom', $_GET['nomSociete'], 'id', $SocieteID);
//         if (isset($_GET['telSociete']) && $_GET['telSociete']!='')
//             $connexion->updateRaw('societe', 'telephone', $$_GET['telSociete'], 'id', $SocieteID);
//         if (isset($_GET['emailSociete']) && $_GET['emailSociete']!='')
//             $connexion->updateRaw('societe', 'email', $$_GET['emailSociete'], 'id', $SocieteID);
//         if (isset($_GET['adresseSociete']) && $_GET['adresseSociete']!='')
//             $connexion->updateRaw('societe', 'adresse', $$_GET['adresseSociete'], 'id', $SocieteID);
        
//     }
    
   
    
//     //On créé l'objet issu de la saisie
//     $tabSociete = $connexion->selectFromWhere('*', 'societe', 'id', $SocieteID);
//     $societeEnCours = new Societe($tabSociete[0]['id'], $tabSociete[0]['nom'], $tabSociete[0]['adresse'], $tabSociete[0]['telephone'], $tabSociete[0]['email']);
    
//     $warning = "La société a été mise à jour !";
    
// }


$connexion = null;
require_once '../vues/vInterlocuteurs.php';
?>