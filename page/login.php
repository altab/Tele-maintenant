<?php session_start();
/**
 * Login utilisateurs
 *
 * @author Philippe Cohen
 */
require_once '../DAO/connectDB.php';

// recuperation des variables
if (isset($_SESSION['origine']) && $_SESSION['origine'] != '')
    $origine = $_SESSION['origine'];
else $origine = "";

if (isset($_POST['email']) && $_POST['email'] != '')
    $login = htmlentities(urldecode($_POST['email']));

if (isset($_POST['password']) && $_POST['password'] != '')
    $password = str_replace(' ', '', $_POST['password']);

if (isset($_GET['quitter']) && $_GET['quitter'] == 'Deconnexion')
    sessionDestroy();

if (isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['password']) && $_POST['password'] != '')     
    VerifLogin($login, $password, $origine);

function sessionDestroy()
{
    session_unset(); // unset $_SESSION variable for this page
    session_destroy();
}

function VerifLogin($login, $password, $origine)
{
    $connexion = new connectDB();
    $utilisateurs = $connexion->selectFromWhere('*','users','','');

    foreach ($utilisateurs as $utilisateur) {

        if (($utilisateur['email'] == $login) && ($utilisateur['password'] == $password)) { //
            $_SESSION['login'] = $login;
            if (isset($origine)) $urlOrigine = $origine; else $urlOrigine = '';
            header("Location:  http://" . $_SERVER['SERVER_NAME'] . $urlOrigine . "");
        } else {
            if (isset($login))
                header("Location:  http://" . $_SERVER['SERVER_NAME'] . "/page/login.php?connexion=ko");
//             else
//                 header("Location:  http://" . $_SERVER['SERVER_NAME'] . "/metier/login.php");
         }
    }
    $connexion = null; //fermeture de la connexion
}

require_once '../vues/vLogin.php';