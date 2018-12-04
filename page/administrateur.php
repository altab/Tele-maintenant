<?php session_start();
require_once '../includes/session.php';


require_once '../DAO/connectDB.php';
$connexion = new connectDB();


require_once '../metier/Utilisateur.php';

/**
 * Gestion des tickets - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Administrateur";


$listeUtilisateurs;
$utilisateurEnCours;



if ((isset($_GET['action']) && $_GET['action'] == 'majUtilisateur') 
 && (isset($_GET['utilisateurID']) && $_GET['utilisateurID'] !='')) {
    
     $connexion->updateUtilisateur( $_GET['utilisateurID'], 
                                    $_GET['nom'], 
                                    $_GET['prenom'], 
                                    $_GET['email'], 
                                    $_GET['icone'], 
                                    $_GET['role'], 
                                    $_GET['actif'] );
    
}

if ((isset($_GET['action']) && $_GET['action'] == 'supprimerUtilisateur')
    && (isset($_GET['utilisateurID']) && $_GET['utilisateurID'] !='')) {
        
        $connexion->deleteArrayFrom('utilisateur', 'id', $_GET['utilisateurID']);
        
    }


if (isset($_GET['action']) && $_GET['action'] == 'modifierUtilisateur') {
    
    if (isset($_GET['utilisateurID']) && $_GET['utilisateurID'] !='') {
        
        $tabUtilisateurEnCours = $connexion->selectFromWhere('*', 'utilisateur', 'id', $_GET['utilisateurID']);
        
        $utilisateurEnCours = new Utilisateur(  $tabUtilisateurEnCours[0]['id'], 
                                                $tabUtilisateurEnCours[0]['nom'], 
                                                $tabUtilisateurEnCours[0]['prenom'], 
                                                $tabUtilisateurEnCours[0]['email'], 
                                                $tabUtilisateurEnCours[0]['password'], 
                                                $tabUtilisateurEnCours[0]['icone'], 
                                                $tabUtilisateurEnCours[0]['role'], 
                                                $tabUtilisateurEnCours[0]['actif'] );
        
    }
    
}

// On reconstruit le tableau des utlisateurs
$tabUtilisateurs = $connexion->selectFromWhere('*', 'utilisateur', '', '');
foreach ($tabUtilisateurs as $utilisateur) {
    $listeUtilisateurs[] =  new Utilisateur($utilisateur['id'],
                                            $utilisateur['nom'],
                                            $utilisateur['prenom'],
                                            $utilisateur['email'],
                                            $utilisateur['password'],
                                            $utilisateur['icone'],
                                            $utilisateur['role'],
                                            $utilisateur['actif']);
}

$infosUtilisateur = $connexion->InfoUtilisateur($_SESSION['utilisateurID']);

require_once '../vues/vadministrateur.php';
?>