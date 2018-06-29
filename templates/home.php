<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=home");
    die("");
}


include_once("librairies/modele.php");
include_once("librairies/maLibUtils.php");
include_once("librairies/maLibForms.php");

if (!isset($_SESSION["usr_id"])) {
    header("Location:index.php?view=login");
    die("");
}


//on va chercher les prochaines tasks pour l'user connecté
$tasks = prompt_task_user($_SESSION["usr_id"]);
$usr_id=$_SESSION["usr_id"];

?>

<main class="l-main">
    <section class="l-section-small">
        <h2>Timeline</h2>
        <div id="timeline"></div>
    </section>
    <section class="l-section">
        <h2>Your Next Tasks</h2>
        <div class="tsk_list">
            <?php
            foreach ($tasks as $task) {

                echo "<div class='task task-listed";
                if (is_done($task['id'])) echo " done";
                elseif (deadline_task($task['id']) < date("Y-m-d")) echo " late";
                echo "'>";

            echo "<h3>";
            if (is_group_manager($usr_id, task_group($task["id"]))) {
                echo "<a href=index.php?view=task_edition&tsk_id=$task[id]>";
            }
            echo "$task[title]";
            if (is_group_manager($usr_id, task_group($task["id"]))) {
                echo "</a>";}
                echo "</br><small>$task[deadline]</small>";
                echo "<p>$task[description]</p>";
                //si la tâche est réalisée on affiche OK
                if (is_done($task['id'])) echo " <strong>Done</strong>";
                echo "</div>";
            }
            ?>
            <!--            <div class="task task-listed"></div>
                        <div class="task task-listed"></div>
                        <div class="task task-listed"></div>-->
        </div>
    </section>

</main>

<script type="text/javascript" defer>
    let tasks =<?php echo json_encode($tasks)?>;
    let today = new Date();
    let str_today = today.toISOString().slice(0, 10).replace(/-/g, "/");
    //console.log(Date.parse(today));
    let timeline_tasks = [{'date': str_today, 'name': 'Today', 'description': "", 'background': 'var(--accent-color)'}];
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
