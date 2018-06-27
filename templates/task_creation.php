<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "task_creation.php") {
    header("Location:../index.php?view=task_creation");
    die("");
}

// on récupère toutes les fonctions dans les diverses librairies et celles développées dans modele.php
include_once("librairies/modele.php");
include_once("librairies/maLibUtils.php");
include_once("librairies/maLibForms.php");

//ON GARDE LA CONFIDENTIALITE, ON NE PEUT VENIR QU'EN ETANT CONNECTE
if (!isset($_SESSION["usr_id"])){
	header("Location:index.php?view=login");
    die("");
}

// Si l'utilisatur n'a pas le droit d'être ici, on le renvoi vers task
if (!is_group_manager($_SESSION["usr_id"])){
	header("Location:index.php?view=task");
    die("");
}

// on se place sur le bon fuseau horaire
date_default_timezone_set('Europe/Paris');
?>

<html>
<head>
    <title>Create a task</title>

    <script src="js/jquery-3.3.1.min.js"></script>

    <!-- On récupère la librairie jquery -->
    <script>
        // structure par défaut des nouveaux paragraphes
        var jP = $("<p>New Checklist Item</p>");

        // lorsque le navigateur a chargé la page...
        $(document).ready(function () {

            var jBtnPlus = $('<input type="button" />')
                .val("+")
                .click(function () {
                    console.log("click +");
                    // ajouter un P. au div contenu
                    // en utilisant le contenu
                    // du champ de saisie s'il y en a un

                    var contenu = $(this).prev().val();
                    var clone = jP.clone();
                    if (contenu) clone.html(contenu);
                    clone.prepend('<input type="checkbox"/>');
                    $("#checklist").append( clone);
                });
            // insertion btn "+" dans la page
            $("#checklist")
                .after(jBtnPlus)
                .after('<input type="text" />');

        }); // fin ready


    </script>

<main>

<section class="l-section">
    <form action="controller.php">
		<?php
		$grp_id=valider("grp_id");
		echo "<input type='hidden' name='grp_id' value='$grp_id'>"
        ?>
		<input type="text" name="tsk_name" value="Task name">
        <!--Chose the deadline-->
        <legend>Deadline</legend>
        <!-- le type date est un champ HTML 5, qui peut contenir une date au format RFC 3339 -->
        <input type="date" name="tsk_deadline">
        </select>

        <br/>


        <p>Choose who will work on this task</p>
        <?php
		$grp_id=valider("grp_id");
        $tab_grp_members = grp_members($grp_id);
         foreach ($tab_grp_members as $member) {
             echo "<input type='checkbox' name='$member[id]' id='$member[id]'>";
             echo "<label for $member[id]>";
             echo "$member[first_name] $member[last_name]";
             echo "</label>";
        }
 
        ?>
        <br/>
        <p>Describe your task :</p>
        <input type="textarea" name="tsk_description">
        <br/>
        <!--<p>Does this task need any of the other tasks completed ?</p>
        <?php

        /*      $tab_grp_tasks = prompt_task_group($_SESSION["usr_id"]);
         foreach ($tab_grp_tasks as $task) {
                  echo "<input type='checkbox' id='cb'.$task >";
                  echo "<label for 'cb'.$task>";
                  echo $task['title'];
                  echo "</label>";
             }
           */ ?>
        <br/>
        <p>What are the steps to complete this task ?</p>
        <!-- l'édition des items de checklist va se faire en ajax sur la base du tp TinyCMS -->

        <div id="checklist">
        </div>
        <br>
        <input type="submit" action="new_task" value="Create task">
    </form>

</section>
</main>