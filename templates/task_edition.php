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


<script src="js/jquery-3.3.1.min.js"></script>

<!-- On récupère la librairie jquery -->
<script>
    // ce script se base sur une des versions des paragraphes éditables développée pendant le td TinyCMS
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
                $("#checklist").append(clone);
            });
        // insertion btn "+" dans la page
        $("#checklist")
            .after(jBtnPlus)
            .after('<input type="text" />');

    }); // fin ready


</script>
</head>

<main>
    <section class="l-section">

        <?php
        $tsk_id = getValue("tsk_id");

        // si on n'a pas d'id de conversation dans l'url on renvoie vers la vue task
        if (!$tsk_id) {
            header("Location:index.php?view=task");
            die("La tâche n'existe pas ");
        }
        $usr_id = $_SESSION["usr_id"];
        // on récupère toutes les données de la table task pour l'id tsk_id
        $tsk_data = prompt_task($tsk_id)[0];
        $grp_id = $tsk_data["id_group"];
        $current_date = date("Y-m-d");
        $deadline = $tsk_data["deadline"];
        $tab_grp_members = grp_members($grp_id); // les membres du pôle
        $description = $tsk_data["description"];

        echo "<h1>" . $tsk_data['title'] . "</h1>";

        if ($msg = valider('msg')) {
            echo('<p class="alerte">' . $msg . '</p>');
        }

        echo "<form action='controller.php' method='GET'>";

        // on récupère l'id de la conversation à éditer dans le form via un champ caché
        echo "<input  name='tsk_id' value = $tsk_id type='hidden' />";
        //on récupère de la même manière la date de soumission du formulaire, on aura ainsi la date de réalisation de la tâche si on la valide
        echo "<input  name='date' value = $current_date type='hidden' />";
        // on récupère également l'id du groupe concerné par la tâche
        echo "<input  name='grp_id' value = $grp_id type='hidden' />";


        echo "<p> Supprimer la tâche </p>";
        echo "<button type = 'submit' name='action' value='delete'>Delete</button>";

        // le bouton valider sert à indiquer si la tâche a été complétée
        echo "<p> Valider la tâche </p>";
        echo "<br>" . "<button type = 'submit' name='action' value='validate' >Validate</button>";


        //on affiche la valeur actuelle de chaque caractéristique de la tâche et on ajoute les éditions
        //Deadline
        echo "<p>Deadline : $deadline </p>";
        echo "<input type='date' name='tsk_deadline' />";
        echo "<br>";

        //Personnes réalisant la tâche
        echo "<p> Who works on this task? </p>";
        foreach ($tab_grp_members as $member) {
            //on pré-check la checkbox si la personne est déjà assignée à la tâche
            if (is_task_member($tsk_id, $member["id"]))
                echo "<input type='checkbox' name='$member[id]' id='$member[id]' checked>";
            else
                echo "<input type='checkbox' name='$member[id]' id='$member[id]' >";
            echo "<label for $member[id]>";
            echo " $member[first_name] $member[last_name]";
            echo "</label>";
        }

        //Description
        echo " <p> Describe your task </p>";
        echo "<textarea name='tsk_description'> $description </textarea>";

        //Dépendances
        echo " <p> This tasks depends on </p>";


        // Checklist
        echo "<div id='checklist'>
        </div>
        <br>";

        echo "<button type='submit' name='action' value='edit_task'>Edit Task</button>";

        echo "</form>";
        ?>

    </section>
</main>








