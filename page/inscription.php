<?php session_start();

/**
 * Gestion des tickets - Opreations de traitement
 * @author Philippe Cohen
 */
$sectionSubject = "Inscription";

require_once '../metier/Utilisateur.php';
require_once '../DAO/connectDB.php';

$connexion = new connectDB();




if (isset($_POST['action']) && $_POST['action'] == 'creerUtilisateur' ) {
    
    if($_POST['password'] == $_POST['confirmPassword']) {
        
        try {   
            $connexion->insertUtilisateur($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password'], $_POST['role']);
            $warning = "Utilisateur ajouté, validation par l'administrateur en attente.";
            $warningColor = "bg-success text-white";        
        } catch (PDOException $e) {         
            $warning = "Désolé cette adresse email à déjà été utilisée !";
            $warningColor = "bg-danger text-white";            
        }
        
        
    } else {
        
        $warning = "Problème de correspondance des mots de passe !";
        $warningColor = "bg-danger text-white";
    }
   
}



require_once '../vues/vInscription.php';
?>