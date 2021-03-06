<?php session_start();
/**
 * Login utilisateurs
 *
 * @author Philippe Cohen
 */
require_once '../DAO/connectDB.php';
require_once '../metier/Utilisateur.php';

// recuperation des variables
if (isset($_SESSION['origine']) && $_SESSION['origine'] != '')
    $origine = $_SESSION['origine'];
else $origine = '';

if (isset($_POST['email']) && $_POST['email'] != '')
    $login = htmlentities(urldecode($_POST['email']));

if (isset($_POST['password']) && $_POST['password'] != '')
    $password = str_replace(' ', '', $_POST['password']);

if (isset($_GET['quitter']) && $_GET['quitter'] == 'Deconnexion')
    sessionDestroy($origine);

if (isset($login) && isset($password))     
    VerifLogin($login, $password, $origine);

    function sessionDestroy($origine)
{
    session_unset(); // unset $_SESSION variable for this page
    session_destroy();
    $_SESSION['origine'] = $origine;
}

function VerifLogin($login, $password, $origine)
{
    $connexion = new connectDB();
    $tabUtilisateur = $connexion->selectFromWhereAnd('*','utilisateur','email',$login, 'password', $password);

    if($tabUtilisateur) $utilisateur= new Utilisateur(  $tabUtilisateur[0]['id'], 
                                                        $tabUtilisateur[0]['nom'],
                                                        $tabUtilisateur[0]['prenom'], 
                                                        $tabUtilisateur[0]['email'], 
                                                        $tabUtilisateur[0]['password'], 
                                                        $tabUtilisateur[0]['icone'], 
                                                        $tabUtilisateur[0]['role'],
                                                        $tabUtilisateur[0]['actif']);

    if (isset($utilisateur) && $utilisateur->getActif() == 1) {
        
            $_SESSION['login'] = $utilisateur->getEmail();
            $_SESSION['role'] = $utilisateur->getRole();
            $_SESSION['utilisateurID'] = $utilisateur->getId();
            $_SESSION['nomUtilisateur'] = $utilisateur->getPrenom();
            $_SESSION['LAST_ACTIVITY'];
            
            if (isset($origine)) $urlOrigine = $origine; else $urlOrigine = '';
            
             header("Location:  http://" . $_SERVER['SERVER_NAME'] . $urlOrigine . "");

    } else {
        if (isset($login)) {
            
                if(isset($utilisateur) && $utilisateur->getActif() != 1)
                    header("Location:  http://" . $_SERVER['SERVER_NAME'] . "/page/login.php?connexion=enAttente");
                else
                    header("Location:  http://" . $_SERVER['SERVER_NAME'] . "/page/login.php?connexion=ko");
                
        } else 
                header("Location:  http://" . $_SERVER['SERVER_NAME'] . "/metier/login.php");

    }
    $connexion = null; //fermeture de la connexion
}


require_once '../vues/vLogin.php';