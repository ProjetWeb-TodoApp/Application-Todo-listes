<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "task_edition.php") {
    header("Location:../index.php?view=task_edition");
    die("");
}

// on récupère toutes les fonctions dans les diverses librairies et celles développées dans modele.php
include_once("librairies/modele.php");
include_once("librairies/maLibUtils.php");
include_once("librairies/maLibForms.php");

// on se place sur le bon fuseau horaire
date_default_timezone_set('Europe/Paris');
?>


<html>
<head>
    <title>Edit a task</title>
<head>

<div>Delete a task </div>

<?php

$usr_id = $_SESSION['usr_id'];
$id_group = prompt_group_user($usr_id);


if ("is_group_manager($usr_id)") {
	
	
	$task =  prompt_task_group($id_group); 

	mkForm("controller.php");
	mkSelect("id_task",$task,"id","theme", valider("id_task"));
	mkInput("submit","action","Delete");
	endForm();
}

?>





</body>
</html>




