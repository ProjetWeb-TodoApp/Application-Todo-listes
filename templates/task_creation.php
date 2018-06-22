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

// on se place sur le bon fuseau horaire
date_default_timezone_set('Europe/Paris');
?>

<html>
<head>
    <title>Create a task</title>
<script>
    var jT = $("<textarea>")
		.keydown(function(contexte){
			// saisie dans textarea
			// contexte représente le contexte de l'event,
			// automatiquement passé par jquery aux fonctions de rappel
			if ( (contexte.originalEvent.keyCode == 13)
					&& (!contexte.originalEvent.shiftKey)	) {
				// on réinsère un paragraphe à la place du textarea
				// dans lequel on vient d'appuyer sur entrée
				var clone = jP.clone(true);
				// $(this) dénote le textarea
				clone.html($(this).val());
				$(this).replaceWith(clone);
			}
			// 13 <=> Entrée
			// 27 <=> Escape
		});

// structure "modele" par défaut des nouveaux paragraphes
var jP = $("<p>New checklist item/p>")
		.click(function(){
			// click sur P.
			var contenu = $(this).html(); // contenu du P.
			var clone = jT.clone(true); // clonage du modele de textarea
			clone.val(contenu); // remplissage avec contenu du P. cliqué
			$(this).replaceWith(clone); 	// insertion du textarea à la place du P.
			clone.focus(); // le curseur doit se placer dans ce textarea
			// On ajoute une méta-donnée à ce clone
			clone.data("contenuInitial",contenu);
		});

// lorsque le navigateur a chargé la page...
$(document).ready(function(){

	// Appui sur ESCAPE
	$(document).keyup(function(contexte){
		console.log("appui sur " + contexte.originalEvent.keyCode);
		// OBJ : parcourir tous les textarea
		// restaurer leur contenu initial dans un P.
		$("#contenu textarea").each(function(){
			// itérateur each : on parcourt tous les resulats, un à la fois
			// $(this) dénote le textarea en cours de parcours !!!
			console.log("Contenu actuel : " + $(this).val() );
			console.log("Contenu initial : " + $(this).data("contenuInitial") );
		});
	});

	// Clic sur BTN "+"
	var jBtnPlus = $('<input type="button" />')
			.val("+")
			.click(function(){
				console.log("click +");
				// ajouter un P. au div contenu
				// en utilisant le contenu
				// du champ de saisie s'il y en a un

				var contenu = $(this).prev().val();
				var clone = jP.clone(true);
				// on clone aussi son comportement
				if (contenu) clone.html(contenu);
				$("#checklist").prepend(clone);

			}); // fin clic sur "+"


	// insertion btn "+" dans la page
	$("h1")
		.after(jBtnPlus)
		.after('<input type="text" />');

}); // fin ready

</script>
</head>

<body>
<h1> Create a new task</h1>
<div>

    <form action="controller.php">
        <input type="text" name="tsk_name" value="Task name">
        <!--Chose the deadline-->
        <legend>Deadline</legend>
        <!-- le type date est un champ HTML 5, qui peut contenir une date au format RFC 3339 -->
        <input type="date" name="Deadline">
        </select>

        <br/>

        <!-- on s'est basé pour ce champ sur le TEA Suggest -->
        Choose who will work on this task
        <?php

/*        $tab_grp_members = grp_members($_SESSION["usr_id"]);
        foreach ($tab_grp_members as $member) {
            echo "<input type='checkbox' id='cb'.$member >";
            echo "<label for 'cb'.$member>";
            echo $member['name'] . " " . $member['lastname'];
            echo "</label>";
        }*/

        ?>

        Describe your task :
        <input type = "textarea" id="description">

        Does this task need any of the other tasks completed ?
        <?php

        $tab_grp_tasks = prompt_task_group($_SESSION["usr_id"]);
  /*      foreach ($tab_grp_tasks as $task) {
            echo "<input type='checkbox' id='cb'.$task >";
            echo "<label for 'cb'.$task>";
            echo $task['title'];
            echo "</label>";
        } */
        ?>

        What are the steps for completing this task ?
        <!-- on s'est ici basé sur la structure de paragraphes éditables de tinyCMS -->
        <div id="checklist">
        </div>
        <input type="submit" action="new_task" value="Create task">
    </form>


</div>
</body>
</html>