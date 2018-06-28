<?php


include_once "maLibUtils.php";    // Car on utilise la fonction valider()
include_once "modele.php";    // Car on utilise la fonction connecterUtilisateur()
//console.log("dans maLibSecurisation");
/**
 * @file login.php
 * Fichier contenant des fonctions de vérification de logins
 */

/**
 * Cette fonction vérifie si le login/passe passés en paramètre sont légaux
 * Elle stocke les informations sur la personne dans des variables de session : session_start doit avoir été appelé...
 * Infos à enregistrer : pseudo, idUser, heureConnexion, isAdmin
 * Elle enregistre l'état de la connexion dans une variable de session "connecte" = true
 * L'heure de connexion doit être stockée au format date("H:i:s")
 * @pre login et passe ne doivent pas être vides
 * @param string $login
 * @param string $password
 * @return false ou true ; un effet de bord est la création de variables de session
 */
function check_user($login, $password)
{
	//console.log("dans check_user");
    $usr_id = check_user_BDD($login, $password);
    if ($usr_id != false) {
        $_SESSION['usr_login'] = $login;
        $_SESSION['usr_id'] = $usr_id;
        $_SESSION['connection_time'] = date("H:i:s");
		//besoin de "is_project_manager" qui renvoie true ou false.
        $_SESSION['is_project_manager'] = is_project_manager($usr_id);
        $_SESSION['online'] = true;
		//console.log("variables crées");
        return (true);
    }
    return (false);
}


/**
 * Fonction à placer au début de chaque page privée
 * Cette fonction redirige vers la page $urlBad en envoyant un message d'erreur
 * et arrête l'interprétation si l'utilisateur n'est pas connecté
 * Elle ne fait rien si l'utilisateur est connecté, et si $urlGood est faux
 * Elle redirige vers urlGood sinon
 */
function securiser($urlBad, $urlGood = false)
{
    $usr_id = valider("usr_id", "SESSION");
    if ($idUser==false) {
        header("Location :" . $urlBad . '&msg = ' .urlencode('utilisateur non-connecté'));
    }
    elseif ($urlGood!=false) {
        header("Location :" . $urlGood);
    }
}


