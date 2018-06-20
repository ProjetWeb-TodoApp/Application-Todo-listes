<?php
session_start();
	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 





// dans le GET, on admet qu'on reçois 'password' et 'login' 
case: "login"
	if ($login = valider("login"))
		if ($passe = valider("password")){
			
 case: "logout"
 
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