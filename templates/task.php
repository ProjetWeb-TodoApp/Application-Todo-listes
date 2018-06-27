<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "task.php") {
    header("Location:../index.php?view=task");
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


?>
<main class="l-main">
   
    <section class="l-section">
        <h3> Your tasks </h3>
        <?php
        $tasks= prompt_task_user($_SESSION["usr_id"]);
        ?>
		<div class="usr_next_tasks">
            <?php
			//Chaque tache constitue un lien qui renvoie vers la page de l'edition de cette tache.
			// Le lien n'appparait que si l'utilisateur est en droit de la modifier
			$user=$_SESSION["usr_id"];
            foreach ($tasks as $task) {
				
				
				if (is_group_manager($user)) {echo "<a href=index.php?view=task_edition&tsk_id='$task[id]'>";}
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

    <section class="l-section">
        <h3> Team's tasks </h3>
        <?php
        $user=$_SESSION["usr_id"];
        if (is_group_manager($user)) {
            echo " <a href='index.php?view=task_creation'><button>Add a new task</button></a>";
		}
		$grp_tsk=prompt_task_group($user);
        ?>
		<div class="grp_next_tasks">
            <?php
			//Chaque tache constitue un lien qui renvoie vers la page de l'edition de cette tache.
			// Le lien n'appparait que si l'utilisateur est en droit de la modifier
			$user=$_SESSION["usr_id"];
            foreach ($grp_tsk as $task) {
				
				if (is_group_manager($user)) {echo "<a href=index.php?view=task_edition&tsk_id='$task[id]'>";}
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
