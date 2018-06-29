<?php
// on récupère toutes les fonctions dans les diverses librairies et celles développées dans modele.php
include_once("librairies/modele.php");
include_once("librairies/maLibUtils.php");
include_once("librairies/maLibForms.php");


// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "group.php") {
    header("Location:../index.php?view=group&grp_id=$grp[id]");
    die("");
}
//ON GARDE LA CONFIDENTIALITE, ON NE PEUT VENIR QU'EN ETANT CONNECTE
if (!isset($_SESSION["usr_id"])) {
    header("Location:index.php?view=login");
    die("");
}


if ($grp_id = valider('grp_id')) {

    $grp_tasks = prompt_task_group($grp_id);

}


?>

<main class="l-main">
    <section class="l-section-small">
        <h2>Timeline</h2>
        <div id="timeline"></div>

    </section>

    <section class="l-section">
        <h2> Team's tasks </h2>
        <?php
        //On vérifie bien que l'utilisateur a le droit d'aller sur la réation de tache
        $usr_id = $_SESSION["usr_id"];
        if (is_group_manager($usr_id, $grp_id)) {
            echo " <a href='index.php?view=task_creation&grp_id=$grp_id'><button>Add a new task</button></a>";
        }

        ?>
        <div class="tsk_list">
            <?php
            if ($grp_id = valider('grp_id')) {
                $grp_tasks = prompt_task_group($grp_id);
            }
            //Chaque tache constitue un lien qui renvoie vers la page de l'edition de cette tache.
            // Le lien n'appparait que si l'utilisateur est en droit de la modifier
            //On vérifie bien que l'utilisateur a le droit d'aller sur la réation de tache
            $usr_id = $_SESSION["usr_id"];
            foreach ($grp_tasks as $task) {




                echo "<div class='task task-listed";
                if (is_done($task['id'])) echo " done";
                elseif (deadline_task($task['id']) < date("Y-m-d")) echo " late";
                echo "'>";

                if ((is_group_manager($usr_id, $grp_id)) ) {
                    echo "<a href=index.php?view=task_edition&tsk_id=$task[id]>";
                }
                echo "<h3>$task[title]</h3>";
                echo "<small>$task[deadline]</small>";
                echo "</br><h4>Réalisateurs : </h4>";
                $members=prompt_user_task($task["id"]) ;
                for ($i=0; $i<count($members);$i++){
                    echo $members[$i]["first_name"][0]." ";
                    echo $members[$i]["last_name"];
                    if($i!=count($members)-1){echo", ";}

                }
                echo "<p>$task[description]</p>";

                //si la tâche est réalisée on affiche OK

                if (is_group_manager($usr_id, $grp_id)) {
                    echo "</a>";
                }

                if (is_done($task['id'])) echo "<strong>Done</strong>";
                echo "</div>";


            }
            ?>
        </div>


    </section>
</main>
<script type="text/javascript" defer>
    let tasks =<?php echo json_encode($grp_tasks)?>;
    console.log(tasks);
    let today = new Date();
    today = today.toISOString().slice(0, 10).replace(/-/g, "/");
    let timeline_tasks = [{'date': today, 'name': 'Today', 'description': "", 'background': 'var(--accent-color)'}];
    for (let task of tasks) {
        if (task['completion_date'] === null) {
            let date_task = Date.parse(task['deadline']);
            //console.log(date_task);
            //console.log(date_task >= Date.parse(today));
            if (date_task > Date.parse(today)) {
                //console.log(task);
                timeline_tasks.push({
                    'name': task['title'],
                    'description': task['description'],
                    'date': task['deadline']
                })
            }
            else {
                timeline_tasks.push({
                    'name': task['title'],
                    'description': task['description'],
                    'date': task['deadline'],
                    'background': 'var(--alert-color)'
                })
            }
        }
    }
    console.log(timeline_tasks);

    Timeknots_modified.draw("#timeline", timeline_tasks, {
        horizontalLayout: false, height: 450, width: 200, showLabels:
            true, labelFormat: "%d/%m/%Y", dateFormat: "%d/%m/%Y"
    });

</script>




