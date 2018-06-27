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
if (!isset($_SESSION["usr_id"])){
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
       <h3> Team's tasks </h3>
        <?php
        $user=$_SESSION["usr_id"];
        if (is_group_manager($user)) {
            echo " <a href='index.php?view=task_creation&grp_id=$grp_id'><button>Add a new task</button></a>";
		}
	
        ?>
		<div class="grp_next_tasks">
            <?php
			if ($grp_id= valider('grp_id')) {
			$grp_tasks = prompt_task_group($grp_id);}
			//Chaque tache constitue un lien qui renvoie vers la page de l'edition de cette tache.
			// Le lien n'appparait que si l'utilisateur est en droit de la modifier
			$user=$_SESSION["usr_id"];
            foreach ($grp_tasks as $task) {
				
				if (is_group_manager($user)) {echo "<a href=index.php?view=task_edition&tsk_id=$task[id]>";}
                echo "<div class='task task-listed'>";
                echo "<h3>$task[title]</h3>";
                echo "<small>$task[deadline]</small>";
                echo "<p>$task[description]</p>";
                echo "</div>";
				if (is_group_manager($user)) {echo "</a>";}
            }
            ?>
        </div>
		
		
	</section>
</main>
<script type="text/javascript" defer>
    let tasks =<?php echo json_encode($grp_tasks)?>;
    console.log(tasks);
    let today = new Date();
    today= today.toISOString().slice(0,10).replace(/-/g,"/");
    let timeline_tasks = [{'date': today, 'name': 'Today', 'description': "",'background':'var(--accent-color)'}];
    for (let task of tasks) {
        console.log(task);
        timeline_tasks.push({'name': task['title'], 'description': task['description'], 'date': task['deadline']})
    }
    console.log(timeline_tasks);

    Timeknots_modified.draw("#timeline", timeline_tasks, {
        horizontalLayout: false, height: 450, width: 200, showLabels:
            true, labelFormat: "%d/%m/%Y", dateFormat: "%d/%m/%Y"
    });


</script>




