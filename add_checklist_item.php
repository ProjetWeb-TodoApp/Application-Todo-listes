<?php

/* cette page va servir d'interface pour la gestion de l'ajout des items de checklist en ajax et jquery */

include_once("config_bdd.php");

// on récupère toutes les fonctions dans les diverses librairies et celles développées dans modele.php

include_once("librairies/modele.php");
include_once("librairies/maLibUtils.php");
include_once("librairies/maLibForms.php");


$item = $_GET['item']; /* on récupère le nouvel item de checklist à ajouter*/

$SQL1="select max(id) from task";
$tsk_id= SQLSelect($SQL1)+1;
/*Pour connaître l'id auquel il faut rattacher l'item, ie l'id que prendra la tâche en cours de création, on récupère l'id max dans
 la base de données et on l'augmente de 1. Ce sera bien la valeur voulue puisque l'id est auto-incrémenté*/

$sql = "insert into checklist ('id_task', 'state', 'title') values ('$tsk_id', '0', '$item')";
SQLInsert($sql);

 /*  while ($row = mysql_fetch_assoc($query)) {

        $task_id = $row['id'];

        $task_name = $row['task'];

    }



    mysql_close();



    echo '<li><span>' . $task_name . '</span><img id="' . $task_id . '" class="delete-button" width="10px" src="images/close.svg" /></li>';
*/
?>
