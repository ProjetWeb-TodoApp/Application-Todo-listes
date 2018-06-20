<?php
session_start();
	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 





// dans le GET, on admet qu'on reçois 'password' et 'login' 
case: "login":
	if ($login = valider("login"))
		if ($password = valider("password")){
			//On appelle bien la fonction de sécurisation, qui crée les variables de session suivantes:
			//$_SESSION['usr_login'] = $login;
			//$_SESSION['usr_id'] = $id;
			//$_SESSION['connexion_time'] = date("H:i:s");
			//$_SESSION['is_project_manager'] = is_project_manager($usr_id);
			//$_SESSION['online'] = true;
			
			//On appelle aussi la fonction is_project_manager() qui devra être faite dans modele
			verif_user($login,$password);
			}
	break;
			
			
 case: "logout":
 
 
 
 
 
 
 
// on pourra attribuer les realisateurs
//Entrées: $tsk_title, $tsk_description, $tsk_
 case: "new_task"
	new_task(
 
 case: "edit_task"
 // on pourra attribuer les realisateurs
 
 case: "remove_task"
 
 case: "done_task"
 // si on est bien le chef de pole, on peut dire que la tache est finie
 
 case: ""
?>