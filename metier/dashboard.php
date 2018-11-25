<?php session_start();

if (isset($_SESSION['login'])) echo  "<!-- Utilisateur : ".$_SESSION['login']."-->";
else {
    $_SESSION['origine'] = "/metier/dashboard.php";
    header("Location:  http://".$_SERVER['SERVER_NAME']."/metier/login.php");
}

require_once '../DAO/connectDB.php';
require_once '../metier/societe.php';
require_once '../metier/Interlocuteur.php';

/**
 * Gestion du dashboard - Opreations de traitement
 * @author Philippe Cohen
 */

$sectionSubject = "Accueil";

/*
 * Traitements base de données
 */
$connexion = new connectDB();


//on recupere les societes
$societes = $connexion->selectFromWhere('*','societe','', '');


$interlocuteurs=null;
$societeEnCours;


if (isset($_POST['societe']) && $_POST['societe'] != '') {
    
    $sPOST = htmlentities($_POST['societe']);
    
    $societeID = $connexion->selectFromWhere('*','societe','nom', $sPOST);
    
    $societe = new societe($societeID[0]['id'], $societeID[0]['nom'], $societeID[0]['adresse'], $societeID[0]['telephone'], $societeID[0]['email']);
    
    $societeEnCours = $societe -> getNom();
    
    $tabInterlocuteurs = $connexion->selectFromWhere('*','Interlocuteur','societeID', $societe-> getId());
    
    foreach ($tabInterlocuteurs as $value) {
        
        $interlocuteurs[] = new Interlocuteur($value['id'], $value['nom'], $value['prenom'], $value['telephone'], $value['email'], $value['societeID']);
        
    }

} 
elseif (isset($_POST['nomInterlocuteur']) && $_POST['nomInterlocuteur'] != '') {
    
    $societeEnCours = $_POST['societeEnCours'];
    
    $societeID = $connexion->selectFromWhere('*','societe','nom', $societeEnCours);
    
    $nom = $_POST['nomInterlocuteur'];
    $socID = $societeID[0]['id'];
    $tabInterlocuteurs =  $connexion->selectFromWhereAnd('*', 'interlocuteur', 'nom', $nom, 'societeID', $socID);
    
    $interlocuteurEnCours = new Interlocuteur($tabInterlocuteurs[0]['id'], $tabInterlocuteurs[0]['nom'], $tabInterlocuteurs[0]['prenom'], $tabInterlocuteurs[0]['telephone'], $tabInterlocuteurs[0]['email'], $tabInterlocuteurs[0]['societeID']);

}

$connexion = null; //fermetur de la connexion
require_once '../vues/vDashboard.php';
?>