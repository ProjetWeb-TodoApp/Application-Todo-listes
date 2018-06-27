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

</head>

<body>
<?php
$tsk_id=getValue("tsk_id");

// si on n'a pas d'id de conversation dans l'url on renvoie vers la vue task
if(!$tsk_id ) {
    header("Location:index.php?view=task");
    die("La tâche n'existe pas ");
}
$usr_id=$_SESSION["usr_id"];
// on récupère toutes les données de la table task pour l'id tsk_id
$tsk_data=prompt_task($tsk_id)[0];
$grp_id=$tsk_data["id_group"];

echo "<h1>".$tsk_data['title']."</h1>";

?>
<?php
 echo "<form action='controller.php' method='GET'>";
// on récupère l'id de la conversation à éditer dans le form via un champ caché

echo "<input  name='tsk_id' value = $tsk_id type='hidden' />";
echo "<input type = 'submit' name='action' value='delete' />";

echo "</form>";

 ?>

</body>
</html>









