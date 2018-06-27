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
?>

<html>
<head>
    <title>To-do list</title>
</head>

<body>
    <h1> To-do list</h1>
    <div id="usr_tasks">
        <h3> Your tasks </h3>
        <?php
        $tasks= prompt_task_user($_SESSION["usr_id"]);
        mKTable($tasks);
        ?>
    </div>

    <div id = "grp_tasks">
        <h3> Team's tasks </h3>
        <?php
        $user=$_SESSION["usr_id"];
        if (canEdit($user)) {
            echo " <a href='index.php?view=task_creation'>Add a new task</a>";
}
       $grp_tsk=prompt_task_group($user);
        mkTable($grp_tsk);
        ?>

    </div>
</body>
</html>
